vagrant@web1:~$ docker stack services app
ID             NAME               MODE         REPLICAS   IMAGE                                 PORTS
6p4werym9kq2   app_alertmanager   replicated   1/1        prom/alertmanager:v0.27.0             *:9093->9093/tcp
mns294ovde9w   app_autoscaler     replicated   1/1        a24cesarba/swarm-autoscaler:1.0       
86nlqk4qnb5s   app_cadvisor       global       10/10      gcr.io/cadvisor/cadvisor:v0.49.1      
zsirhskfbv07   app_db             global       1/1        a24cesarba/galera-mariadb:10.11       
gach1cb11ouy   app_lb             replicated   2/2        haproxy:2.8-alpine                    
rkb5u4nk5aec   app_prometheus     replicated   1/1        prom/prometheus:v2.51.2               *:9090->9090/tcp
4muy8jv9gsfg   app_socket-proxy   replicated   1/1        tecnativa/docker-socket-proxy:0.3.0   
udatd4h0nu3u   app_traefik        replicated   2/2        traefik:v3.0                          *:8081->8080/tcp
r2sll5dm31p4   app_web            replicated   3/3        a24cesarba/app-web:latest 

vagrant@web1:~$ docker service ps app_db --no-trunc
ID                          NAME                                   IMAGE                                                                                                     NODE      DESIRED STATE   CURRENT STATE               ERROR                       PORTS
s79zkul8y6ze2i3jq5g8d0236   app_db.ahnzot0jeb9pq89f4mk1ts2b9       a24cesarba/galera-mariadb:10.11@sha256:96cc43c5ed55978dbd396c28a4b194988b5f5d8454f19a4884a66f14163d8911   db3       Running         Running 8 seconds ago                                   
xw0c3no1y86av7g2jf6wofc6v    \_ app_db.ahnzot0jeb9pq89f4mk1ts2b9   a24cesarba/galera-mariadb:10.11@sha256:96cc43c5ed55978dbd396c28a4b194988b5f5d8454f19a4884a66f14163d8911   db3       Shutdown        Failed about a minute ago   "task: non-zero exit (1)"   
lvfu3hsgctnueybvszlkq5921   app_db.u7o7g0b1r0pk8lxj9asc9ymoo       a24cesarba/galera-mariadb:10.11@sha256:96cc43c5ed55978dbd396c28a4b194988b5f5d8454f19a4884a66f14163d8911   db2       Running         Running 8 seconds ago                                   
v9bc5qixbi1ecfjzzi8dg2i0r    \_ app_db.u7o7g0b1r0pk8lxj9asc9ymoo   a24cesarba/galera-mariadb:10.11@sha256:96cc43c5ed55978dbd396c28a4b194988b5f5d8454f19a4884a66f14163d8911   db2       Shutdown        Failed about a minute ago   "task: non-zero exit (1)"   
nlxfkm3gx78bsfdru7ae1kksc   app_db.xv3cqqzf117dlzdxbb2ykaz9c       a24cesarba/galera-mariadb:10.11@sha256:96cc43c5ed55978dbd396c28a4b194988b5f5d8454f19a4884a66f14163d8911   db1       Running         Running 2 minutes ago   

vagrant@web1:~$ docker network inspect app_db_net
[
    {
        "Name": "app_db_net",
        "Id": "t2j8w5w08s4m8gwwll4a8t4si",
        "Created": "2026-06-07T08:45:40.361344929Z",
        "Scope": "swarm",
        "Driver": "overlay",
        "EnableIPv6": false,
        "IPAM": {
            "Driver": "default",
            "Options": null,
            "Config": [
                {
                    "Subnet": "172.28.3.0/24",
                    "Gateway": "172.28.3.1"
                }
            ]
        },
        "Internal": false,
        "Attachable": false,
        "Ingress": false,
        "ConfigFrom": {
            "Network": ""
        },
        "ConfigOnly": false,
        "Containers": null,
        "Options": {
            "com.docker.network.driver.overlay.vxlanid_list": "4097"
        },
        "Labels": {
            "com.docker.stack.namespace": "app"
        }
    }
]

vagrant@db1:~$ docker logs $(docker ps -q --filter name=app_db) 2>&1 | tail -80
2026-06-07  8:46:31 0 [Note] WSREP: New COMPONENT: primary = yes, bootstrap = no, my_idx = 0, memb_num = 1
2026-06-07  8:46:31 0 [Note] WSREP: Starting new group from scratch: 61c8e30e-624d-11f1-b477-126b12114084
2026-06-07  8:46:31 0 [Note] WSREP: STATE_EXCHANGE: sent state UUID: 61c8e3c2-624d-11f1-8ecb-9a9becb5d0fd
2026-06-07  8:46:31 0 [Note] WSREP: STATE EXCHANGE: sent state msg: 61c8e3c2-624d-11f1-8ecb-9a9becb5d0fd
2026-06-07  8:46:31 0 [Note] WSREP: STATE EXCHANGE: got state msg: 61c8e3c2-624d-11f1-8ecb-9a9becb5d0fd from 0 (db1)
2026-06-07  8:46:31 0 [Note] WSREP: Quorum results:
        version    = 6,
        component  = PRIMARY,
        conf_id    = 0,
        members    = 1/1 (joined/total),
        act_id     = 0,
        last_appl. = 0,
        protocols  = 6/11/4 (gcs/repl/appl),
        vote policy= 0,
        group UUID = 61c8e30e-624d-11f1-b477-126b12114084
2026-06-07  8:46:31 0 [Note] WSREP: Flow-control interval: [16, 16]
2026-06-07  8:46:31 0 [Note] WSREP: Restored state OPEN -> JOINED (1)
2026-06-07  8:46:31 0 [Note] WSREP: Member 0.0 (db1) synced with group.
2026-06-07  8:46:31 0 [Note] WSREP: Shifting JOINED -> SYNCED (TO: 1)
2026-06-07  8:46:31 1 [Note] WSREP: Starting rollbacker thread 1
2026-06-07  8:46:31 2 [Note] WSREP: Starting applier thread 2
2026-06-07  8:46:31 2 [Note] WSREP: ####### processing CC 1, local, ordered
2026-06-07  8:46:31 2 [Note] WSREP: Process first view: 61c8e30e-624d-11f1-b477-126b12114084 my uuid: 61c6dd9e-624d-11f1-a8ff-a7e21c9b5b52
2026-06-07  8:46:31 2 [Note] WSREP: Server db1 connected to cluster at position 61c8e30e-624d-11f1-b477-126b12114084:1 with ID 61c6dd9e-624d-11f1-a8ff-a7e21c9b5b52
2026-06-07  8:46:31 2 [Note] WSREP: Server status change disconnected -> connected
2026-06-07  8:46:31 2 [Note] WSREP: ####### My UUID: 61c6dd9e-624d-11f1-a8ff-a7e21c9b5b52
2026-06-07  8:46:31 2 [Note] WSREP: Cert index reset to 00000000-0000-0000-0000-000000000000:-1 (proto: 11), state transfer needed: no
2026-06-07  8:46:31 0 [Note] WSREP: Service thread queue flushed.
2026-06-07  8:46:31 2 [Note] WSREP: ####### Assign initial position for certification: 00000000-0000-0000-0000-000000000000:-1, protocol version: -1
2026-06-07  8:46:31 2 [Note] WSREP: REPL Protocols: 11 (6)
2026-06-07  8:46:31 2 [Note] WSREP: ####### Adjusting cert position: -1 -> 1
2026-06-07  8:46:31 0 [Note] WSREP: Service thread queue flushed.
2026-06-07  8:46:31 2 [Note] WSREP: GCache history reset: 00000000-0000-0000-0000-000000000000:0 -> 61c8e30e-624d-11f1-b477-126b12114084:0
2026-06-07  8:46:31 2 [Note] WSREP: ================================================
View:
  id: 61c8e30e-624d-11f1-b477-126b12114084:1
  status: primary
  protocol_version: 4
  capabilities: MULTI-MASTER, CERTIFICATION, PARALLEL_APPLYING, REPLAY, ISOLATION, PAUSE, CAUSAL_READ, INCREMENTAL_WS, UNORDERED, PREORDERED, STREAMING, NBO
  final: no
  own_index: 0
  members(1):
        0: 61c6dd9e-624d-11f1-a8ff-a7e21c9b5b52, db1
=================================================
2026-06-07  8:46:31 2 [Note] WSREP: Server status change connected -> joiner
2026-06-07  8:46:31 2 [Note] WSREP: Server status change joiner -> initializing
2026-06-07  8:46:31 0 [Note] InnoDB: Compressed tables use zlib 1.2.11
2026-06-07  8:46:31 0 [Note] InnoDB: Number of transaction pools: 1
2026-06-07  8:46:31 0 [Note] InnoDB: Using crc32 + pclmulqdq instructions
2026-06-07  8:46:31 0 [Note] mariadbd: O_TMPFILE is not supported on /tmp (disabling future attempts)
2026-06-07  8:46:31 0 [Note] InnoDB: Using io_uring
2026-06-07  8:46:31 0 [Note] InnoDB: innodb_buffer_pool_size_max=8388616m, innodb_buffer_pool_size=512m
2026-06-07  8:46:31 0 [Note] InnoDB: Completed initialization of buffer pool
2026-06-07  8:46:31 0 [Note] InnoDB: File system buffers for log disabled (block size=512 bytes)
2026-06-07  8:46:31 0 [Note] InnoDB: End of log at LSN=59344
2026-06-07  8:46:31 0 [Note] InnoDB: 128 rollback segments are active.
2026-06-07  8:46:31 0 [Note] InnoDB: Setting file './ibtmp1' size to 12.000MiB. Physically writing the file full; Please wait ...
2026-06-07  8:46:31 0 [Note] InnoDB: File './ibtmp1' size is now 12.000MiB.
2026-06-07  8:46:31 0 [Note] InnoDB: log sequence number 59344; transaction id 38
2026-06-07  8:46:31 0 [Note] Plugin 'FEEDBACK' is disabled.
2026-06-07  8:46:31 0 [Note] InnoDB: Loading buffer pool(s) from /var/lib/mysql/ib_buffer_pool
2026-06-07  8:46:31 0 [Warning] You need to use --log-bin to make --expire-logs-days or --binlog-expire-logs-seconds work.
2026-06-07  8:46:31 0 [Note] Server socket created on IP: '0.0.0.0', port: '3306'.
2026-06-07  8:46:31 0 [Note] InnoDB: Buffer pool(s) load completed at 260607  8:46:31
2026-06-07  8:46:31 0 [Note] WSREP: wsrep_init_schema_and_SR (nil)
2026-06-07  8:46:31 0 [Note] WSREP: Server initialized
2026-06-07  8:46:31 0 [Note] WSREP: Server status change initializing -> initialized
2026-06-07  8:46:31 2 [Note] WSREP: Bootstrapping a new cluster, setting initial position to 00000000-0000-0000-0000-000000000000:-1
2026-06-07  8:46:31 5 [Note] WSREP: Cluster table is empty, not recovering transactions
2026-06-07  8:46:31 2 [Note] WSREP: Server status change initialized -> joined
2026-06-07  8:46:31 2 [Note] WSREP: wsrep_notify_cmd is not defined, skipping notification.
2026-06-07  8:46:31 2 [Note] WSREP: Lowest cert index boundary for CC from group: 1
2026-06-07  8:46:31 2 [Note] WSREP: Min available from gcache for CC from group: 1
2026-06-07  8:46:31 2 [Note] WSREP: Server db1 synced with group
2026-06-07  8:46:31 2 [Note] WSREP: Server status change joined -> synced
2026-06-07  8:46:31 2 [Note] WSREP: Synchronized with group, ready for connections
2026-06-07  8:46:31 2 [Note] WSREP: wsrep_notify_cmd is not defined, skipping notification.
2026-06-07  8:46:31 7 [Note] WSREP: Starting applier thread 7
2026-06-07  8:46:31 0 [Note] mariadbd: ready for connections.
Version: '10.11.18-MariaDB-ubu2204'  socket: '/run/mysqld/mysqld.sock'  port: 3306  mariadb.org binary distribution

Los logs de db2 y db3 son de dos contenedores ya abortados entre los muchos que se crearon y destruyeron

vagrant@db1:~$ docker exec -it $(docker ps -q --filter name=app_db) \
    mysql -uroot -p -e "SHOW STATUS LIKE 'wsrep_cluster%';"
Enter password: 
+----------------------------+--------------------------------------+
| Variable_name              | Value                                |
+----------------------------+--------------------------------------+
| wsrep_cluster_weight       | 1                                    |
| wsrep_cluster_capabilities |                                      |
| wsrep_cluster_conf_id      | 1                                    |
| wsrep_cluster_size         | 1                                    |
| wsrep_cluster_state_uuid   | 61c8e30e-624d-11f1-b477-126b12114084 |
| wsrep_cluster_status       | Primary                              |
+----------------------------+--------------------------------------+

vagrant@db2:~$ docker logs app_db.u7o7g0b1r0pk8lxj9asc9ymoo.v9bc5qixbi1ecfjzzi8dg2i0r 2>&1 | tail -80
2026-06-07 08:47:15+00:00 [Note] [Entrypoint]: Temporary server started.
2026-06-07 08:47:17+00:00 [Note] [Entrypoint]: Securing system users (equivalent to running mysql_secure_installation)

2026-06-07 08:47:17+00:00 [Note] [Entrypoint]: /usr/local/bin/docker-entrypoint.sh: running /docker-entrypoint-initdb.d/01-sst-user.sh
[initdb/sst-user] Creating SST user 'galera_sst'...
[initdb/sst-user] SST user 'galera_sst' created successfully.

2026-06-07 08:47:17+00:00 [Note] [Entrypoint]: /usr/local/bin/docker-entrypoint.sh: running /docker-entrypoint-initdb.d/02-app-db.sh
[initdb/app-db] Creando base de datos 'app' y esquema...
[initdb/app-db] Esquema de 'app' creado correctamente.

2026-06-07 08:47:17+00:00 [Note] [Entrypoint]: Stopping temporary server
2026-06-07  8:47:17 0 [Note] mariadbd (initiated by: unknown): Normal shutdown
2026-06-07  8:47:17 0 [Note] InnoDB: FTS optimize thread exiting.
2026-06-07  8:47:17 0 [Note] InnoDB: Starting shutdown...
2026-06-07  8:47:17 0 [Note] InnoDB: Dumping buffer pool(s) to /var/lib/mysql/ib_buffer_pool
2026-06-07  8:47:17 0 [Note] InnoDB: Buffer pool(s) dump completed at 260607  8:47:17
2026-06-07  8:47:17 0 [Note] InnoDB: Removed temporary tablespace data file: "./ibtmp1"
2026-06-07  8:47:17 0 [Note] Shutdown completed; log sequence number 59344; transaction id 37
2026-06-07  8:47:17 0 [Note] mariadbd: Shutdown complete
2026-06-07 08:47:17+00:00 [Note] [Entrypoint]: Temporary server stopped

2026-06-07 08:47:17+00:00 [Note] [Entrypoint]: MariaDB init process done. Ready for start up.

2026-06-07  8:47:17 0 [Note] Starting MariaDB 10.11.18-MariaDB-ubu2204 source revision 197f92bee02d8e836f529f37625be69b83e7acbd server_uid zY97xZVscfuCP//AR/wftQjf3yU= as process 1
2026-06-07  8:47:17 0 [Note] WSREP: Loading provider /usr/lib/galera/libgalera_smm.so initial position: 00000000-0000-0000-0000-000000000000:-1
2026-06-07  8:47:17 0 [Note] WSREP: wsrep_load(): loading provider library '/usr/lib/galera/libgalera_smm.so'
2026-06-07  8:47:17 0 [Note] WSREP: wsrep_load(): Galera 26.4.27(rf032a460) by Codership Oy <info@codership.com> loaded successfully.
2026-06-07  8:47:17 0 [Note] WSREP: Initializing allowlist service v1
2026-06-07  8:47:17 0 [Note] WSREP: Resolved symbol 'wsrep_node_isolation_mode_set_v1'
2026-06-07  8:47:17 0 [Note] WSREP: Resolved symbol 'wsrep_certify_v1'
2026-06-07  8:47:17 0 [Note] WSREP: CRC-32C: using 64-bit x86 acceleration.
2026-06-07  8:47:17 0 [Warning] WSREP: Could not open state file for reading: '/var/lib/mysql//grastate.dat'
2026-06-07  8:47:17 0 [Note] WSREP: Found saved state: 00000000-0000-0000-0000-000000000000:-1, safe_to_bootstrap: 1
2026-06-07  8:47:17 0 [Note] WSREP: GCache DEBUG: opened preamble:
Version: 0
UUID: 00000000-0000-0000-0000-000000000000
Seqno: -1 - -1
Offset: -1
Synced: 0
2026-06-07  8:47:17 0 [Note] WSREP: Skipped GCache ring buffer recovery: could not determine history UUID.
2026-06-07  8:47:17 0 [Note] WSREP: Passing config to GCS: base_dir = /var/lib/mysql/; base_host = 172.28.3.7; base_port = 4567; cert.log_conflicts = no; cert.optimistic_pa = yes; debug = no; evs.auto_evict = 0; evs.causal_keepalive_period = PT1S; evs.debug_log_mask = 0x1; evs.delay_margin = PT1S; evs.delayed_keep_period = PT30S; evs.inactive_check_period = PT0.5S; evs.inactive_timeout = PT1M; evs.info_log_mask = 0; evs.install_timeout = PT1M; evs.join_retrans_period = PT1S; evs.keepalive_period = PT3S; evs.max_install_timeouts = 3; evs.send_window = 4; evs.stats_report_period = PT1M; evs.suspect_timeout = PT30S; evs.use_aggregate = true; evs.user_send_window = 2; evs.version = 1; evs.view_forget_timeout = PT24H; gcache.dir = /var/lib/mysql/; gcache.keep_pages_size = 0; gcache.keep_plaintext_size = 128M; gcache.mem_size = 0; gcache.name = galera.cache; gcache.page_size = 128M; gcache.recover = yes; gcache.size = 256M; gcomm.thread_prio = ; gcs.check_appl_proto = 1; gcs.fc_debug = 0; gcs.fc_factor = 1.0; gcs.fc_limit = 16; gcs.fc_master_
2026-06-07  8:47:17 0 [Note] WSREP: Start replication
2026-06-07  8:47:17 0 [Note] WSREP: Connecting with bootstrap option: 0
2026-06-07  8:47:17 0 [Note] WSREP: Setting GCS initial position to 00000000-0000-0000-0000-000000000000:-1
2026-06-07  8:47:17 0 [Note] WSREP: protonet asio version 0
2026-06-07  8:47:17 0 [Note] WSREP: Using CRC-32C for message checksums.
2026-06-07  8:47:17 0 [Note] WSREP: backend: asio
2026-06-07  8:47:17 0 [Note] WSREP: gcomm thread scheduling priority set to other:0 
2026-06-07  8:47:17 0 [Note] WSREP: access file(/var/lib/mysql//gvwstate.dat) failed(No such file or directory)
2026-06-07  8:47:17 0 [Note] WSREP: restore pc from disk failed
2026-06-07  8:47:17 0 [Note] WSREP: GMCast version 0
2026-06-07  8:47:17 0 [Note] WSREP: (7cf7f374-8ebf, 'tcp://0.0.0.0:4567') listening at tcp://0.0.0.0:4567
2026-06-07  8:47:17 0 [Note] WSREP: (7cf7f374-8ebf, 'tcp://0.0.0.0:4567') multicast: , ttl: 1
2026-06-07  8:47:17 0 [Note] WSREP: EVS version 1
2026-06-07  8:47:17 0 [Note] WSREP: gcomm: connecting to group 'galera_cluster', peer 'tasks.app_db:'
2026-06-07  8:47:17 0 [Note] WSREP: (7cf7f374-8ebf, 'tcp://0.0.0.0:4567') Found matching local endpoint for a connection, blacklisting address tcp://172.28.3.7:4567
2026-06-07  8:47:18 0 [Note] WSREP: EVS version upgrade 0 -> 1
2026-06-07  8:47:18 0 [Note] WSREP: PC protocol upgrade 0 -> 1
2026-06-07  8:47:18 0 [Note] WSREP: No nodes coming from primary view, primary view is not possible
2026-06-07  8:47:18 0 [Note] WSREP: view(view_id(NON_PRIM,7cf7f374-8ebf,1) memb {
        7cf7f374-8ebf,0
} joined {
} left {
} partitioned {
})
2026-06-07  8:47:18 0 [Warning] WSREP: last inactive check more than PT1.5S ago (PT1.50101S), skipping check
2026-06-07  8:47:50 0 [Note] WSREP: PC protocol downgrade 1 -> 0
2026-06-07  8:47:50 0 [Note] WSREP: view((empty))
2026-06-07  8:47:50 0 [ERROR] WSREP: failed to open gcomm backend connection: 110: failed to reach primary view
         at ./gcomm/src/pc.cpp:connect():161
2026-06-07  8:47:50 0 [ERROR] WSREP: ./gcs/src/gcs_core.cpp:gcs_core_open():259: Failed to open backend connection: -110 (Connection timed out)
2026-06-07  8:47:50 0 [Note] WSREP: gcomm: terminating thread
2026-06-07  8:47:50 0 [Note] WSREP: gcomm: joining thread
2026-06-07  8:47:50 0 [Note] WSREP: gcomm: closing backend
2026-06-07  8:47:50 0 [Note] WSREP: gcomm: closed
2026-06-07  8:47:50 0 [ERROR] WSREP: ./gcs/src/gcs.cpp:gcs_open():1742: Failed to open channel 'galera_cluster' at 'gcomm://tasks.app_db': -110 (Connection timed out)
2026-06-07  8:47:50 0 [ERROR] WSREP: gcs connect failed: Operation timed out
2026-06-07  8:47:50 0 [ERROR] WSREP: wsrep::connect(gcomm://tasks.app_db) failed: 7
2026-06-07  8:47:50 0 [ERROR] Aborting

vagrant@db3:~$ docker logs app_db.ahnzot0jeb9pq89f4mk1ts2b9.s79zkul8y6ze2i3jq5g8d0236 2>&1 | tail -80
[galera] 08:48:50 Node identity → name=db3 address=172.28.3.13
[galera] 08:48:50 Evaluating cluster state...
[galera] 08:48:50 Datadir exists but grastate.dat missing
[galera] 08:48:50 Cluster address: gcomm://tasks.app_db
[galera] 08:48:50 Mode: JOIN
[galera] 08:48:50 Starting MariaDB...
2026-06-07 08:48:50+00:00 [Note] [Entrypoint]: Entrypoint script for MariaDB Server 1:10.11.18+maria~ubu2204 started.
2026-06-07 08:48:50+00:00 [Warn] [Entrypoint]: /sys/fs/cgroup///memory.pressure not writable, functionality unavailable to MariaDB
2026-06-07 08:48:50+00:00 [Note] [Entrypoint]: Switching to dedicated user 'mysql'
2026-06-07 08:48:50+00:00 [Note] [Entrypoint]: Entrypoint script for MariaDB Server 1:10.11.18+maria~ubu2204 started.
2026-06-07 08:48:51+00:00 [Note] [Entrypoint]: MariaDB upgrade not required
2026-06-07  8:48:51 0 [Note] Starting MariaDB 10.11.18-MariaDB-ubu2204 source revision 197f92bee02d8e836f529f37625be69b83e7acbd server_uid MPOie2H40giw5m/FGhIo528h1Zw= as process 1
2026-06-07  8:48:51 0 [Note] WSREP: Loading provider /usr/lib/galera/libgalera_smm.so initial position: 00000000-0000-0000-0000-000000000000:-1
2026-06-07  8:48:51 0 [Note] WSREP: wsrep_load(): loading provider library '/usr/lib/galera/libgalera_smm.so'
2026-06-07  8:48:51 0 [Note] WSREP: wsrep_load(): Galera 26.4.27(rf032a460) by Codership Oy <info@codership.com> loaded successfully.
2026-06-07  8:48:51 0 [Note] WSREP: Initializing allowlist service v1
2026-06-07  8:48:51 0 [Note] WSREP: Resolved symbol 'wsrep_node_isolation_mode_set_v1'
2026-06-07  8:48:51 0 [Note] WSREP: Resolved symbol 'wsrep_certify_v1'
2026-06-07  8:48:51 0 [Note] WSREP: CRC-32C: using 64-bit x86 acceleration.
2026-06-07  8:48:51 0 [Note] WSREP: Found saved state: 00000000-0000-0000-0000-000000000000:-1, safe_to_bootstrap: 1
2026-06-07  8:48:51 0 [Note] WSREP: GCache DEBUG: opened preamble:
Version: 0
UUID: 00000000-0000-0000-0000-000000000000
Seqno: -1 - -1
Offset: -1
Synced: 0
2026-06-07  8:48:51 0 [Note] WSREP: Skipped GCache ring buffer recovery: could not determine history UUID.
2026-06-07  8:48:51 0 [Note] WSREP: Passing config to GCS: base_dir = /var/lib/mysql/; base_host = 172.28.3.13; base_port = 4567; cert.log_conflicts = no; cert.optimistic_pa = yes; debug = no; evs.auto_evict = 0; evs.causal_keepalive_period = PT1S; evs.debug_log_mask = 0x1; evs.delay_margin = PT1S; evs.delayed_keep_period = PT30S; evs.inactive_check_period = PT0.5S; evs.inactive_timeout = PT1M; evs.info_log_mask = 0; evs.install_timeout = PT1M; evs.join_retrans_period = PT1S; evs.keepalive_period = PT3S; evs.max_install_timeouts = 3; evs.send_window = 4; evs.stats_report_period = PT1M; evs.suspect_timeout = PT30S; evs.use_aggregate = true; evs.user_send_window = 2; evs.version = 1; evs.view_forget_timeout = PT24H; gcache.dir = /var/lib/mysql/; gcache.keep_pages_size = 0; gcache.keep_plaintext_size = 128M; gcache.mem_size = 0; gcache.name = galera.cache; gcache.page_size = 128M; gcache.recover = yes; gcache.size = 256M; gcomm.thread_prio = ; gcs.check_appl_proto = 1; gcs.fc_debug = 0; gcs.fc_factor = 1.0; gcs.fc_limit = 16; gcs.fc_master
2026-06-07  8:48:51 0 [Note] WSREP: Start replication
2026-06-07  8:48:51 0 [Note] WSREP: Connecting with bootstrap option: 0
2026-06-07  8:48:51 0 [Note] WSREP: Setting GCS initial position to 00000000-0000-0000-0000-000000000000:-1
2026-06-07  8:48:51 0 [Note] WSREP: protonet asio version 0
2026-06-07  8:48:51 0 [Note] WSREP: Using CRC-32C for message checksums.
2026-06-07  8:48:51 0 [Note] WSREP: backend: asio
2026-06-07  8:48:51 0 [Note] WSREP: gcomm thread scheduling priority set to other:0 
2026-06-07  8:48:51 0 [Note] WSREP: access file(/var/lib/mysql//gvwstate.dat) failed(No such file or directory)
2026-06-07  8:48:51 0 [Note] WSREP: restore pc from disk failed
2026-06-07  8:48:51 0 [Note] WSREP: GMCast version 0
2026-06-07  8:48:51 0 [Note] WSREP: (b4e6a6a6-9ded, 'tcp://0.0.0.0:4567') listening at tcp://0.0.0.0:4567
2026-06-07  8:48:51 0 [Note] WSREP: (b4e6a6a6-9ded, 'tcp://0.0.0.0:4567') multicast: , ttl: 1
2026-06-07  8:48:51 0 [Note] WSREP: EVS version 1
2026-06-07  8:48:51 0 [Note] WSREP: gcomm: connecting to group 'galera_cluster', peer 'tasks.app_db:'
2026-06-07  8:48:51 0 [Note] WSREP: (b4e6a6a6-9ded, 'tcp://0.0.0.0:4567') Found matching local endpoint for a connection, blacklisting address tcp://172.28.3.13:4567
2026-06-07  8:48:52 0 [Note] WSREP: EVS version upgrade 0 -> 1
2026-06-07  8:48:52 0 [Note] WSREP: PC protocol upgrade 0 -> 1
2026-06-07  8:48:52 0 [Note] WSREP: No nodes coming from primary view, primary view is not possible
2026-06-07  8:48:52 0 [Note] WSREP: view(view_id(NON_PRIM,b4e6a6a6-9ded,1) memb {
        b4e6a6a6-9ded,0
} joined {
} left {
} partitioned {
})
2026-06-07  8:48:52 0 [Warning] WSREP: last inactive check more than PT1.5S ago (PT1.50073S), skipping check
2026-06-07  8:49:24 0 [Note] WSREP: PC protocol downgrade 1 -> 0
2026-06-07  8:49:24 0 [Note] WSREP: view((empty))
2026-06-07  8:49:24 0 [ERROR] WSREP: failed to open gcomm backend connection: 110: failed to reach primary view
         at ./gcomm/src/pc.cpp:connect():161
2026-06-07  8:49:24 0 [ERROR] WSREP: ./gcs/src/gcs_core.cpp:gcs_core_open():259: Failed to open backend connection: -110 (Connection timed out)
2026-06-07  8:49:24 0 [Note] WSREP: gcomm: terminating thread
2026-06-07  8:49:24 0 [Note] WSREP: gcomm: joining thread
2026-06-07  8:49:24 0 [Note] WSREP: gcomm: closing backend
2026-06-07  8:49:24 0 [Note] WSREP: gcomm: closed
2026-06-07  8:49:24 0 [ERROR] WSREP: ./gcs/src/gcs.cpp:gcs_open():1742: Failed to open channel 'galera_cluster' at 'gcomm://tasks.app_db': -110 (Connection timed out)
2026-06-07  8:49:24 0 [ERROR] WSREP: gcs connect failed: Operation timed out
2026-06-07  8:49:24 0 [ERROR] WSREP: wsrep::connect(gcomm://tasks.app_db) failed: 7
2026-06-07  8:49:24 0 [ERROR] Aborting