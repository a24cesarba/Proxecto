#!/usr/bin/env bash
# =============================================================================
# /docker-entrypoint-initdb.d/02-app-db.sh
#
# Crea la base de datos de la aplicación y el usuario con el que se conectará
# el servicio web. Se ejecuta UNA VEZ en el nodo bootstrap, con el datadir
# vacío, antes de que Galera forme el clúster.
# El resto de nodos la recibirán por SST/IST automáticamente.
# =============================================================================
set -euo pipefail

APP_DB="${APP_DB_NAME:-app}"
APP_USER="${APP_DB_USER:-app}"
APP_PWD_FILE="${APP_DB_PASSWORD_FILE:-/run/secrets/db_app_password}"

if [ ! -f "$APP_PWD_FILE" ]; then
    echo "[initdb/app-db] ERROR: secret no encontrado en $APP_PWD_FILE"
    exit 1
fi

APP_PASSWORD=$(< "$APP_PWD_FILE")

echo "[initdb/app-db] Creando base de datos '${APP_DB}' y usuario '${APP_USER}'..."

mysql --protocol=socket -uroot -p"${MYSQL_ROOT_PASSWORD}" <<EOF
CREATE DATABASE IF NOT EXISTS \`${APP_DB}\`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS sesiones (
    id     VARCHAR(128) NOT NULL PRIMARY KEY,
    datos  MEDIUMBLOB   NOT NULL,
    expira DATETIME     NOT NULL,
    INDEX  idx_expira (expira)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE USER IF NOT EXISTS '${APP_USER}'@'%'
    IDENTIFIED BY '${APP_PASSWORD}';

-- Permisos estándar de aplicación web (sin DDL en producción)
GRANT SELECT, INSERT, UPDATE, DELETE
    ON \`${APP_DB}\`.*
    TO '${APP_USER}'@'%';

-- Descomentar si tu app necesita crear/alterar tablas (migraciones):
-- GRANT CREATE, ALTER, DROP, INDEX, REFERENCES
--     ON \`${APP_DB}\`.*
--     TO '${APP_USER}'@'%';

FLUSH PRIVILEGES;
EOF

echo "[initdb/app-db] Base de datos '${APP_DB}' y usuario '${APP_USER}' creados."
