FROM php:8.2-apache

# ── Extensión PDO MySQL ────────────────────────────────────────────────────────
# Necesaria para conectar a Galera/MariaDB via HAProxy (lb:3306).
RUN docker-php-ext-install pdo_mysql

RUN echo "DirectoryIndex login.php index.php index.html" > /etc/apache2/conf-available/directoryindex.conf \
 && a2enconf directoryindex

# RUN apt-get update && apt-get install -y --no-install-recommends curl && rm -rf /var/lib/apt/lists/*

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
RUN mkdir -p /app/almacenamiento \
 && chown www-data:www-data /app/almacenamiento

# ── Código fuente ──────────────────────────────────────────────────────────────
COPY app/ /var/www/html/

RUN chown -R www-data:www-data /var/www/html \
 && find /var/www/html -type f -exec chmod 644 {} \; \
 && find /var/www/html -type d -exec chmod 755 {} \;

EXPOSE 80