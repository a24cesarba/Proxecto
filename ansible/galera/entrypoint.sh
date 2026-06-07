#!/usr/bin/env bash

set -euo pipefail

# ──────────────────────────────────────────────────────────────────────────────
# Logging
# ──────────────────────────────────────────────────────────────────────────────

log() {
    echo "[galera] $(date '+%H:%M:%S') $*"
}

die() {
    log "FATAL: $*"
    exit 1
}

# ──────────────────────────────────────────────────────────────────────────────
# Secrets
# ──────────────────────────────────────────────────────────────────────────────

ROOT_PWD_FILE="${MYSQL_ROOT_PASSWORD_FILE:-/run/secrets/db_root_password}"
SST_PWD_FILE="${GALERA_SST_PASSWORD_FILE:-/run/secrets/db_galera_password}"

[[ -f "$ROOT_PWD_FILE" ]] || die "Root password secret not found: $ROOT_PWD_FILE"
[[ -f "$SST_PWD_FILE"  ]] || die "SST password secret not found: $SST_PWD_FILE"

SST_PASSWORD=$(< "$SST_PWD_FILE")

# ──────────────────────────────────────────────────────────────────────────────
# Node Identity
# ──────────────────────────────────────────────────────────────────────────────

NODE_NAME="${GALERA_NODE_NAME:-$(hostname)}"
NODE_ADDRESS="${GALERA_NODE_ADDRESS:-$(hostname -i | awk '{print $1}')}"

log "Node identity → name=${NODE_NAME} address=${NODE_ADDRESS}"

# ──────────────────────────────────────────────────────────────────────────────
# Cluster Configuration
# ──────────────────────────────────────────────────────────────────────────────

CLUSTER_NAME="${GALERA_CLUSTER_NAME:-galera_cluster}"
CLUSTER_ADDRESS="${GALERA_CLUSTER_ADDRESS:-gcomm://tasks.app_db}"
BOOTSTRAP_NODE="${GALERA_BOOTSTRAP_NODE:-db1}"
SST_USER="${GALERA_SST_USER:-galera_sst}"

DATADIR="/var/lib/mysql"

BOOTSTRAP=false

# ──────────────────────────────────────────────────────────────────────────────
# Cluster Decision
# ──────────────────────────────────────────────────────────────────────────────

log "Evaluating cluster state..."

if [[ ! -d "$DATADIR" ]] || [[ -z "$(ls -A "$DATADIR" 2>/dev/null)" ]]; then

    log "Fresh datadir detected"

    if [[ "$NODE_NAME" == "$BOOTSTRAP_NODE" ]]; then
        log "Bootstrap node (${BOOTSTRAP_NODE})"
        BOOTSTRAP=true
    else
        log "Non-bootstrap node, waiting 45s for primary to form..."
        sleep 45
    fi

elif [[ -s "${DATADIR}/grastate.dat" ]]; then

    log "Found grastate.dat"

    WSREP_UUID=$(awk '/^uuid:/{print $2}' "${DATADIR}/grastate.dat")

    if [[ "$WSREP_UUID" == "00000000-0000-0000-0000-000000000000" ]]; then

        log "Invalid UUID detected, cleaning Galera metadata"

        rm -f \
            "${DATADIR}/grastate.dat" \
            "${DATADIR}/galera.cache"

        if [[ "$NODE_NAME" == "$BOOTSTRAP_NODE" ]]; then
            BOOTSTRAP=true
        fi

    elif grep -q '^safe_to_bootstrap: 1' "${DATADIR}/grastate.dat"; then

        log "safe_to_bootstrap=1"

        BOOTSTRAP=true

    else

        log "safe_to_bootstrap=0 → join cluster"

    fi

else

    log "Datadir exists but grastate.dat missing"

    rm -f "${DATADIR}/galera.cache"

fi

# ──────────────────────────────────────────────────────────────────────────────
# Runtime Config
# ──────────────────────────────────────────────────────────────────────────────

RUNTIME_CNF="/etc/mysql/mariadb.conf.d/61-galera-runtime.cnf"

cat > "$RUNTIME_CNF" <<EOF
[mysqld]

wsrep_cluster_name=${CLUSTER_NAME}
wsrep_cluster_address=${CLUSTER_ADDRESS}

wsrep_node_name=${NODE_NAME}
wsrep_node_address=${NODE_ADDRESS}

wsrep_sst_auth=${SST_USER}:${SST_PASSWORD}
EOF

log "Cluster address: ${CLUSTER_ADDRESS}"

# ──────────────────────────────────────────────────────────────────────────────
# Startup Mode
# ──────────────────────────────────────────────────────────────────────────────

EXTRA_ARGS=()

if [[ "$BOOTSTRAP" == "true" ]]; then
    log "Mode: BOOTSTRAP"
    EXTRA_ARGS+=(--wsrep-new-cluster)
else
    log "Mode: JOIN"
fi

# ──────────────────────────────────────────────────────────────────────────────
# Hand Off
# ──────────────────────────────────────────────────────────────────────────────

log "Starting MariaDB..."

exec /usr/local/bin/docker-entrypoint.sh \
    "$@" \
    "${EXTRA_ARGS[@]}"