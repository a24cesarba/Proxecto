FROM php:8.2-apache

# ── Extensión PDO MySQL ────────────────────────────────────────────────────────
# Necesaria para conectar a Galera/MariaDB via HAProxy (lb:3306).
RUN docker-php-ext-install pdo_mysql

# ── Configuración PHP: límite de subida de imágenes ───────────────────────────
RUN { \
    echo 'upload_max_filesize = 10M'; \
    echo 'post_max_size = 12M'; \
} > /usr/local/etc/php/conf.d/uploads.ini

# ── Apache: alias para servir imágenes del volumen GlusterFS ──────────────────
# Las imágenes subidas van a /app/almacenamiento (bind mount del GlusterFS).
# El alias las expone bajo la URL /almacenamento/ (sin ejecutar PHP en ese dir).
RUN { \
    echo 'Alias /almacenamento /app/almacenamiento'; \
    echo '<Directory /app/almacenamiento>'; \
    echo '    Options -Indexes'; \
    echo '    AllowOverride None'; \
    echo '    Require all granted'; \
    echo '    php_flag engine Off'; \
    echo '</Directory>'; \
} > /etc/apache2/conf-available/almacenamento.conf \
 && a2enconf almacenamento

# ── Directorio de subidas ──────────────────────────────────────────────────────
# El bind mount de docker-stack.yml sobreescribe este directorio en runtime.
# Lo creamos aquí para que www-data tenga el owner correcto si el mount
# llega vacío (primera ejecución).
RUN mkdir -p /app/almacenamiento \
 && chown www-data:www-data /app/almacenamiento

# ── Código fuente ──────────────────────────────────────────────────────────────
# El contexto de build debe ser ansible/web/ (donde está este Dockerfile).
# COPY copia app/ (con los .php, db.php, session_db.php, imaxes/, etc.)
# al document root de Apache.
COPY app/ /var/www/html/

RUN chown -R www-data:www-data /var/www/html \
 && find /var/www/html -type f -exec chmod 644 {} \; \
 && find /var/www/html -type d -exec chmod 755 {} \;

EXPOSE 80