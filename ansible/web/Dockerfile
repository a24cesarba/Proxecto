FROM php:8.2-apache

RUN docker-php-ext-install pdo_mysql

RUN { \
    echo 'upload_max_filesize = 10M'; \
    echo 'post_max_size = 12M'; \
} > /usr/local/etc/php/conf.d/uploads.ini

RUN { \
    echo 'Alias /almacenamento /app/almacenamiento'; \
    echo '<Directory /app/almacenamiento>'; \
    echo '    Options -Indexes'; \
    echo '    AllowOverride None'; \
    echo '    Require all granted'; \
    echo '    php_flag engine Off'; \
    echo '</Directory>'; \
    echo '<Directory /var/www/html>' ; \
    echo '    DirectoryIndex login.php'; \
    echo '</Directory>'; \
} > /etc/apache2/conf-available/almacenamento.conf \
 && a2enconf almacenamento

RUN mkdir -p /app/almacenamiento \
 && chown www-data:www-data /app/almacenamiento

COPY app/ /var/www/html/

RUN chown -R www-data:www-data /var/www/html \
 && find /var/www/html -type f -exec chmod 644 {} \; \
 && find /var/www/html -type d -exec chmod 755 {} \;

EXPOSE 80