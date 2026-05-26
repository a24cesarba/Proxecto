#!/usr/bin/env bash
# =============================================================================
# galera-entrypoint.sh
#
# Wraps the official MariaDB docker-entrypoint.sh with Galera bootstrap logic.
# Determines at startup whether this node should:
#   (a) bootstrap a new cluster  →  mariadbd --wsrep-new-cluster
#   (b) join an existing cluster →  mariadbd (Galera handles peer sync)
#
# Decision tree:
#   1. grastate.dat exists AND safe_to_bootstrap=1  → bootstrap
#      (This node was the last to shut down cleanly — it has the latest data)
#   2. grastate.dat exists AND safe_to_bootstrap=0  → join
#      (Another node has more recent data; SST/IST will sync us)
#   3. Empty datadir AND hostname == GALERA_BOOTSTRAP_NODE → bootstrap
#      (Fresh cluster deployment — designated seed node goes first)
#   4. Empty datadir AND hostname != GALERA_BOOTSTRAP_NODE → wait, then join
#      (Let the seed form the cluster before we try to connect)
#   5. Datadir not empty but no grastate.dat → join + expect forced SST
#      (Crashed mid-init; cluster will force a full state transfer)
#
# Environment variables:
#   MYSQL_ROOT_PASSWORD_FILE     Secret file path  (default: /run/secrets/db_root_password)
#   GALERA_SST_PASSWORD_FILE     Secret file path  (default: /run/secrets/db_galera_password)
#   GALERA_CLUSTER_NAME          Cluster name      (default: galera_cluster)
#   GALERA_CLUSTER_ADDRESS       gcomm:// address  (default: gcomm://app_db)
#   GALERA_CLUSTER_SERVICE       Service name for reachability check (default: app_db)
#   GALERA_BOOTSTRAP_NODE        Seed node hostname on fresh deploy  (default: db1)
#   GALERA_SST_USER              SST username      (default: galera_sst)
#   GALERA_NODE_ADDRESS          Override auto-detected overlay IP   (optional)
#   GALERA_NODE_NAME             Override container hostname         (optional)
# =============================================================================
set -euo pipefail

# ── Logging ───────────────────────────────────────────────────────────────────
log() { echo "[galera] $(date '+%H:%M:%S') $*"; }
die() { log "FATAL: $*"; exit 1; }

# ── Secrets ───────────────────────────────────────────────────────────────────
ROOT_PWD_FILE="${MYSQL_ROOT_PASSWORD_FILE:-/run/secrets/db_root_password}"
SST_PWD_FILE="${GALERA_SST_PASSWORD_FILE:-/run/secrets/db_galera_password}"

[ -f "$ROOT_PWD_FILE" ] || die "Root password secret not found: $ROOT_PWD_FILE"
[ -f "$SST_PWD_FILE"  ] || die "SST password secret not found: $SST_PWD_FILE"

SST_PASSWORD=$(< "$SST_PWD_FILE")


# ── Node Identity ─────────────────────────────────────────────────────────────
# In Swarm global mode with hostname: "{{.Node.Hostname}}", the container
# hostname matches the Swarm node name (db1 / db2 / db3 from Vagrantfile).
NODE_NAME="${GALERA_NODE_NAME:-$(hostname)}"

# Auto-detect the container's IP on the overlay network. This is what Galera
# advertises to peers for replication traffic. 'hostname -i' returns the
# container's primary overlay IP assigned by Docker Swarm.
NODE_ADDRESS="${GALERA_NODE_ADDRESS:-$(ip -4 addr show | grep inet | grep -v '127.0.0.1' | grep -v '172.18' | awk '{print $2}' | cut -d/ -f1 | head -n 1)}"

log "Node identity → name=${NODE_NAME}  overlay_addr=${NODE_ADDRESS}"

# ── Cluster Parameters ────────────────────────────────────────────────────────
CLUSTER_NAME="${GALERA_CLUSTER_NAME:-galera_cluster}"
CLUSTER_ADDRESS="${GALERA_CLUSTER_ADDRESS:-gcomm://app_db}"
CLUSTER_SERVICE="${GALERA_CLUSTER_SERVICE:-app_db}"   # Swarm service DNS name
BOOTSTRAP_NODE="${GALERA_BOOTSTRAP_NODE:-db1}"
SST_USER="${GALERA_SST_USER:-galera_sst}"

DATADIR=/var/lib/mysql
BOOTSTRAP=false

# ── Bootstrap / Join Decision ─────────────────────────────────────────────────
log "Evaluating cluster state..."

if [ -f "${DATADIR}/grastate.dat" ]; then

    # ── Case 1 & 2: Existing data directory ──────────────────────────────────
    log "Found existing datadir with grastate.dat"
    if grep -q "safe_to_bootstrap: 1" "${DATADIR}/grastate.dat"; then
        # Galera marked this node safe to bootstrap on shutdown.
        # It was the last node to leave the cluster cleanly — it holds the
        # most up-to-date committed state.
        log "safe_to_bootstrap=1 → bootstrapping cluster from this node's data"
        BOOTSTRAP=true
    else
        # Another node has equal or newer data. Join and let Galera determine
        # if IST (fast, delta sync) or SST (full copy) is needed.
        log "safe_to_bootstrap=0 → joining existing cluster (IST/SST will sync state)"
        BOOTSTRAP=false
    fi

elif [ -z "$(ls -A "$DATADIR" 2>/dev/null)" ]; then

    # ── Case 3 & 4: Fresh / empty data directory ──────────────────────────────
    log "Empty datadir detected — fresh deployment"

    if [ "$NODE_NAME" = "$BOOTSTRAP_NODE" ]; then
        # This is the designated seed node. Start a new cluster.
        # The other db nodes will wait until this node's Galera port
        # is reachable, then join.
        log "I am the bootstrap node (${BOOTSTRAP_NODE}) → starting new cluster"
        BOOTSTRAP=true

    else
        # Not the seed. Wait for the bootstrap node to form a cluster
        # before attempting to join, otherwise Galera returns
        # "gcs/src/gcs_group.cpp: group_bootstrap" errors and retries noisily.
        log "I am NOT the bootstrap node — waiting for cluster to form..."
        BOOTSTRAP=false

        # Port 4567 is Galera's group communication port. Once the bootstrap
        # node has it open, the cluster Primary Component is forming.
        # CLUSTER_SERVICE resolves via Swarm dnsrr to the task IPs of app_db —
        # nc will reach whichever task IP the DNS returns.
        MAX_WAIT=120
        WAITED=0
        log "Probing ${CLUSTER_SERVICE}:4567 (timeout ${MAX_WAIT}s)..."

        until nc -z "$CLUSTER_SERVICE" 4567 2>/dev/null; do
            if [ "$WAITED" -ge "$MAX_WAIT" ]; then
                log "WARNING: cluster not reachable after ${MAX_WAIT}s — joining anyway (Galera will retry)"
                break
            fi
            log "  not yet reachable — retrying in 5s (${WAITED}/${MAX_WAIT}s elapsed)"
            sleep 5
            WAITED=$((WAITED + 5))
        done
        log "Cluster reachable — proceeding to join"
    fi

else

    # ── Case 5: Datadir has content but no grastate.dat ───────────────────────
    # Likely a crash during initial DB setup or a corrupt shutdown.
    # Attempt to join; the cluster will force a full SST to recover this node.
    log "WARNING: datadir not empty but grastate.dat missing — joining (expect forced SST)"
    BOOTSTRAP=false

fi

# ── Write Runtime Galera Config ───────────────────────────────────────────────
# This file is written fresh on every container start. Priority order for
# MariaDB config files is alphabetical, so 61-* overrides 60-galera.cnf
# for any duplicate keys.
RUNTIME_CNF=/etc/mysql/mariadb.conf.d/61-galera-runtime.cnf

log "Writing runtime config → ${RUNTIME_CNF}"
cat > "$RUNTIME_CNF" <<EOF
# Auto-generated by galera-entrypoint.sh on $(date -u '+%Y-%m-%dT%H:%M:%SZ')
# Do not edit — this file is overwritten on every container start.
[mysqld]
wsrep_node_name     = ${NODE_NAME}
wsrep_node_address  = ${NODE_ADDRESS}
wsrep_cluster_name  = ${CLUSTER_NAME}
wsrep_cluster_address = ${CLUSTER_ADDRESS}
wsrep_sst_auth      = ${SST_USER}:${SST_PASSWORD}
EOF

# ── Build Extra Flags ─────────────────────────────────────────────────────────
EXTRA_FLAGS=""
if [ "$BOOTSTRAP" = "true" ]; then
    EXTRA_FLAGS="--wsrep-new-cluster"
    log "Mode: BOOTSTRAP → mariadbd --wsrep-new-cluster"
else
    log "Mode: JOIN       → mariadbd (normal start)"
fi

# ── Hand Off to Official MariaDB Entrypoint ───────────────────────────────────
# docker-entrypoint.sh handles:
#   - mysql_install_db + grant setup on empty datadir (temp mysqld, no Galera)
#   - Running /docker-entrypoint-initdb.d/ scripts (creates SST user)
#   - Final exec: mariadbd $USER_ARGS
#
# $@ is "mariadbd" (from CMD in Dockerfile).
# $EXTRA_FLAGS is "--wsrep-new-cluster" or empty.
#
# The temp init startup inside docker-entrypoint.sh uses --skip-networking and
# does NOT pass user args, so --wsrep-new-cluster only applies to the final
# exec, after the DB is fully initialized. This is the correct behaviour.
log "Handing off to docker-entrypoint.sh..."
exec /usr/local/bin/docker-entrypoint.sh "$@" $EXTRA_FLAGS
