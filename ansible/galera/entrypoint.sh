#!/usr/bin/env bash

set -euo pipefail

log() { echo "[galera] $(date '+%H:%M:%S') $*"; }
die() { log "FATAL: $*"; exit 1; }

# ── Secrets ───────────────────────────────────────────────────────────────────

ROOT_PWD_FILE="${MYSQL_ROOT_PASSWORD_FILE:-/run/secrets/db_root_password}"
SST_PWD_FILE="${GALERA_SST_PASSWORD_FILE:-/run/secrets/db_galera_password}"

[[ -f "$ROOT_PWD_FILE" ]] || die "Root password secret not found: $ROOT_PWD_FILE"
[[ -f "$SST_PWD_FILE"  ]] || die "SST password secret not found: $SST_PWD_FILE"

SST_PASSWORD=$(< "$SST_PWD_FILE")

# ── Node Identity ─────────────────────────────────────────────────────────────

NODE_NAME="${GALERA_NODE_NAME:-$(hostname)}"
NODE_ADDRESS="${GALERA_NODE_ADDRESS:-$(hostname -i | awk '{print $1}')}"

log "Node identity → name=${NODE_NAME} address=${NODE_ADDRESS}"

# ── Cluster Configuration ─────────────────────────────────────────────────────

CLUSTER_NAME="${GALERA_CLUSTER_NAME:-galera_cluster}"
BOOTSTRAP_NODE="${GALERA_BOOTSTRAP_NODE:-db1}"
SST_USER="${GALERA_SST_USER:-galera_sst}"
DATADIR="/var/lib/mysql"
BOOTSTRAP=false

# ── Cluster Decision ──────────────────────────────────────────────────────────

log "Evaluating cluster state..."

if [[ ! -d "$DATADIR" ]] || [[ -z "$(ls -A "$DATADIR" 2>/dev/null)" ]]; then

    log "Fresh datadir detected"
    [[ "$NODE_NAME" == "$BOOTSTRAP_NODE" ]] && BOOTSTRAP=true || log "Non-bootstrap node, waiting for primary..."

elif [[ -s "${DATADIR}/grastate.dat" ]]; then

    log "Found grastate.dat"
    WSREP_UUID=$(awk '/^uuid:/{print $2}' "${DATADIR}/grastate.dat")

    if [[ "$WSREP_UUID" == "00000000-0000-0000-0000-000000000000" ]]; then
        log "Invalid UUID detected, cleaning Galera metadata"
        rm -f "${DATADIR}/grastate.dat" "${DATADIR}/galera.cache"
        [[ "$NODE_NAME" == "$BOOTSTRAP_NODE" ]] && BOOTSTRAP=true

    elif grep -q '^safe_to_bootstrap: 1' "${DATADIR}/grastate.dat"; then
        if [[ "$NODE_NAME" == "$BOOTSTRAP_NODE" ]]; then
            log "safe_to_bootstrap=1 on bootstrap node → BOOTSTRAP"
            BOOTSTRAP=true
        else
            log "safe_to_bootstrap=1 but not the bootstrap node → JOIN"
        fi

    else
        log "safe_to_bootstrap=0 → join cluster"
    fi

else
    log "Datadir exists but grastate.dat missing"
    rm -f "${DATADIR}/galera.cache" "${DATADIR}/gvwstate.dat"
fi

# ── Seed Resolution ───────────────────────────────────────────────────────────

RUNTIME_CNF="/etc/mysql/mariadb.conf.d/61-galera-runtime.cnf"

if [[ "$BOOTSTRAP" == "true" ]]; then
    log "Mode: BOOTSTRAP"
    CLUSTER_SEED="gcomm://"
else
    log "Resolving bootstrap node '${BOOTSTRAP_NODE}'..."
    BOOTSTRAP_IP=""
    while [[ -z "$BOOTSTRAP_IP" ]]; do
        BOOTSTRAP_IP=$(getent hosts "$BOOTSTRAP_NODE" 2>/dev/null | awk '{print $1}')
        [[ -z "$BOOTSTRAP_IP" ]] && { log "Cannot resolve ${BOOTSTRAP_NODE} yet, retrying in 2s..."; sleep 2; }
    done
    log "Resolved ${BOOTSTRAP_NODE} → ${BOOTSTRAP_IP}"

    log "Waiting for ${BOOTSTRAP_IP}:4567..."
    while ! timeout 2 bash -c "echo > /dev/tcp/${BOOTSTRAP_IP}/4567" 2>/dev/null; do
        log "Port 4567 not ready, retrying in 3s..."
        sleep 3
    done
    log "Port 4567 ready."
    CLUSTER_SEED="gcomm://${BOOTSTRAP_IP}"
fi

# ── Runtime Config ────────────────────────────────────────────────────────────

cat > "$RUNTIME_CNF" <<EOF
[mysqld]
wsrep_cluster_name=${CLUSTER_NAME}
wsrep_cluster_address=${CLUSTER_SEED}
wsrep_node_name=${NODE_NAME}
wsrep_node_address=${NODE_ADDRESS}
wsrep_sst_auth=${SST_USER}:${SST_PASSWORD}
EOF

log "Cluster address: ${CLUSTER_SEED}"

# ── Hand Off ──────────────────────────────────────────────────────────────────

log "Starting MariaDB..."
[[ "$BOOTSTRAP" == "true" ]] \
    && exec /usr/local/bin/docker-entrypoint.sh "$@" --wsrep-new-cluster \
    || exec /usr/local/bin/docker-entrypoint.sh "$@"