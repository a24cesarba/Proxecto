from flask import Flask, request
import docker, time

app    = Flask(__name__)
client = docker.from_env()

SERVICE      = "app_web"
MIN_REPLICAS = 3
MAX_REPLICAS = 9
COOLDOWN     = {"up": 120, "down": 300}
ACTIONS      = {"scale_up": ("up", +1), "scale_down": ("down", -1)}
_last        = {"up": 0.0, "down": 0.0}

@app.route("/webhook", methods=["POST"])
def webhook():
    payload = request.get_json(force=True, silent=True) or {}
    for alert in payload.get("alerts", []):
        if alert.get("status") != "firing":
            continue
        action = alert.get("labels", {}).get("action", "")
        if action not in ACTIONS:
            continue
        direction, delta = ACTIONS[action]
        if time.monotonic() - _last[direction] < COOLDOWN[direction]:
            continue
        svc     = client.services.get(SERVICE)
        current = svc.attrs["Spec"]["Mode"]["Replicated"]["Replicas"]
        new     = max(MIN_REPLICAS, min(MAX_REPLICAS, current + delta))
        if new != current:
            svc.scale(new)
            _last[direction] = time.monotonic()
    return "ok", 200

@app.route("/healthz")
def health():
    return "ok", 200

if __name__ == "__main__":
    app.run(host="0.0.0.0", port=5000)