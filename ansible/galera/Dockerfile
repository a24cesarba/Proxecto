FROM mariadb:10.11

RUN apt-get update \
 && apt-get install -y --no-install-recommends \
      galera-4 \
      mariadb-backup \
      socat \
      netcat-openbsd \
      rsync \
 && rm -rf /var/lib/apt/lists/*

COPY ./galera.cnf /etc/mysql/mariadb.conf.d/60-galera.cnf

# ── Scripts de inicialización (orden de ejecución: alfabético) ───────────────
# 01: crea el usuario SST para mariabackup
# 02: crea la base de datos y usuario de la aplicación web
COPY ./01-sst-user.sh  /docker-entrypoint-initdb.d/01-sst-user.sh
COPY ./02-app-db.sh    /docker-entrypoint-initdb.d/02-app-db.sh
RUN chmod +x \
      /docker-entrypoint-initdb.d/01-sst-user.sh \
      /docker-entrypoint-initdb.d/02-app-db.sh

COPY ./entrypoint.sh /usr/local/bin/galera-entrypoint.sh
RUN chmod +x /usr/local/bin/galera-entrypoint.sh

EXPOSE 3306 4444 4567 4568

ENTRYPOINT ["/usr/local/bin/galera-entrypoint.sh"]
CMD ["mariadbd"]