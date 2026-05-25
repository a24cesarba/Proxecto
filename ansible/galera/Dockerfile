FROM mariadb:10.11

# ── Galera dependencies ───────────────────────────────────────────────────────
# galera-4        : Galera wsrep provider (libgalera_smm.so)
# mariadb-backup  : mariabackup SST — non-blocking, recommended for 10.4+
# socat           : used by SST for data streaming over TCP
# netcat-openbsd  : used by entrypoint to check cluster reachability
# rsync           : fallback SST method (keep it available)
RUN apt-get update \
 && apt-get install -y --no-install-recommends \
      galera-4 \
      mariadb-backup \
      socat \
      netcat-openbsd \
      rsync \
 && rm -rf /var/lib/apt/lists/*

# Static Galera configuration baked into the image.
# Dynamic values (node address, cluster address, SST credentials)
# are written at runtime by entrypoint.sh into 61-galera-runtime.cnf.
COPY ./galera.cnf /etc/mysql/mariadb.conf.d/60-galera.cnf

# Init script — runs once on empty datadir via docker-entrypoint-initdb.d.
# Creates the SST user that mariabackup uses for state transfers.
COPY ./01-sst-user.sh /docker-entrypoint-initdb.d/01-sst-user.sh
RUN chmod +x /docker-entrypoint-initdb.d/01-sst-user.sh

# Custom entrypoint wrapping the official MariaDB one with bootstrap logic.
COPY ./entrypoint.sh /usr/local/bin/galera-entrypoint.sh
RUN chmod +x /usr/local/bin/galera-entrypoint.sh

# 3306  : MySQL client connections
# 4444  : SST  — State Snapshot Transfer (full data copy to new node)
# 4567  : Galera replication (group communication, writeset replication)
# 4568  : IST  — Incremental State Transfer (delta sync after short outage)
EXPOSE 3306 4444 4567 4568

ENTRYPOINT ["/usr/local/bin/galera-entrypoint.sh"]
CMD ["mariadbd"]