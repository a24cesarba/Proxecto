#!/usr/bin/env python3

import os
import time
import logging
import threading
from flask import Flask, request, jsonify

try:
    import docker
except ImportError:
    raise SystemExit("Instalar dependencia: pip install docker")

# ── Config via variables de entorno ──────────────────────────────────────────
SERVICE_NAME        = os.getenv("AUTOSCALE_SERVICE",    "app_web")
MIN_REPLICAS        = int(os.getenv("AUTOSCALE_MIN",    "3"))
MAX_REPLICAS        = int(os.getenv("AUTOSCALE_MAX",    "9"))
SCALE_UP_BY         = int(os.getenv("SCALE_UP_BY",     "1"))
SCALE_DOWN_BY       = int(os.getenv("SCALE_DOWN_BY",   "1"))
COOLDOWN_UP         = int(os.getenv("SCALE_UP_COOLDOWN",   "120"))  # segundos
COOLDOWN_DOWN       = int(os.getenv("SCALE_DOWN_COOLDOWN", "300"))  # segundos
LOG_LEVEL           = os.getenv("LOG_LEVEL",            "INFO")

# ── Logging ───────────────────────────────────────────────────────────────────
logging.basicConfig(
    level=getattr(logging, LOG_LEVEL.upper(), logging.INFO),
    format="%(asctime)s [%(levelname)s] %(message)s",
    datefmt="%H:%M:%S",
)
log = logging.getLogger("autoscaler")

# ── Docker client ─────────────────────────────────────────────────────────────
try:
    docker_client = docker.DockerClient(base_url="unix:///var/run/docker.sock")
    docker_client.ping()
    log.info("Conectado a Docker daemon OK")
except Exception as exc:
    raise SystemExit(f"No se puede conectar al Docker socket: {exc}")

# ── Estado de cooldown (thread-safe) ─────────────────────────────────────────
_lock              = threading.Lock()
_last_scale_up     = 0.0
_last_scale_down   = 0.0

# ── Flask app ─────────────────────────────────────────────────────────────────
app = Flask(__name__)


def get_replicas() -> int:
    """Devuelve el número actual de réplicas del servicio."""
    svc = docker_client.services.get(SERVICE_NAME)
    spec = svc.attrs.get("Spec", {})
    mode = spec.get("Mode", {})
    replicated = mode.get("Replicated", {})
    return replicated.get("Replicas", 0)


def set_replicas(new_count: int) -> None:
    """Escala el servicio a new_count réplicas."""
    svc = docker_client.services.get(SERVICE_NAME)
    svc.scale(new_count)
    log.info("✓ Escalado %s → %d réplicas", SERVICE_NAME, new_count)


def scale_up() -> str:
    """Intenta escalar hacia arriba respetando max y cooldown."""
    global _last_scale_up
    now = time.monotonic()

    with _lock:
        elapsed = now - _last_scale_up
        if elapsed < COOLDOWN_UP:
            msg = (f"Scale-up ignorado: cooldown activo "
                   f"({COOLDOWN_UP - elapsed:.0f}s restantes)")
            log.info(msg)
            return msg

        current = get_replicas()
        if current >= MAX_REPLICAS:
            msg = f"Ya en máximo de réplicas ({MAX_REPLICAS}), no se escala"
            log.info(msg)
            return msg

        new_count = min(current + SCALE_UP_BY, MAX_REPLICAS)
        set_replicas(new_count)
        _last_scale_up = now
        return f"Scale-up: {current} → {new_count}"


def scale_down() -> str:
    """Intenta escalar hacia abajo respetando min y cooldown."""
    global _last_scale_down
    now = time.monotonic()

    with _lock:
        elapsed = now - _last_scale_down
        if elapsed < COOLDOWN_DOWN:
            msg = (f"Scale-down ignorado: cooldown activo "
                   f"({COOLDOWN_DOWN - elapsed:.0f}s restantes)")
            log.info(msg)
            return msg

        current = get_replicas()
        if current <= MIN_REPLICAS:
            msg = f"Ya en mínimo de réplicas ({MIN_REPLICAS}), no se escala"
            log.info(msg)
            return msg

        new_count = max(current - SCALE_DOWN_BY, MIN_REPLICAS)
        set_replicas(new_count)
        _last_scale_down = now
        return f"Scale-down: {current} → {new_count}"


# ── Endpoints ─────────────────────────────────────────────────────────────────

@app.route("/webhook", methods=["POST"])
def webhook():
    """
    Recibe el payload de Alertmanager.
    Formato esperado: https://prometheus.io/docs/alerting/latest/notifications/
    """
    payload = request.get_json(force=True, silent=True)
    if not payload:
        log.warning("Webhook recibido sin JSON válido")
        return jsonify({"status": "error", "message": "invalid JSON"}), 400

    results = []

    for alert in payload.get("alerts", []):
        alertname = alert.get("labels", {}).get("alertname", "")
        action    = alert.get("labels", {}).get("action", "")
        status    = alert.get("status", "")   # 'firing' o 'resolved'

        log.info("Alerta recibida: name=%s status=%s action=%s",
                 alertname, status, action)

        if alertname == "WebHighCpu":
            if status == "firing":
                result = scale_up()
            elif status == "resolved":
                result = scale_down()
            else:
                result = f"Estado desconocido: {status}"

        elif alertname == "WebLowCpu":
            if status == "firing":
                result = scale_down()
            else:
                result = f"WebLowCpu resolved — sin acción"

        else:
            result = f"Alerta '{alertname}' no gestionada por este autoscaler"
            log.debug(result)

        results.append({"alert": alertname, "result": result})
        log.info(result)

    return jsonify({"status": "ok", "processed": results}), 200


@app.route("/status", methods=["GET"])
def status():
    """Estado actual del servicio gestionado."""
    try:
        replicas = get_replicas()
        return jsonify({
            "service":        SERVICE_NAME,
            "replicas":       replicas,
            "min":            MIN_REPLICAS,
            "max":            MAX_REPLICAS,
            "cooldown_up_remaining":   max(0, COOLDOWN_UP   - (time.monotonic() - _last_scale_up)),
            "cooldown_down_remaining": max(0, COOLDOWN_DOWN - (time.monotonic() - _last_scale_down)),
        }), 200
    except Exception as exc:
        return jsonify({"status": "error", "message": str(exc)}), 500


@app.route("/healthz", methods=["GET"])
def health():
    """Health check para Docker Swarm restart_policy."""
    return "ok", 200


# ── Arranque ──────────────────────────────────────────────────────────────────
if __name__ == "__main__":
    log.info(
        "Autoscaler arrancando: service=%s min=%d max=%d",
        SERVICE_NAME, MIN_REPLICAS, MAX_REPLICAS,
    )
    app.run(host="0.0.0.0", port=5000, threaded=False)
