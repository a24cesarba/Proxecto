#!/usr/bin/env bash
set -euo pipefail

APP_DB="${APP_DB_NAME:-app}"
APP_USER="${APP_DB_USER:-app}"
APP_PWD_FILE="${APP_DB_PASSWORD_FILE:-/run/secrets/db_app_password}"

if [ ! -f "$APP_PWD_FILE" ]; then
    echo "[initdb/app-db] ERROR: secret no encontrado en $APP_PWD_FILE"
    exit 1
fi
APP_PASSWORD=$(< "$APP_PWD_FILE")

echo "[initdb/app-db] Creando base de datos '${APP_DB}' y esquema..."

mysql --protocol=socket -uroot -p"${MYSQL_ROOT_PASSWORD}" <<EOF

CREATE DATABASE IF NOT EXISTS \`${APP_DB}\`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE \`${APP_DB}\`;

-- Sesiones PHP (session_db.php)
CREATE TABLE IF NOT EXISTS sesiones (
    id     VARCHAR(128)  NOT NULL PRIMARY KEY,
    datos  MEDIUMBLOB    NOT NULL,
    expira DATETIME      NOT NULL,
    INDEX  idx_expira (expira)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Usuarios (validarexistro.php, validalogin.php)
CREATE TABLE IF NOT EXISTS usuarios (
    nome         VARCHAR(100)  NOT NULL PRIMARY KEY,
    contrasinal  VARCHAR(255)  NOT NULL,
    completo     VARCHAR(255)  NOT NULL,
    email        VARCHAR(255)  NOT NULL,
    datacreacion DATE          NOT NULL,
    rol          VARCHAR(50)   NOT NULL DEFAULT 'usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Catálogo de productos (mostra.php)
CREATE TABLE IF NOT EXISTS produto (
    idProduto   INT           NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome        VARCHAR(255)  NOT NULL,
    descricion  TEXT,
    familia     VARCHAR(100),
    imaxe       VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Comentarios (mostra.php, comenta.php, xestionacomentarios.php)
-- Nota: xestionacomentarios.php filtra por el texto del comentario;
-- idealmente habría que refactorizarlo para usar idComentario.
CREATE TABLE IF NOT EXISTS comentarios (
    idComentario  INT          NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Comentario    TEXT         NOT NULL,
    usuario       VARCHAR(100) NOT NULL,
    idProduto     INT          NOT NULL,
    dataCreación  DATE         NOT NULL,
    moderado      ENUM('si','no') NOT NULL DEFAULT 'no',
    dataModeración DATE,
    INDEX idx_produto (idProduto),
    INDEX idx_moderado (moderado),
    CONSTRAINT fk_com_produto FOREIGN KEY (idProduto)
        REFERENCES produto (idProduto) ON DELETE CASCADE,
    CONSTRAINT fk_com_usuario FOREIGN KEY (usuario)
        REFERENCES usuarios (nome) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Usuario de aplicación
CREATE USER IF NOT EXISTS '${APP_USER}'@'%'
    IDENTIFIED BY '${APP_PASSWORD}';

GRANT SELECT, INSERT, UPDATE, DELETE
    ON \`${APP_DB}\`.*
    TO '${APP_USER}'@'%';

FLUSH PRIVILEGES;
EOF

echo "[initdb/app-db] Esquema de '${APP_DB}' creado correctamente."