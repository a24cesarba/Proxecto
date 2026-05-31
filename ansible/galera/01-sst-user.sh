#!/usr/bin/env bash
set -euo pipefail

SST_USER="${GALERA_SST_USER:-galera_sst}"
SST_PWD_FILE="${GALERA_SST_PASSWORD_FILE:-/run/secrets/db_galera_password}"

if [ ! -f "$SST_PWD_FILE" ]; then
    echo "[initdb/sst-user] ERROR: SST password secret not found at $SST_PWD_FILE"
    exit 1
fi

SST_PASSWORD=$(< "$SST_PWD_FILE")

echo "[initdb/sst-user] Creating SST user '${SST_USER}'..."

# The official MariaDB entrypoint provides $MYSQL_PWD for the temp startup.
# We use the mysql client that the entrypoint already has open.
mysql --protocol=socket -uroot -p"${MYSQL_ROOT_PASSWORD}" <<EOF
-- SST user needs to authenticate FROM the node performing the transfer.
-- '%' covers all hosts (the donor contacts the joiner, IPs are overlay-dynamic).
CREATE USER IF NOT EXISTS '${SST_USER}'@'%'
    IDENTIFIED BY '${SST_PASSWORD}';

-- Grants required by mariabackup for SST:
GRANT RELOAD, PROCESS, LOCK TABLES, REPLICATION CLIENT ON *.*
    TO '${SST_USER}'@'%';


FLUSH PRIVILEGES;
EOF

echo "[initdb/sst-user] SST user '${SST_USER}' created successfully."
