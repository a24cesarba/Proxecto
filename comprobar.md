vagrant@web1:~$ docker service ps app_db --no-trunc
ID                          NAME                                   IMAGE                                                                                                     NODE      DESIRED STATE   CURRENT STATE                ERROR                       PORTS
zpht268g9r9r5dqwmoepzi327   app_db.98g8jhdfd5qjjfnxlg1ef7qck       a24cesarba/galera-mariadb:10.11@sha256:f01125750776e965e19b3f6e4a13488f876d061c32234cdda9c19de1c50ccab1   db2       Running         Running 14 seconds ago                                   
ovb671rai8zt2xzpy7hgze1m2    \_ app_db.98g8jhdfd5qjjfnxlg1ef7qck   a24cesarba/galera-mariadb:10.11@sha256:f01125750776e965e19b3f6e4a13488f876d061c32234cdda9c19de1c50ccab1   db2       Shutdown        Failed 25 seconds ago        "task: non-zero exit (1)"   
93vfwuld0qdt2ezsfzvz7mvlb    \_ app_db.98g8jhdfd5qjjfnxlg1ef7qck   a24cesarba/galera-mariadb:10.11@sha256:f01125750776e965e19b3f6e4a13488f876d061c32234cdda9c19de1c50ccab1   db2       Shutdown        Failed about a minute ago    "task: non-zero exit (1)"   
43ws199wyqip5vr25ajj5q8gt    \_ app_db.98g8jhdfd5qjjfnxlg1ef7qck   a24cesarba/galera-mariadb:10.11@sha256:f01125750776e965e19b3f6e4a13488f876d061c32234cdda9c19de1c50ccab1   db2       Shutdown        Failed about a minute ago    "task: non-zero exit (1)"   
ec8t0a08pn33csla7hkreu5ia    \_ app_db.98g8jhdfd5qjjfnxlg1ef7qck   a24cesarba/galera-mariadb:10.11@sha256:f01125750776e965e19b3f6e4a13488f876d061c32234cdda9c19de1c50ccab1   db2       Shutdown        Failed 2 minutes ago         "task: non-zero exit (1)"   
uverkfw2on8jrstvxitydlmqe    \_ app_db.98g8jhdfd5qjjfnxlg1ef7qck   a24cesarba/galera-mariadb:10.11@sha256:f01125750776e965e19b3f6e4a13488f876d061c32234cdda9c19de1c50ccab1   db2       Shutdown        Failed 3 minutes ago         "task: non-zero exit (1)"   
nmxxgsldxqlas7asmuluu262u   app_db.rwmvu10jm45n7unezymut1ktp       a24cesarba/galera-mariadb:10.11@sha256:f01125750776e965e19b3f6e4a13488f876d061c32234cdda9c19de1c50ccab1   db3       Running         Running 2 seconds ago                                    
ztso8acu4iwh0tda6aurf1nub    \_ app_db.rwmvu10jm45n7unezymut1ktp   a24cesarba/galera-mariadb:10.11@sha256:f01125750776e965e19b3f6e4a13488f876d061c32234cdda9c19de1c50ccab1   db3       Shutdown        Failed 13 seconds ago        "task: non-zero exit (1)"   
iwwtb9p6sc6kapm1s97awh1y4    \_ app_db.rwmvu10jm45n7unezymut1ktp   a24cesarba/galera-mariadb:10.11@sha256:f01125750776e965e19b3f6e4a13488f876d061c32234cdda9c19de1c50ccab1   db3       Shutdown        Failed 57 seconds ago        "task: non-zero exit (1)"   
vzk2hefjr0fm96t1820xv471k    \_ app_db.rwmvu10jm45n7unezymut1ktp   a24cesarba/galera-mariadb:10.11@sha256:f01125750776e965e19b3f6e4a13488f876d061c32234cdda9c19de1c50ccab1   db3       Shutdown        Failed about a minute ago    "task: non-zero exit (1)"   
ngo7f97b4mtre3ww6xg4z7owf    \_ app_db.rwmvu10jm45n7unezymut1ktp   a24cesarba/galera-mariadb:10.11@sha256:f01125750776e965e19b3f6e4a13488f876d061c32234cdda9c19de1c50ccab1   db3       Shutdown        Failed 2 minutes ago         "task: non-zero exit (1)"   
rcyaj738e399tt7phoomi01vm    \_ app_db.rwmvu10jm45n7unezymut1ktp   a24cesarba/galera-mariadb:10.11@sha256:f01125750776e965e19b3f6e4a13488f876d061c32234cdda9c19de1c50ccab1   db3       Shutdown        Failed 3 minutes ago         "task: non-zero exit (1)"   
sob50sx1yosdfin5yd9hxuebh   app_db.yxcxjom455a5gwgjb04s38m2w       a24cesarba/galera-mariadb:10.11@sha256:f01125750776e965e19b3f6e4a13488f876d061c32234cdda9c19de1c50ccab1   db1       Running         Running about an hour ago                                
zonm1ggsluchbggw8m1aeq8uw    \_ app_db.yxcxjom455a5gwgjb04s38m2w   a24cesarba/galera-mariadb:10.11@sha256:789f2816ce88f6e304d9f9cfc44e074ce90194ddb6f22365211fb2b664440f4d   db1       Shutdown        Shutdown about an hour ago    

vagrant@db2:~$ docker logs app_db.98g8jhdfd5qjjfnxlg1ef7qck.
app_db.98g8jhdfd5qjjfnxlg1ef7qck.43ws199wyqip5vr25ajj5q8gt  app_db.98g8jhdfd5qjjfnxlg1ef7qck.ovb671rai8zt2xzpy7hgze1m2
app_db.98g8jhdfd5qjjfnxlg1ef7qck.93vfwuld0qdt2ezsfzvz7mvlb  app_db.98g8jhdfd5qjjfnxlg1ef7qck.utb6cgqvvlkf26tiy560h6ffo
app_db.98g8jhdfd5qjjfnxlg1ef7qck.ec8t0a08pn33csla7hkreu5ia  app_db.98g8jhdfd5qjjfnxlg1ef7qck.zpht268g9r9r5dqwmoepzi327

many containers on db2 node

.0.sob50sx1yosd@db1    | 2026-06-06 18:38:11 1 [Note] WSREP: Server status change joined -> synced
app_db.0.sob50sx1yosd@db1    | 2026-06-06 18:38:11 1 [Note] WSREP: Synchronized with group, ready for connections
app_db.0.sob50sx1yosd@db1    | 2026-06-06 18:38:11 1 [Note] WSREP: wsrep_notify_cmd is not defined, skipping notification.
app_db.0.sob50sx1yosd@db1    | 2026-06-06 18:38:11 7 [Note] WSREP: Starting applier thread 7
app_db.0.sob50sx1yosd@db1    | 2026-06-06 18:38:11 0 [Note] mariadbd: ready for connections.
app_db.0.sob50sx1yosd@db1    | Version: '10.11.18-MariaDB-ubu2204'  socket: '/run/mysqld/mysqld.sock'  port: 3306  mariadb.org binary distribution
app_db.0.iesgaev27l2b@db2    | [galera] 19:42:37 Node identity → name=db2  overlay_addr=172.28.3.136
app_db.0.iesgaev27l2b@db2    | [galera] 19:42:37 Evaluating cluster state...
app_db.0.iesgaev27l2b@db2    | [galera] 19:42:37 Found existing datadir with grastate.dat
app_db.0.iesgaev27l2b@db2    | [galera] 19:42:37 safe_to_bootstrap=0 → joining existing cluster (IST/SST will sync state)
app_db.0.iesgaev27l2b@db2    | [galera] 19:42:37 Writing runtime config → /etc/mysql/mariadb.conf.d/61-galera-runtime.cnf
app_db.0.iesgaev27l2b@db2    | [galera] 19:42:37 Mode: JOIN       → mariadbd (normal start)
app_db.0.iesgaev27l2b@db2    | [galera] 19:42:37 Handing off to docker-entrypoint.sh...
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:42:37+00:00 [Note] [Entrypoint]: Entrypoint script for MariaDB Server 1:10.11.18+maria~ubu2204 started.
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:42:37+00:00 [Warn] [Entrypoint]: /sys/fs/cgroup///memory.pressure not writable, functionality unavailable to MariaDB
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:42:37+00:00 [Note] [Entrypoint]: Switching to dedicated user 'mysql'
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:42:37+00:00 [Note] [Entrypoint]: Entrypoint script for MariaDB Server 1:10.11.18+maria~ubu2204 started.
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:42:37+00:00 [Note] [Entrypoint]: MariaDB upgrade not required
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:42:37 0 [Note] Starting MariaDB 10.11.18-MariaDB-ubu2204 source revision 197f92bee02d8e836f529f37625be69b83e7acbd server_uid cs1s3w8u9cT/Y5BS6AujUtmt9tA= as process 1
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:42:37 0 [Note] WSREP: Loading provider /usr/lib/galera/libgalera_smm.so initial position: 00000000-0000-0000-0000-000000000000:-1
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:42:37 0 [Note] WSREP: wsrep_load(): loading provider library '/usr/lib/galera/libgalera_smm.so'
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:42:37 0 [Note] WSREP: wsrep_load(): Galera 26.4.27(rf032a460) by Codership Oy <info@codership.com> loaded successfully.
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:42:37 0 [Note] WSREP: Initializing allowlist service v1
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:42:37 0 [Note] WSREP: Resolved symbol 'wsrep_node_isolation_mode_set_v1'
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:42:37 0 [Note] WSREP: Resolved symbol 'wsrep_certify_v1'
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:42:37 0 [Note] WSREP: CRC-32C: using 64-bit x86 acceleration.
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:42:37 0 [Note] WSREP: Found saved state: 00000000-0000-0000-0000-000000000000:-1, safe_to_bootstrap: 1
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:42:37 0 [Note] WSREP: GCache DEBUG: opened preamble:
app_db.0.iesgaev27l2b@db2    | Version: 2
app_db.0.iesgaev27l2b@db2    | UUID: 00000000-0000-0000-0000-000000000000
app_db.0.iesgaev27l2b@db2    | Seqno: -1 - -1
app_db.0.iesgaev27l2b@db2    | Offset: -1
app_db.0.iesgaev27l2b@db2    | Synced: 1
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:42:37 0 [Note] WSREP: Skipped GCache ring buffer recovery: could not determine history UUID.
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:42:37 0 [Note] WSREP: Passing config to GCS: base_dir = /var/lib/mysql/; base_host = 172.28.3.136; base_port = 4567; cert.log_conflicts = no; cert.optimistic_pa = yes; debug = no; evs.auto_evict = 0; evs.causal_keepalive_period = PT1S; evs.debug_log_mask = 0x1; evs.delay_margin = PT1S; evs.delayed_keep_period = PT30S; evs.inactive_check_period = PT0.5S; evs.inactive_timeout = PT1M; evs.info_log_mask = 0; evs.install_timeout = PT1M; evs.join_retrans_period = PT1S; evs.keepalive_period = PT3S; evs.max_install_timeouts = 3; evs.send_window = 4; evs.stats_report_period = PT1M; evs.suspect_timeout = PT30S; evs.use_aggregate = true; evs.user_send_window = 2; evs.version = 1; evs.view_forget_timeout = PT24H; gcache.dir = /var/lib/mysql/; gcache.keep_pages_size = 0; gcache.keep_plaintext_size = 128M; gcache.mem_size = 0; gcache.name = galera.cache; gcache.page_size = 128M; gcache.recover = yes; gcache.size = 256M; gcomm.thread_prio = ; gcs.check_appl_proto = 1; gcs.fc_debug = 0; gcs.fc_factor = 1.0; gcs.fc_limit = 16; gcs.fc_maste
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:42:37 0 [Note] WSREP: Start replication
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:42:37 0 [Note] WSREP: Connecting with bootstrap option: 0
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:42:37 0 [Note] WSREP: Setting GCS initial position to 00000000-0000-0000-0000-000000000000:-1
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:42:37 0 [Note] WSREP: protonet asio version 0
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:42:37 0 [Note] WSREP: Using CRC-32C for message checksums.
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:42:37 0 [Note] WSREP: backend: asio
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:42:37 0 [Note] WSREP: gcomm thread scheduling priority set to other:0 
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:42:37 0 [Note] WSREP: access file(/var/lib/mysql//gvwstate.dat) failed(No such file or directory)
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:42:37 0 [Note] WSREP: restore pc from disk failed
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:42:37 0 [Note] WSREP: GMCast version 0
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:42:37 0 [Note] WSREP: (df707cd2-8983, 'tcp://0.0.0.0:4567') listening at tcp://0.0.0.0:4567
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:42:37 0 [Note] WSREP: (df707cd2-8983, 'tcp://0.0.0.0:4567') multicast: , ttl: 1
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:42:37 0 [Note] WSREP: EVS version 1
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:42:37 0 [Note] WSREP: gcomm: connecting to group 'galera_cluster', peer 'app_db:'
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:42:37 0 [Note] WSREP: (df707cd2-8983, 'tcp://0.0.0.0:4567') Found matching local endpoint for a connection, blacklisting address tcp://172.28.3.136:4567
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:42:38 0 [Note] WSREP: EVS version upgrade 0 -> 1
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:42:38 0 [Note] WSREP: PC protocol upgrade 0 -> 1
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:42:38 0 [Note] WSREP: No nodes coming from primary view, primary view is not possible
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:42:38 0 [Note] WSREP: view(view_id(NON_PRIM,df707cd2-8983,1) memb {
app_db.0.iesgaev27l2b@db2    |  df707cd2-8983,0
app_db.0.iesgaev27l2b@db2    | } joined {
app_db.0.iesgaev27l2b@db2    | } left {
app_db.0.iesgaev27l2b@db2    | } partitioned {
app_db.0.iesgaev27l2b@db2    | })
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:42:39 0 [Warning] WSREP: last inactive check more than PT1.5S ago (PT1.50046S), skipping check
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:43:10 0 [Note] WSREP: PC protocol downgrade 1 -> 0
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:43:10 0 [Note] WSREP: view((empty))
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:43:10 0 [ERROR] WSREP: failed to open gcomm backend connection: 110: failed to reach primary view
app_db.0.iesgaev27l2b@db2    |   at ./gcomm/src/pc.cpp:connect():161
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:43:10 0 [ERROR] WSREP: ./gcs/src/gcs_core.cpp:gcs_core_open():259: Failed to open backend connection: -110 (Connection timed out)
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:43:10 0 [Note] WSREP: gcomm: terminating thread
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:43:10 0 [Note] WSREP: gcomm: joining thread
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:43:10 0 [Note] WSREP: gcomm: closing backend
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:43:10 0 [Note] WSREP: gcomm: closed
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:43:10 0 [ERROR] WSREP: ./gcs/src/gcs.cpp:gcs_open():1742: Failed to open channel 'galera_cluster' at 'gcomm://app_db': -110 (Connection timed out)
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:43:10 0 [ERROR] WSREP: gcs connect failed: Operation timed out
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:43:10 0 [ERROR] WSREP: wsrep::connect(gcomm://app_db) failed: 7
app_db.0.iesgaev27l2b@db2    | 2026-06-06 19:43:10 0 [ERROR] Aborting
app_db.0.bv09iubxh35h@db2    | [galera] 19:43:21 Node identity → name=db2  overlay_addr=172.28.3.140
app_db.0.bv09iubxh35h@db2    | [galera] 19:43:21 Evaluating cluster state...
app_db.0.bv09iubxh35h@db2    | [galera] 19:43:21 Found existing datadir with grastate.dat
app_db.0.bv09iubxh35h@db2    | [galera] 19:43:21 safe_to_bootstrap=0 → joining existing cluster (IST/SST will sync state)
app_db.0.bv09iubxh35h@db2    | [galera] 19:43:21 Writing runtime config → /etc/mysql/mariadb.conf.d/61-galera-runtime.cnf
app_db.0.bv09iubxh35h@db2    | [galera] 19:43:21 Mode: JOIN       → mariadbd (normal start)
app_db.0.bv09iubxh35h@db2    | [galera] 19:43:21 Handing off to docker-entrypoint.sh...
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:21+00:00 [Note] [Entrypoint]: Entrypoint script for MariaDB Server 1:10.11.18+maria~ubu2204 started.
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:22+00:00 [Warn] [Entrypoint]: /sys/fs/cgroup///memory.pressure not writable, functionality unavailable to MariaDB
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:22+00:00 [Note] [Entrypoint]: Switching to dedicated user 'mysql'
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:22+00:00 [Note] [Entrypoint]: Entrypoint script for MariaDB Server 1:10.11.18+maria~ubu2204 started.
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:22+00:00 [Note] [Entrypoint]: MariaDB upgrade not required
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:22 0 [Note] Starting MariaDB 10.11.18-MariaDB-ubu2204 source revision 197f92bee02d8e836f529f37625be69b83e7acbd server_uid bmNLPlm8SQY6c/WMVcnBk44c8jk= as process 1
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:22 0 [Note] WSREP: Loading provider /usr/lib/galera/libgalera_smm.so initial position: 00000000-0000-0000-0000-000000000000:-1
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:22 0 [Note] WSREP: wsrep_load(): loading provider library '/usr/lib/galera/libgalera_smm.so'
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:22 0 [Note] WSREP: wsrep_load(): Galera 26.4.27(rf032a460) by Codership Oy <info@codership.com> loaded successfully.
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:22 0 [Note] WSREP: Initializing allowlist service v1
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:22 0 [Note] WSREP: Resolved symbol 'wsrep_node_isolation_mode_set_v1'
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:22 0 [Note] WSREP: Resolved symbol 'wsrep_certify_v1'
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:22 0 [Note] WSREP: CRC-32C: using 64-bit x86 acceleration.
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:22 0 [Note] WSREP: Found saved state: 00000000-0000-0000-0000-000000000000:-1, safe_to_bootstrap: 1
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:22 0 [Note] WSREP: GCache DEBUG: opened preamble:
app_db.0.bv09iubxh35h@db2    | Version: 2
app_db.0.bv09iubxh35h@db2    | UUID: 00000000-0000-0000-0000-000000000000
app_db.0.bv09iubxh35h@db2    | Seqno: -1 - -1
app_db.0.bv09iubxh35h@db2    | Offset: -1
app_db.0.bv09iubxh35h@db2    | Synced: 1
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:22 0 [Note] WSREP: Skipped GCache ring buffer recovery: could not determine history UUID.
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:22 0 [Note] WSREP: Passing config to GCS: base_dir = /var/lib/mysql/; base_host = 172.28.3.140; base_port = 4567; cert.log_conflicts = no; cert.optimistic_pa = yes; debug = no; evs.auto_evict = 0; evs.causal_keepalive_period = PT1S; evs.debug_log_mask = 0x1; evs.delay_margin = PT1S; evs.delayed_keep_period = PT30S; evs.inactive_check_period = PT0.5S; evs.inactive_timeout = PT1M; evs.info_log_mask = 0; evs.install_timeout = PT1M; evs.join_retrans_period = PT1S; evs.keepalive_period = PT3S; evs.max_install_timeouts = 3; evs.send_window = 4; evs.stats_report_period = PT1M; evs.suspect_timeout = PT30S; evs.use_aggregate = true; evs.user_send_window = 2; evs.version = 1; evs.view_forget_timeout = PT24H; gcache.dir = /var/lib/mysql/; gcache.keep_pages_size = 0; gcache.keep_plaintext_size = 128M; gcache.mem_size = 0; gcache.name = galera.cache; gcache.page_size = 128M; gcache.recover = yes; gcache.size = 256M; gcomm.thread_prio = ; gcs.check_appl_proto = 1; gcs.fc_debug = 0; gcs.fc_factor = 1.0; gcs.fc_limit = 16; gcs.fc_maste
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:22 0 [Note] WSREP: Start replication
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:22 0 [Note] WSREP: Connecting with bootstrap option: 0
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:22 0 [Note] WSREP: Setting GCS initial position to 00000000-0000-0000-0000-000000000000:-1
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:22 0 [Note] WSREP: protonet asio version 0
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:22 0 [Note] WSREP: Using CRC-32C for message checksums.
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:22 0 [Note] WSREP: backend: asio
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:22 0 [Note] WSREP: gcomm thread scheduling priority set to other:0 
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:22 0 [Note] WSREP: access file(/var/lib/mysql//gvwstate.dat) failed(No such file or directory)
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:22 0 [Note] WSREP: restore pc from disk failed
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:22 0 [Note] WSREP: GMCast version 0
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:22 0 [Note] WSREP: (f9f179d9-af1b, 'tcp://0.0.0.0:4567') listening at tcp://0.0.0.0:4567
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:22 0 [Note] WSREP: (f9f179d9-af1b, 'tcp://0.0.0.0:4567') multicast: , ttl: 1
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:22 0 [Note] WSREP: EVS version 1
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:22 0 [Note] WSREP: gcomm: connecting to group 'galera_cluster', peer 'app_db:'
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:22 0 [Note] WSREP: (f9f179d9-af1b, 'tcp://0.0.0.0:4567') Found matching local endpoint for a connection, blacklisting address tcp://172.28.3.140:4567
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:23 0 [Note] WSREP: EVS version upgrade 0 -> 1
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:23 0 [Note] WSREP: PC protocol upgrade 0 -> 1
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:23 0 [Note] WSREP: No nodes coming from primary view, primary view is not possible
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:23 0 [Note] WSREP: view(view_id(NON_PRIM,f9f179d9-af1b,1) memb {
app_db.0.bv09iubxh35h@db2    |  f9f179d9-af1b,0
app_db.0.bv09iubxh35h@db2    | } joined {
app_db.0.bv09iubxh35h@db2    | } left {
app_db.0.bv09iubxh35h@db2    | } partitioned {
app_db.0.bv09iubxh35h@db2    | })
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:23 0 [Warning] WSREP: last inactive check more than PT1.5S ago (PT1.50058S), skipping check
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:55 0 [Note] WSREP: PC protocol downgrade 1 -> 0
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:55 0 [Note] WSREP: view((empty))
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:55 0 [ERROR] WSREP: failed to open gcomm backend connection: 110: failed to reach primary view
app_db.0.bv09iubxh35h@db2    |   at ./gcomm/src/pc.cpp:connect():161
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:55 0 [ERROR] WSREP: ./gcs/src/gcs_core.cpp:gcs_core_open():259: Failed to open backend connection: -110 (Connection timed out)
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:55 0 [Note] WSREP: gcomm: terminating thread
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:55 0 [Note] WSREP: gcomm: joining thread
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:55 0 [Note] WSREP: gcomm: closing backend
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:55 0 [Note] WSREP: gcomm: closed
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:55 0 [ERROR] WSREP: ./gcs/src/gcs.cpp:gcs_open():1742: Failed to open channel 'galera_cluster' at 'gcomm://app_db': -110 (Connection timed out)
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:55 0 [ERROR] WSREP: gcs connect failed: Operation timed out
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:55 0 [ERROR] WSREP: wsrep::connect(gcomm://app_db) failed: 7
app_db.0.bv09iubxh35h@db2    | 2026-06-06 19:43:55 0 [ERROR] Aborting
app_db.0.fs2feefeeqlm@db2    | [galera] 19:44:06 Node identity → name=db2  overlay_addr=172.28.3.144
app_db.0.fs2feefeeqlm@db2    | [galera] 19:44:06 Evaluating cluster state...
app_db.0.fs2feefeeqlm@db2    | [galera] 19:44:06 Found existing datadir with grastate.dat
app_db.0.fs2feefeeqlm@db2    | [galera] 19:44:06 safe_to_bootstrap=0 → joining existing cluster (IST/SST will sync state)
app_db.0.fs2feefeeqlm@db2    | [galera] 19:44:06 Writing runtime config → /etc/mysql/mariadb.conf.d/61-galera-runtime.cnf
app_db.0.fs2feefeeqlm@db2    | [galera] 19:44:06 Mode: JOIN       → mariadbd (normal start)
app_db.0.fs2feefeeqlm@db2    | [galera] 19:44:06 Handing off to docker-entrypoint.sh...
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:06+00:00 [Note] [Entrypoint]: Entrypoint script for MariaDB Server 1:10.11.18+maria~ubu2204 started.
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:06+00:00 [Warn] [Entrypoint]: /sys/fs/cgroup///memory.pressure not writable, functionality unavailable to MariaDB
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:06+00:00 [Note] [Entrypoint]: Switching to dedicated user 'mysql'
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:06+00:00 [Note] [Entrypoint]: Entrypoint script for MariaDB Server 1:10.11.18+maria~ubu2204 started.
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:07+00:00 [Note] [Entrypoint]: MariaDB upgrade not required
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:07 0 [Note] Starting MariaDB 10.11.18-MariaDB-ubu2204 source revision 197f92bee02d8e836f529f37625be69b83e7acbd server_uid pVI1BoT/onZfl+eC3TGojOLYgA4= as process 1
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:07 0 [Note] WSREP: Loading provider /usr/lib/galera/libgalera_smm.so initial position: 00000000-0000-0000-0000-000000000000:-1
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:07 0 [Note] WSREP: wsrep_load(): loading provider library '/usr/lib/galera/libgalera_smm.so'
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:07 0 [Note] WSREP: wsrep_load(): Galera 26.4.27(rf032a460) by Codership Oy <info@codership.com> loaded successfully.
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:07 0 [Note] WSREP: Initializing allowlist service v1
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:07 0 [Note] WSREP: Resolved symbol 'wsrep_node_isolation_mode_set_v1'
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:07 0 [Note] WSREP: Resolved symbol 'wsrep_certify_v1'
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:07 0 [Note] WSREP: CRC-32C: using 64-bit x86 acceleration.
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:07 0 [Note] WSREP: Found saved state: 00000000-0000-0000-0000-000000000000:-1, safe_to_bootstrap: 1
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:07 0 [Note] WSREP: GCache DEBUG: opened preamble:
app_db.0.fs2feefeeqlm@db2    | Version: 2
app_db.0.fs2feefeeqlm@db2    | UUID: 00000000-0000-0000-0000-000000000000
app_db.0.fs2feefeeqlm@db2    | Seqno: -1 - -1
app_db.0.fs2feefeeqlm@db2    | Offset: -1
app_db.0.fs2feefeeqlm@db2    | Synced: 1
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:07 0 [Note] WSREP: Skipped GCache ring buffer recovery: could not determine history UUID.
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:07 0 [Note] WSREP: Passing config to GCS: base_dir = /var/lib/mysql/; base_host = 172.28.3.144; base_port = 4567; cert.log_conflicts = no; cert.optimistic_pa = yes; debug = no; evs.auto_evict = 0; evs.causal_keepalive_period = PT1S; evs.debug_log_mask = 0x1; evs.delay_margin = PT1S; evs.delayed_keep_period = PT30S; evs.inactive_check_period = PT0.5S; evs.inactive_timeout = PT1M; evs.info_log_mask = 0; evs.install_timeout = PT1M; evs.join_retrans_period = PT1S; evs.keepalive_period = PT3S; evs.max_install_timeouts = 3; evs.send_window = 4; evs.stats_report_period = PT1M; evs.suspect_timeout = PT30S; evs.use_aggregate = true; evs.user_send_window = 2; evs.version = 1; evs.view_forget_timeout = PT24H; gcache.dir = /var/lib/mysql/; gcache.keep_pages_size = 0; gcache.keep_plaintext_size = 128M; gcache.mem_size = 0; gcache.name = galera.cache; gcache.page_size = 128M; gcache.recover = yes; gcache.size = 256M; gcomm.thread_prio = ; gcs.check_appl_proto = 1; gcs.fc_debug = 0; gcs.fc_factor = 1.0; gcs.fc_limit = 16; gcs.fc_maste
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:07 0 [Note] WSREP: Start replication
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:07 0 [Note] WSREP: Connecting with bootstrap option: 0
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:07 0 [Note] WSREP: Setting GCS initial position to 00000000-0000-0000-0000-000000000000:-1
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:07 0 [Note] WSREP: protonet asio version 0
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:07 0 [Note] WSREP: Using CRC-32C for message checksums.
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:07 0 [Note] WSREP: backend: asio
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:07 0 [Note] WSREP: gcomm thread scheduling priority set to other:0 
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:07 0 [Note] WSREP: access file(/var/lib/mysql//gvwstate.dat) failed(No such file or directory)
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:07 0 [Note] WSREP: restore pc from disk failed
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:07 0 [Note] WSREP: GMCast version 0
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:07 0 [Note] WSREP: (14a52cbf-a78b, 'tcp://0.0.0.0:4567') listening at tcp://0.0.0.0:4567
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:07 0 [Note] WSREP: (14a52cbf-a78b, 'tcp://0.0.0.0:4567') multicast: , ttl: 1
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:07 0 [Note] WSREP: EVS version 1
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:07 0 [Note] WSREP: gcomm: connecting to group 'galera_cluster', peer 'app_db:'
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:07 0 [Note] WSREP: (14a52cbf-a78b, 'tcp://0.0.0.0:4567') Found matching local endpoint for a connection, blacklisting address tcp://172.28.3.144:4567
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:08 0 [Note] WSREP: EVS version upgrade 0 -> 1
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:08 0 [Note] WSREP: PC protocol upgrade 0 -> 1
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:08 0 [Note] WSREP: No nodes coming from primary view, primary view is not possible
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:08 0 [Note] WSREP: view(view_id(NON_PRIM,14a52cbf-a78b,1) memb {
app_db.0.fs2feefeeqlm@db2    |  14a52cbf-a78b,0
app_db.0.fs2feefeeqlm@db2    | } joined {
app_db.0.fs2feefeeqlm@db2    | } left {
app_db.0.fs2feefeeqlm@db2    | } partitioned {
app_db.0.fs2feefeeqlm@db2    | })
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:08 0 [Warning] WSREP: last inactive check more than PT1.5S ago (PT1.50062S), skipping check
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:40 0 [Note] WSREP: PC protocol downgrade 1 -> 0
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:40 0 [Note] WSREP: view((empty))
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:40 0 [ERROR] WSREP: failed to open gcomm backend connection: 110: failed to reach primary view
app_db.0.fs2feefeeqlm@db2    |   at ./gcomm/src/pc.cpp:connect():161
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:40 0 [ERROR] WSREP: ./gcs/src/gcs_core.cpp:gcs_core_open():259: Failed to open backend connection: -110 (Connection timed out)
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:40 0 [Note] WSREP: gcomm: terminating thread
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:40 0 [Note] WSREP: gcomm: joining thread
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:40 0 [Note] WSREP: gcomm: closing backend
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:40 0 [Note] WSREP: gcomm: closed
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:40 0 [ERROR] WSREP: ./gcs/src/gcs.cpp:gcs_open():1742: Failed to open channel 'galera_cluster' at 'gcomm://app_db': -110 (Connection timed out)
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:40 0 [ERROR] WSREP: gcs connect failed: Operation timed out
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:40 0 [ERROR] WSREP: wsrep::connect(gcomm://app_db) failed: 7
app_db.0.fs2feefeeqlm@db2    | 2026-06-06 19:44:40 0 [ERROR] Aborting
app_db.0.uverkfw2on8j@db2    | [galera] 19:44:51 Node identity → name=db2  overlay_addr=172.28.3.148
app_db.0.uverkfw2on8j@db2    | [galera] 19:44:51 Evaluating cluster state...
app_db.0.uverkfw2on8j@db2    | [galera] 19:44:51 Found existing datadir with grastate.dat
app_db.0.uverkfw2on8j@db2    | [galera] 19:44:51 safe_to_bootstrap=0 → joining existing cluster (IST/SST will sync state)
app_db.0.uverkfw2on8j@db2    | [galera] 19:44:51 Writing runtime config → /etc/mysql/mariadb.conf.d/61-galera-runtime.cnf
app_db.0.uverkfw2on8j@db2    | [galera] 19:44:51 Mode: JOIN       → mariadbd (normal start)
app_db.0.uverkfw2on8j@db2    | [galera] 19:44:51 Handing off to docker-entrypoint.sh...
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:44:51+00:00 [Note] [Entrypoint]: Entrypoint script for MariaDB Server 1:10.11.18+maria~ubu2204 started.
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:44:51+00:00 [Warn] [Entrypoint]: /sys/fs/cgroup///memory.pressure not writable, functionality unavailable to MariaDB
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:44:51+00:00 [Note] [Entrypoint]: Switching to dedicated user 'mysql'
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:44:51+00:00 [Note] [Entrypoint]: Entrypoint script for MariaDB Server 1:10.11.18+maria~ubu2204 started.
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:44:51+00:00 [Note] [Entrypoint]: MariaDB upgrade not required
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:44:51 0 [Note] Starting MariaDB 10.11.18-MariaDB-ubu2204 source revision 197f92bee02d8e836f529f37625be69b83e7acbd server_uid +iqCEVxv9jhAI+oEyKW2/U+rCPI= as process 1
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:44:51 0 [Note] WSREP: Loading provider /usr/lib/galera/libgalera_smm.so initial position: 00000000-0000-0000-0000-000000000000:-1
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:44:51 0 [Note] WSREP: wsrep_load(): loading provider library '/usr/lib/galera/libgalera_smm.so'
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:44:51 0 [Note] WSREP: wsrep_load(): Galera 26.4.27(rf032a460) by Codership Oy <info@codership.com> loaded successfully.
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:44:51 0 [Note] WSREP: Initializing allowlist service v1
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:44:51 0 [Note] WSREP: Resolved symbol 'wsrep_node_isolation_mode_set_v1'
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:44:51 0 [Note] WSREP: Resolved symbol 'wsrep_certify_v1'
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:44:51 0 [Note] WSREP: CRC-32C: using 64-bit x86 acceleration.
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:44:51 0 [Note] WSREP: Found saved state: 00000000-0000-0000-0000-000000000000:-1, safe_to_bootstrap: 1
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:44:51 0 [Note] WSREP: GCache DEBUG: opened preamble:
app_db.0.uverkfw2on8j@db2    | Version: 2
app_db.0.uverkfw2on8j@db2    | UUID: 00000000-0000-0000-0000-000000000000
app_db.0.uverkfw2on8j@db2    | Seqno: -1 - -1
app_db.0.uverkfw2on8j@db2    | Offset: -1
app_db.0.uverkfw2on8j@db2    | Synced: 1
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:44:51 0 [Note] WSREP: Skipped GCache ring buffer recovery: could not determine history UUID.
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:44:51 0 [Note] WSREP: Passing config to GCS: base_dir = /var/lib/mysql/; base_host = 172.28.3.148; base_port = 4567; cert.log_conflicts = no; cert.optimistic_pa = yes; debug = no; evs.auto_evict = 0; evs.causal_keepalive_period = PT1S; evs.debug_log_mask = 0x1; evs.delay_margin = PT1S; evs.delayed_keep_period = PT30S; evs.inactive_check_period = PT0.5S; evs.inactive_timeout = PT1M; evs.info_log_mask = 0; evs.install_timeout = PT1M; evs.join_retrans_period = PT1S; evs.keepalive_period = PT3S; evs.max_install_timeouts = 3; evs.send_window = 4; evs.stats_report_period = PT1M; evs.suspect_timeout = PT30S; evs.use_aggregate = true; evs.user_send_window = 2; evs.version = 1; evs.view_forget_timeout = PT24H; gcache.dir = /var/lib/mysql/; gcache.keep_pages_size = 0; gcache.keep_plaintext_size = 128M; gcache.mem_size = 0; gcache.name = galera.cache; gcache.page_size = 128M; gcache.recover = yes; gcache.size = 256M; gcomm.thread_prio = ; gcs.check_appl_proto = 1; gcs.fc_debug = 0; gcs.fc_factor = 1.0; gcs.fc_limit = 16; gcs.fc_maste
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:44:51 0 [Note] WSREP: Start replication
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:44:51 0 [Note] WSREP: Connecting with bootstrap option: 0
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:44:51 0 [Note] WSREP: Setting GCS initial position to 00000000-0000-0000-0000-000000000000:-1
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:44:51 0 [Note] WSREP: protonet asio version 0
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:44:51 0 [Note] WSREP: Using CRC-32C for message checksums.
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:44:51 0 [Note] WSREP: backend: asio
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:44:51 0 [Note] WSREP: gcomm thread scheduling priority set to other:0 
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:44:51 0 [Note] WSREP: access file(/var/lib/mysql//gvwstate.dat) failed(No such file or directory)
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:44:51 0 [Note] WSREP: restore pc from disk failed
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:44:51 0 [Note] WSREP: GMCast version 0
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:44:51 0 [Note] WSREP: (2f209250-816a, 'tcp://0.0.0.0:4567') listening at tcp://0.0.0.0:4567
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:44:51 0 [Note] WSREP: (2f209250-816a, 'tcp://0.0.0.0:4567') multicast: , ttl: 1
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:44:51 0 [Note] WSREP: EVS version 1
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:44:51 0 [Note] WSREP: gcomm: connecting to group 'galera_cluster', peer 'app_db:'
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:44:51 0 [Note] WSREP: (2f209250-816a, 'tcp://0.0.0.0:4567') Found matching local endpoint for a connection, blacklisting address tcp://172.28.3.148:4567
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:44:52 0 [Note] WSREP: EVS version upgrade 0 -> 1
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:44:52 0 [Note] WSREP: PC protocol upgrade 0 -> 1
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:44:52 0 [Note] WSREP: No nodes coming from primary view, primary view is not possible
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:44:52 0 [Note] WSREP: view(view_id(NON_PRIM,2f209250-816a,1) memb {
app_db.0.uverkfw2on8j@db2    |  2f209250-816a,0
app_db.0.uverkfw2on8j@db2    | } joined {
app_db.0.uverkfw2on8j@db2    | } left {
app_db.0.uverkfw2on8j@db2    | } partitioned {
app_db.0.uverkfw2on8j@db2    | })
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:44:53 0 [Warning] WSREP: last inactive check more than PT1.5S ago (PT1.50054S), skipping check
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:45:24 0 [Note] WSREP: PC protocol downgrade 1 -> 0
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:45:24 0 [Note] WSREP: view((empty))
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:45:24 0 [ERROR] WSREP: failed to open gcomm backend connection: 110: failed to reach primary view
app_db.0.uverkfw2on8j@db2    |   at ./gcomm/src/pc.cpp:connect():161
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:45:24 0 [ERROR] WSREP: ./gcs/src/gcs_core.cpp:gcs_core_open():259: Failed to open backend connection: -110 (Connection timed out)
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:45:24 0 [Note] WSREP: gcomm: terminating thread
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:45:24 0 [Note] WSREP: gcomm: joining thread
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:45:24 0 [Note] WSREP: gcomm: closing backend
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:45:24 0 [Note] WSREP: gcomm: closed
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:45:24 0 [ERROR] WSREP: ./gcs/src/gcs.cpp:gcs_open():1742: Failed to open channel 'galera_cluster' at 'gcomm://app_db': -110 (Connection timed out)
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:45:24 0 [ERROR] WSREP: gcs connect failed: Operation timed out
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:45:24 0 [ERROR] WSREP: wsrep::connect(gcomm://app_db) failed: 7
app_db.0.uverkfw2on8j@db2    | 2026-06-06 19:45:24 0 [ERROR] Aborting
app_db.0.ec8t0a08pn33@db2    | [galera] 19:45:35 Node identity → name=db2  overlay_addr=172.28.3.152
app_db.0.ec8t0a08pn33@db2    | [galera] 19:45:35 Evaluating cluster state...
app_db.0.ec8t0a08pn33@db2    | [galera] 19:45:35 Found existing datadir with grastate.dat
app_db.0.ec8t0a08pn33@db2    | [galera] 19:45:35 safe_to_bootstrap=0 → joining existing cluster (IST/SST will sync state)
app_db.0.ec8t0a08pn33@db2    | [galera] 19:45:35 Writing runtime config → /etc/mysql/mariadb.conf.d/61-galera-runtime.cnf
app_db.0.ec8t0a08pn33@db2    | [galera] 19:45:35 Mode: JOIN       → mariadbd (normal start)
app_db.0.ec8t0a08pn33@db2    | [galera] 19:45:35 Handing off to docker-entrypoint.sh...
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:45:35+00:00 [Note] [Entrypoint]: Entrypoint script for MariaDB Server 1:10.11.18+maria~ubu2204 started.
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:45:35+00:00 [Warn] [Entrypoint]: /sys/fs/cgroup///memory.pressure not writable, functionality unavailable to MariaDB
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:45:35+00:00 [Note] [Entrypoint]: Switching to dedicated user 'mysql'
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:45:35+00:00 [Note] [Entrypoint]: Entrypoint script for MariaDB Server 1:10.11.18+maria~ubu2204 started.
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:45:36+00:00 [Note] [Entrypoint]: MariaDB upgrade not required
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:45:36 0 [Note] Starting MariaDB 10.11.18-MariaDB-ubu2204 source revision 197f92bee02d8e836f529f37625be69b83e7acbd server_uid g4Xrol9j+pmMbFLKyNHKWs/6PyY= as process 1
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:45:36 0 [Note] WSREP: Loading provider /usr/lib/galera/libgalera_smm.so initial position: 00000000-0000-0000-0000-000000000000:-1
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:45:36 0 [Note] WSREP: wsrep_load(): loading provider library '/usr/lib/galera/libgalera_smm.so'
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:45:36 0 [Note] WSREP: wsrep_load(): Galera 26.4.27(rf032a460) by Codership Oy <info@codership.com> loaded successfully.
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:45:36 0 [Note] WSREP: Initializing allowlist service v1
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:45:36 0 [Note] WSREP: Resolved symbol 'wsrep_node_isolation_mode_set_v1'
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:45:36 0 [Note] WSREP: Resolved symbol 'wsrep_certify_v1'
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:45:36 0 [Note] WSREP: CRC-32C: using 64-bit x86 acceleration.
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:45:36 0 [Note] WSREP: Found saved state: 00000000-0000-0000-0000-000000000000:-1, safe_to_bootstrap: 1
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:45:36 0 [Note] WSREP: GCache DEBUG: opened preamble:
app_db.0.ec8t0a08pn33@db2    | Version: 2
app_db.0.ec8t0a08pn33@db2    | UUID: 00000000-0000-0000-0000-000000000000
app_db.0.ec8t0a08pn33@db2    | Seqno: -1 - -1
app_db.0.ec8t0a08pn33@db2    | Offset: -1
app_db.0.ec8t0a08pn33@db2    | Synced: 1
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:45:36 0 [Note] WSREP: Skipped GCache ring buffer recovery: could not determine history UUID.
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:45:36 0 [Note] WSREP: Passing config to GCS: base_dir = /var/lib/mysql/; base_host = 172.28.3.152; base_port = 4567; cert.log_conflicts = no; cert.optimistic_pa = yes; debug = no; evs.auto_evict = 0; evs.causal_keepalive_period = PT1S; evs.debug_log_mask = 0x1; evs.delay_margin = PT1S; evs.delayed_keep_period = PT30S; evs.inactive_check_period = PT0.5S; evs.inactive_timeout = PT1M; evs.info_log_mask = 0; evs.install_timeout = PT1M; evs.join_retrans_period = PT1S; evs.keepalive_period = PT3S; evs.max_install_timeouts = 3; evs.send_window = 4; evs.stats_report_period = PT1M; evs.suspect_timeout = PT30S; evs.use_aggregate = true; evs.user_send_window = 2; evs.version = 1; evs.view_forget_timeout = PT24H; gcache.dir = /var/lib/mysql/; gcache.keep_pages_size = 0; gcache.keep_plaintext_size = 128M; gcache.mem_size = 0; gcache.name = galera.cache; gcache.page_size = 128M; gcache.recover = yes; gcache.size = 256M; gcomm.thread_prio = ; gcs.check_appl_proto = 1; gcs.fc_debug = 0; gcs.fc_factor = 1.0; gcs.fc_limit = 16; gcs.fc_maste
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:45:36 0 [Note] WSREP: Start replication
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:45:36 0 [Note] WSREP: Connecting with bootstrap option: 0
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:45:36 0 [Note] WSREP: Setting GCS initial position to 00000000-0000-0000-0000-000000000000:-1
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:45:36 0 [Note] WSREP: protonet asio version 0
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:45:36 0 [Note] WSREP: Using CRC-32C for message checksums.
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:45:36 0 [Note] WSREP: backend: asio
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:45:36 0 [Note] WSREP: gcomm thread scheduling priority set to other:0 
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:45:36 0 [Note] WSREP: access file(/var/lib/mysql//gvwstate.dat) failed(No such file or directory)
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:45:36 0 [Note] WSREP: restore pc from disk failed
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:45:36 0 [Note] WSREP: GMCast version 0
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:45:36 0 [Note] WSREP: (49a5eab4-893e, 'tcp://0.0.0.0:4567') listening at tcp://0.0.0.0:4567
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:45:36 0 [Note] WSREP: (49a5eab4-893e, 'tcp://0.0.0.0:4567') multicast: , ttl: 1
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:45:36 0 [Note] WSREP: EVS version 1
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:45:36 0 [Note] WSREP: gcomm: connecting to group 'galera_cluster', peer 'app_db:'
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:45:36 0 [Note] WSREP: (49a5eab4-893e, 'tcp://0.0.0.0:4567') Found matching local endpoint for a connection, blacklisting address tcp://172.28.3.152:4567
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:45:37 0 [Note] WSREP: EVS version upgrade 0 -> 1
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:45:37 0 [Note] WSREP: PC protocol upgrade 0 -> 1
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:45:37 0 [Note] WSREP: No nodes coming from primary view, primary view is not possible
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:45:37 0 [Note] WSREP: view(view_id(NON_PRIM,49a5eab4-893e,1) memb {
app_db.0.ec8t0a08pn33@db2    |  49a5eab4-893e,0
app_db.0.ec8t0a08pn33@db2    | } joined {
app_db.0.ec8t0a08pn33@db2    | } left {
app_db.0.ec8t0a08pn33@db2    | } partitioned {
app_db.0.ec8t0a08pn33@db2    | })
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:45:37 0 [Warning] WSREP: last inactive check more than PT1.5S ago (PT1.50069S), skipping check
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:46:09 0 [Note] WSREP: PC protocol downgrade 1 -> 0
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:46:09 0 [Note] WSREP: view((empty))
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:46:09 0 [ERROR] WSREP: failed to open gcomm backend connection: 110: failed to reach primary view
app_db.0.ec8t0a08pn33@db2    |   at ./gcomm/src/pc.cpp:connect():161
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:46:09 0 [ERROR] WSREP: ./gcs/src/gcs_core.cpp:gcs_core_open():259: Failed to open backend connection: -110 (Connection timed out)
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:46:09 0 [Note] WSREP: gcomm: terminating thread
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:46:09 0 [Note] WSREP: gcomm: joining thread
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:46:09 0 [Note] WSREP: gcomm: closing backend
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:46:09 0 [Note] WSREP: gcomm: closed
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:46:09 0 [ERROR] WSREP: ./gcs/src/gcs.cpp:gcs_open():1742: Failed to open channel 'galera_cluster' at 'gcomm://app_db': -110 (Connection timed out)
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:46:09 0 [ERROR] WSREP: gcs connect failed: Operation timed out
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:46:09 0 [ERROR] WSREP: wsrep::connect(gcomm://app_db) failed: 7
app_db.0.ec8t0a08pn33@db2    | 2026-06-06 19:46:09 0 [ERROR] Aborting
app_db.0.43ws199wyqip@db2    | [galera] 19:46:20 Node identity → name=db2  overlay_addr=172.28.3.156
app_db.0.43ws199wyqip@db2    | [galera] 19:46:20 Evaluating cluster state...
app_db.0.43ws199wyqip@db2    | [galera] 19:46:20 Found existing datadir with grastate.dat
app_db.0.43ws199wyqip@db2    | [galera] 19:46:20 safe_to_bootstrap=0 → joining existing cluster (IST/SST will sync state)
app_db.0.43ws199wyqip@db2    | [galera] 19:46:20 Writing runtime config → /etc/mysql/mariadb.conf.d/61-galera-runtime.cnf
app_db.0.43ws199wyqip@db2    | [galera] 19:46:20 Mode: JOIN       → mariadbd (normal start)
app_db.0.43ws199wyqip@db2    | [galera] 19:46:20 Handing off to docker-entrypoint.sh...
app_db.0.43ws199wyqip@db2    | 2026-06-06 19:46:20+00:00 [Note] [Entrypoint]: Entrypoint script for MariaDB Server 1:10.11.18+maria~ubu2204 started.
app_db.0.43ws199wyqip@db2    | 2026-06-06 19:46:20+00:00 [Warn] [Entrypoint]: /sys/fs/cgroup///memory.pressure not writable, functionality unavailable to MariaDB
app_db.0.43ws199wyqip@db2    | 2026-06-06 19:46:20+00:00 [Note] [Entrypoint]: Switching to dedicated user 'mysql'
app_db.0.43ws199wyqip@db2    | 2026-06-06 19:46:20+00:00 [Note] [Entrypoint]: Entrypoint script for MariaDB Server 1:10.11.18+maria~ubu2204 started.
app_db.0.43ws199wyqip@db2    | 2026-06-06 19:46:20+00:00 [Note] [Entrypoint]: MariaDB upgrade not required
app_db.0.43ws199wyqip@db2    | 2026-06-06 19:46:20 0 [Note] Starting MariaDB 10.11.18-MariaDB-ubu2204 source revision 197f92bee02d8e836f529f37625be69b83e7acbd server_uid sZbZYHo1znnJw1413iqif7F9rpc= as process 1
app_db.0.43ws199wyqip@db2    | 2026-06-06 19:46:20 0 [Note] WSREP: Loading provider /usr/lib/galera/libgalera_smm.so initial position: 00000000-0000-0000-0000-000000000000:-1
app_db.0.43ws199wyqip@db2    | 2026-06-06 19:46:20 0 [Note] WSREP: wsrep_load(): loading provider library '/usr/lib/galera/libgalera_smm.so'
app_db.0.43ws199wyqip@db2    | 2026-06-06 19:46:20 0 [Note] WSREP: wsrep_load(): Galera 26.4.27(rf032a460) by Codership Oy <info@codership.com> loaded successfully.
app_db.0.43ws199wyqip@db2    | 2026-06-06 19:46:20 0 [Note] WSREP: Initializing allowlist service v1
app_db.0.43ws199wyqip@db2    | 2026-06-06 19:46:20 0 [Note] WSREP: Resolved symbol 'wsrep_node_isolation_mode_set_v1'
app_db.0.43ws199wyqip@db2    | 2026-06-06 19:46:20 0 [Note] WSREP: Resolved symbol 'wsrep_certify_v1'
app_db.0.43ws199wyqip@db2    | 2026-06-06 19:46:20 0 [Note] WSREP: CRC-32C: using 64-bit x86 acceleration.
app_db.0.43ws199wyqip@db2    | 2026-06-06 19:46:20 0 [Note] WSREP: Found saved state: 00000000-0000-0000-0000-000000000000:-1, safe_to_bootstrap: 1
app_db.0.43ws199wyqip@db2    | 2026-06-06 19:46:20 0 [Note] WSREP: GCache DEBUG: opened preamble:
app_db.0.43ws199wyqip@db2    | Version: 2
app_db.0.43ws199wyqip@db2    | UUID: 00000000-0000-0000-0000-000000000000
app_db.0.43ws199wyqip@db2    | Seqno: -1 - -1
app_db.0.43ws199wyqip@db2    | Offset: -1
app_db.0.43ws199wyqip@db2    | Synced: 1
app_db.0.43ws199wyqip@db2    | 2026-06-06 19:46:20 0 [Note] WSREP: Skipped GCache ring buffer recovery: could not determine history UUID.
app_db.0.43ws199wyqip@db2    | 2026-06-06 19:46:20 0 [Note] WSREP: Passing config to GCS: base_dir = /var/lib/mysql/; base_host = 172.28.3.156; base_port = 4567; cert.log_conflicts = no; cert.optimistic_pa = yes; debug = no; evs.auto_evict = 0; evs.causal_keepalive_period = PT1S; evs.debug_log_mask = 0x1; evs.delay_margin = PT1S; evs.delayed_keep_period = PT30S; evs.inactive_check_period = PT0.5S; evs.inactive_timeout = PT1M; evs.info_log_mask = 0; evs.install_timeout = PT1M; evs.join_retrans_period = PT1S; evs.keepalive_period = PT3S; evs.max_install_timeouts = 3; evs.send_window = 4; evs.stats_report_period = PT1M; evs.suspect_timeout = PT30S; evs.use_aggregate = true; evs.user_send_window = 2; evs.version = 1; evs.view_forget_timeout = PT24H; gcache.dir = /var/lib/mysql/; gcache.keep_pages_size = 0; gcache.keep_plaintext_size = 128M; gcache.mem_size = 0; gcache.name = galera.cache; gcache.page_size = 128M; gcache.recover = yes; gcache.size = 256M; gcomm.thread_prio = ; gcs.check_appl_proto = 1; gcs.fc_debug = 0; gcs.fc_factor = 1.0; gcs.fc_limit = 16; gcs.fc_maste
app_db.0.43ws199wyqip@db2    | 2026-06-06 19:46:20 0 [Note] WSREP: Start replication
app_db.0.43ws199wyqip@db2    | 2026-06-06 19:46:20 0 [Note] WSREP: Connecting with bootstrap option: 0
app_db.0.43ws199wyqip@db2    | 2026-06-06 19:46:20 0 [Note] WSREP: Setting GCS initial position to 00000000-0000-0000-0000-000000000000:-1
app_db.0.43ws199wyqip@db2    | 2026-06-06 19:46:20 0 [Note] WSREP: protonet asio version 0
app_db.0.43ws199wyqip@db2    | 2026-06-06 19:46:20 0 [Note] WSREP: Using CRC-32C for message checksums.
app_db.0.43ws199wyqip@db2    | 2026-06-06 19:46:20 0 [Note] WSREP: backend: asio
app_db.0.43ws199wyqip@db2    | 2026-06-06 19:46:20 0 [Note] WSREP: gcomm thread scheduling priority set to other:0 
app_db.0.43ws199wyqip@db2    | 2026-06-06 19:46:20 0 [Note] WSREP: access file(/var/lib/mysql//gvwstate.dat) failed(No such file or directory)
app_db.0.43ws199wyqip@db2    | 2026-06-06 19:46:20 0 [Note] WSREP: restore pc from disk failed
app_db.0.43ws199wyqip@db2    | 2026-06-06 19:46:20 0 [Note] WSREP: GMCast version 0
app_db.0.43ws199wyqip@db2    | 2026-06-06 19:46:20 0 [Note] WSREP: (641e2d86-b94a, 'tcp://0.0.0.0:4567') listening at tcp://0.0.0.0:4567
app_db.0.43ws199wyqip@db2    | 2026-06-06 19:46:20 0 [Note] WSREP: (641e2d86-b94a, 'tcp://0.0.0.0:4567') multicast: , ttl: 1
app_db.0.43ws199wyqip@db2    | 2026-06-06 19:46:20 0 [Note] WSREP: EVS version 1
app_db.0.43ws199wyqip@db2    | 2026-06-06 19:46:20 0 [Note] WSREP: gcomm: connecting to group 'galera_cluster', peer 'app_db:'
app_db.0.43ws199wyqip@db2    | 2026-06-06 19:46:20 0 [Note] WSREP: (641e2d86-b94a, 'tcp://0.0.0.0:4567') Found matching local endpoint for a connection, blacklisting address tcp://172.28.3.156:4567
app_db.0.43ws199wyqip@db2    | 2026-06-06 19:46:21 0 [Note] WSREP: EVS version upgrade 0 -> 1
app_db.0.43ws199wyqip@db2    | 2026-06-06 19:46:21 0 [Note] WSREP: PC protocol upgrade 0 -> 1
app_db.0.43ws199wyqip@db2    | 2026-06-06 19:46:21 0 [Note] WSREP: No nodes coming from primary view, primary view is not possible
app_db.0.43ws199wyqip@db2    | 2026-06-06 19:46:21 0 [Note] WSREP: view(view_id(NON_PRIM,641e2d86-b94a,1) memb {
app_db.0.43ws199wyqip@db2    |  641e2d86-b94a,0
app_db.0.43ws199wyqip@db2    | } joined {
app_db.0.43ws199wyqip@db2    | } left {
app_db.0.43ws199wyqip@db2    | } partitioned {
app_db.0.43ws199wyqip@db2    | })
app_db.0.43ws199wyqip@db2    | 2026-06-06 19:46:22 0 [Warning] WSREP: last inactive check more than PT1.5S ago (PT1.50059S), skipping check
app_db.0.vzk2hefjr0fm@db3    | [galera] 19:46:32 Node identity → name=db3  overlay_addr=172.28.3.158
app_db.0.vzk2hefjr0fm@db3    | [galera] 19:46:32 Evaluating cluster state...
app_db.0.vzk2hefjr0fm@db3    | [galera] 19:46:32 Found existing datadir with grastate.dat
app_db.0.vzk2hefjr0fm@db3    | [galera] 19:46:32 safe_to_bootstrap=0 → joining existing cluster (IST/SST will sync state)
app_db.0.vzk2hefjr0fm@db3    | [galera] 19:46:32 Writing runtime config → /etc/mysql/mariadb.conf.d/61-galera-runtime.cnf
app_db.0.vzk2hefjr0fm@db3    | [galera] 19:46:32 Mode: JOIN       → mariadbd (normal start)
app_db.0.vzk2hefjr0fm@db3    | [galera] 19:46:32 Handing off to docker-entrypoint.sh...
app_db.0.vzk2hefjr0fm@db3    | 2026-06-06 19:46:32+00:00 [Note] [Entrypoint]: Entrypoint script for MariaDB Server 1:10.11.18+maria~ubu2204 started.
app_db.0.vzk2hefjr0fm@db3    | 2026-06-06 19:46:33+00:00 [Warn] [Entrypoint]: /sys/fs/cgroup///memory.pressure not writable, functionality unavailable to MariaDB
app_db.0.vzk2hefjr0fm@db3    | 2026-06-06 19:46:33+00:00 [Note] [Entrypoint]: Switching to dedicated user 'mysql'
app_db.0.vzk2hefjr0fm@db3    | 2026-06-06 19:46:33+00:00 [Note] [Entrypoint]: Entrypoint script for MariaDB Server 1:10.11.18+maria~ubu2204 started.
app_db.0.vzk2hefjr0fm@db3    | 2026-06-06 19:46:33+00:00 [Note] [Entrypoint]: MariaDB upgrade not required
app_db.0.vzk2hefjr0fm@db3    | 2026-06-06 19:46:33 0 [Note] Starting MariaDB 10.11.18-MariaDB-ubu2204 source revision 197f92bee02d8e836f529f37625be69b83e7acbd server_uid GKd2eipjZc16ChiDhG/QwMOZLus= as process 1
app_db.0.vzk2hefjr0fm@db3    | 2026-06-06 19:46:33 0 [Note] WSREP: Loading provider /usr/lib/galera/libgalera_smm.so initial position: 00000000-0000-0000-0000-000000000000:-1
app_db.0.vzk2hefjr0fm@db3    | 2026-06-06 19:46:33 0 [Note] WSREP: wsrep_load(): loading provider library '/usr/lib/galera/libgalera_smm.so'
app_db.0.vzk2hefjr0fm@db3    | 2026-06-06 19:46:33 0 [Note] WSREP: wsrep_load(): Galera 26.4.27(rf032a460) by Codership Oy <info@codership.com> loaded successfully.
app_db.0.vzk2hefjr0fm@db3    | 2026-06-06 19:46:33 0 [Note] WSREP: Initializing allowlist service v1
app_db.0.vzk2hefjr0fm@db3    | 2026-06-06 19:46:33 0 [Note] WSREP: Resolved symbol 'wsrep_node_isolation_mode_set_v1'
app_db.0.vzk2hefjr0fm@db3    | 2026-06-06 19:46:33 0 [Note] WSREP: Resolved symbol 'wsrep_certify_v1'
app_db.0.vzk2hefjr0fm@db3    | 2026-06-06 19:46:33 0 [Note] WSREP: CRC-32C: using 64-bit x86 acceleration.
app_db.0.vzk2hefjr0fm@db3    | 2026-06-06 19:46:33 0 [Note] WSREP: Found saved state: 00000000-0000-0000-0000-000000000000:-1, safe_to_bootstrap: 1
app_db.0.vzk2hefjr0fm@db3    | 2026-06-06 19:46:33 0 [Note] WSREP: GCache DEBUG: opened preamble:
app_db.0.vzk2hefjr0fm@db3    | Version: 2
app_db.0.vzk2hefjr0fm@db3    | UUID: 00000000-0000-0000-0000-000000000000
app_db.0.vzk2hefjr0fm@db3    | Seqno: -1 - -1
app_db.0.vzk2hefjr0fm@db3    | Offset: -1
app_db.0.vzk2hefjr0fm@db3    | Synced: 1
app_db.0.vzk2hefjr0fm@db3    | 2026-06-06 19:46:33 0 [Note] WSREP: Skipped GCache ring buffer recovery: could not determine history UUID.
app_db.0.vzk2hefjr0fm@db3    | 2026-06-06 19:46:33 0 [Note] WSREP: Passing config to GCS: base_dir = /var/lib/mysql/; base_host = 172.28.3.158; base_port = 4567; cert.log_conflicts = no; cert.optimistic_pa = yes; debug = no; evs.auto_evict = 0; evs.causal_keepalive_period = PT1S; evs.debug_log_mask = 0x1; evs.delay_margin = PT1S; evs.delayed_keep_period = PT30S; evs.inactive_check_period = PT0.5S; evs.inactive_timeout = PT1M; evs.info_log_mask = 0; evs.install_timeout = PT1M; evs.join_retrans_period = PT1S; evs.keepalive_period = PT3S; evs.max_install_timeouts = 3; evs.send_window = 4; evs.stats_report_period = PT1M; evs.suspect_timeout = PT30S; evs.use_aggregate = true; evs.user_send_window = 2; evs.version = 1; evs.view_forget_timeout = PT24H; gcache.dir = /var/lib/mysql/; gcache.keep_pages_size = 0; gcache.keep_plaintext_size = 128M; gcache.mem_size = 0; gcache.name = galera.cache; gcache.page_size = 128M; gcache.recover = yes; gcache.size = 256M; gcomm.thread_prio = ; gcs.check_appl_proto = 1; gcs.fc_debug = 0; gcs.fc_factor = 1.0; gcs.fc_limit = 16; gcs.fc_maste
app_db.0.vzk2hefjr0fm@db3    | 2026-06-06 19:46:33 0 [Note] WSREP: Start replication
app_db.0.vzk2hefjr0fm@db3    | 2026-06-06 19:46:33 0 [Note] WSREP: Connecting with bootstrap option: 0
app_db.0.vzk2hefjr0fm@db3    | 2026-06-06 19:46:33 0 [Note] WSREP: Setting GCS initial position to 00000000-0000-0000-0000-000000000000:-1
app_db.0.vzk2hefjr0fm@db3    | 2026-06-06 19:46:33 0 [Note] WSREP: protonet asio version 0
app_db.0.vzk2hefjr0fm@db3    | 2026-06-06 19:46:33 0 [Note] WSREP: Using CRC-32C for message checksums.
app_db.0.vzk2hefjr0fm@db3    | 2026-06-06 19:46:33 0 [Note] WSREP: backend: asio
app_db.0.vzk2hefjr0fm@db3    | 2026-06-06 19:46:33 0 [Note] WSREP: gcomm thread scheduling priority set to other:0 
app_db.0.vzk2hefjr0fm@db3    | 2026-06-06 19:46:33 0 [Note] WSREP: access file(/var/lib/mysql//gvwstate.dat) failed(No such file or directory)
app_db.0.vzk2hefjr0fm@db3    | 2026-06-06 19:46:33 0 [Note] WSREP: restore pc from disk failed
app_db.0.vzk2hefjr0fm@db3    | 2026-06-06 19:46:33 0 [Note] WSREP: GMCast version 0
app_db.0.vzk2hefjr0fm@db3    | 2026-06-06 19:46:33 0 [Note] WSREP: (6bcd341c-89fc, 'tcp://0.0.0.0:4567') listening at tcp://0.0.0.0:4567
app_db.0.vzk2hefjr0fm@db3    | 2026-06-06 19:46:33 0 [Note] WSREP: (6bcd341c-89fc, 'tcp://0.0.0.0:4567') multicast: , ttl: 1
app_db.0.vzk2hefjr0fm@db3    | 2026-06-06 19:46:33 0 [Note] WSREP: EVS version 1
app_db.0.vzk2hefjr0fm@db3    | 2026-06-06 19:46:33 0 [Note] WSREP: gcomm: connecting to group 'galera_cluster', peer 'app_db:'
app_db.0.vzk2hefjr0fm@db3    | 2026-06-06 19:46:33 0 [Note] WSREP: (6bcd341c-89fc, 'tcp://0.0.0.0:4567') Found matching local endpoint for a connection, blacklisting address tcp://172.28.3.158:4567
app_db.0.vzk2hefjr0fm@db3    | 2026-06-06 19:46:34 0 [Note] WSREP: EVS version upgrade 0 -> 1
app_db.0.vzk2hefjr0fm@db3    | 2026-06-06 19:46:34 0 [Note] WSREP: PC protocol upgrade 0 -> 1
app_db.0.vzk2hefjr0fm@db3    | 2026-06-06 19:46:34 0 [Note] WSREP: No nodes coming from primary view, primary view is not possible
app_db.0.vzk2hefjr0fm@db3    | 2026-06-06 19:46:34 0 [Note] WSREP: view(view_id(NON_PRIM,6bcd341c-89fc,1) memb {
app_db.0.vzk2hefjr0fm@db3    |  6bcd341c-89fc,0
app_db.0.vzk2hefjr0fm@db3    | } joined {
app_db.0.vzk2hefjr0fm@db3    | } left {
app_db.0.vzk2hefjr0fm@db3    | } partitioned {
app_db.0.vzk2hefjr0fm@db3    | })
app_db.0.vzk2hefjr0fm@db3    | 2026-06-06 19:46:34 0 [Warning] WSREP: last inactive check more than PT1.5S ago (PT1.5015S), skipping check

vagrant@db1:~$ docker exec -it app_db.yxcxjom455a5gwgjb04s38m2w.sob50sx1yosdfin5yd9hxuebh mysql -uroot -p -e "SHOW STATUS LIKE 'wsrep%';"
Enter password: 
+-------------------------------+------------------------------------------------------------------------------------------------------------------------------------------------+
| Variable_name                 | Value                                                                                                                                          |
+-------------------------------+------------------------------------------------------------------------------------------------------------------------------------------------+
| wsrep_local_state_uuid        | 1cf7d641-61d4-11f1-8385-0f1e65e391a5                                                                                                           |
| wsrep_protocol_version        | 11                                                                                                                                             |
| wsrep_protocol_application    | 4                                                                                                                                              |
| wsrep_protocol_replicator     | 11                                                                                                                                             |
| wsrep_protocol_gcs            | 6                                                                                                                                              |
| wsrep_last_committed          | 6                                                                                                                                              |
| wsrep_replicated              | 4                                                                                                                                              |
| wsrep_replicated_bytes        | 2032                                                                                                                                           |
| wsrep_repl_keys               | 16                                                                                                                                             |
| wsrep_repl_keys_bytes         | 224                                                                                                                                            |
| wsrep_repl_data_bytes         | 1543                                                                                                                                           |
| wsrep_repl_other_bytes        | 0                                                                                                                                              |
| wsrep_received                | 2                                                                                                                                              |
| wsrep_received_bytes          | 136                                                                                                                                            |
| wsrep_local_commits           | 4                                                                                                                                              |
| wsrep_local_cert_failures     | 0                                                                                                                                              |
| wsrep_local_replays           | 0                                                                                                                                              |
| wsrep_local_send_queue        | 0                                                                                                                                              |
| wsrep_local_send_queue_max    | 1                                                                                                                                              |
| wsrep_local_send_queue_min    | 0                                                                                                                                              |
| wsrep_local_send_queue_avg    | 0                                                                                                                                              |
| wsrep_local_recv_queue        | 0                                                                                                                                              |
| wsrep_local_recv_queue_max    | 1                                                                                                                                              |
| wsrep_local_recv_queue_min    | 0                                                                                                                                              |
| wsrep_local_recv_queue_avg    | 0                                                                                                                                              |
| wsrep_local_cached_downto     | 1                                                                                                                                              |
| wsrep_flow_control_paused_ns  | 0                                                                                                                                              |
| wsrep_flow_control_paused     | 0                                                                                                                                              |
| wsrep_flow_control_sent       | 0                                                                                                                                              |
| wsrep_flow_control_recv       | 0                                                                                                                                              |
| wsrep_flow_control_active     | false                                                                                                                                          |
| wsrep_flow_control_requested  | false                                                                                                                                          |
| wsrep_cert_deps_distance      | 1.5                                                                                                                                            |
| wsrep_apply_oooe              | 0                                                                                                                                              |
| wsrep_apply_oool              | 0                                                                                                                                              |
| wsrep_apply_window            | 1                                                                                                                                              |
| wsrep_apply_waits             | 0                                                                                                                                              |
| wsrep_commit_oooe             | 0                                                                                                                                              |
| wsrep_commit_oool             | 0                                                                                                                                              |
| wsrep_commit_window           | 1                                                                                                                                              |
| wsrep_local_state             | 4                                                                                                                                              |
| wsrep_local_state_comment     | Synced                                                                                                                                         |
| wsrep_cert_index_size         | 5                                                                                                                                              |
| wsrep_causal_reads            | 0                                                                                                                                              |
| wsrep_cert_interval           | 0                                                                                                                                              |
| wsrep_open_transactions       | 0                                                                                                                                              |
| wsrep_open_connections        | 0                                                                                                                                              |
| wsrep_incoming_addresses      | 172.28.3.35:0                                                                                                                                  |
| wsrep_cluster_weight          | 1                                                                                                                                              |
| wsrep_desync_count            | 0                                                                                                                                              |
| wsrep_evs_delayed             |                                                                                                                                                |
| wsrep_evs_evict_list          |                                                                                                                                                |
| wsrep_evs_repl_latency        | 0/0/0/0/0                                                                                                                                      |
| wsrep_evs_state               | OPERATIONAL                                                                                                                                    |
| wsrep_gcomm_uuid              | de890519-61d6-11f1-8ece-ae32cf7f5b53                                                                                                           |
| wsrep_gmcast_segment          | 0                                                                                                                                              |
| wsrep_checkpoint_position     | 1cf7d641-61d4-11f1-8385-0f1e65e391a5:6                                                                                                         |
| wsrep_se_checkpoint           | 1cf7d641-61d4-11f1-8385-0f1e65e391a5:6 0-1-4                                                                                                   |
| wsrep_applier_thread_count    | 2                                                                                                                                              |
| wsrep_cluster_capabilities    |                                                                                                                                                |
| wsrep_cluster_conf_id         | 1                                                                                                                                              |
| wsrep_cluster_size            | 1                                                                                                                                              |
| wsrep_cluster_state_uuid      | 1cf7d641-61d4-11f1-8385-0f1e65e391a5                                                                                                           |
| wsrep_cluster_status          | Primary                                                                                                                                        |
| wsrep_connected               | ON                                                                                                                                             |
| wsrep_local_bf_aborts         | 0                                                                                                                                              |
| wsrep_local_index             | 0                                                                                                                                              |
| wsrep_provider_capabilities   | :MULTI_MASTER:CERTIFICATION:PARALLEL_APPLYING:TRX_REPLAY:ISOLATION:PAUSE:CAUSAL_READS:INCREMENTAL_WRITESET:UNORDERED:PREORDERED:STREAMING:NBO: |
| wsrep_provider_name           | Galera                                                                                                                                         |
| wsrep_provider_vendor         | Codership Oy <info@codership.com>                                                                                                              |
| wsrep_provider_version        | 26.4.27(rf032a460)                                                                                                                             |
| wsrep_ready                   | ON                                                                                                                                             |
| wsrep_rollbacker_thread_count | 1                                                                                                                                              |
| wsrep_thread_count            | 3                                                                                                                                              |
+-------------------------------+------------------------------------------------------------------------------------------------------------------------------------------------+

vagrant@db2:~$ docker logs  app_db.98g8jhdfd5qjjfnxlg1ef7qck.zpht268g9r9r5dqwmoepzi327
[galera] 19:48:33 Node identity → name=db2  overlay_addr=172.28.3.168
[galera] 19:48:33 Evaluating cluster state...
[galera] 19:48:33 Found existing datadir with grastate.dat
[galera] 19:48:33 safe_to_bootstrap=0 → joining existing cluster (IST/SST will sync state)
[galera] 19:48:33 Writing runtime config → /etc/mysql/mariadb.conf.d/61-galera-runtime.cnf
[galera] 19:48:33 Mode: JOIN       → mariadbd (normal start)
[galera] 19:48:33 Handing off to docker-entrypoint.sh...
2026-06-06 19:48:33+00:00 [Note] [Entrypoint]: Entrypoint script for MariaDB Server 1:10.11.18+maria~ubu2204 started.
2026-06-06 19:48:33+00:00 [Warn] [Entrypoint]: /sys/fs/cgroup///memory.pressure not writable, functionality unavailable to MariaDB
2026-06-06 19:48:33+00:00 [Note] [Entrypoint]: Switching to dedicated user 'mysql'
2026-06-06 19:48:33+00:00 [Note] [Entrypoint]: Entrypoint script for MariaDB Server 1:10.11.18+maria~ubu2204 started.
2026-06-06 19:48:34+00:00 [Note] [Entrypoint]: MariaDB upgrade not required
2026-06-06 19:48:34 0 [Note] Starting MariaDB 10.11.18-MariaDB-ubu2204 source revision 197f92bee02d8e836f529f37625be69b83e7acbd server_uid PMPgAtH1tyXDakEsu/tyMJTj/8c= as process 1
2026-06-06 19:48:34 0 [Note] WSREP: Loading provider /usr/lib/galera/libgalera_smm.so initial position: 00000000-0000-0000-0000-000000000000:-1
2026-06-06 19:48:34 0 [Note] WSREP: wsrep_load(): loading provider library '/usr/lib/galera/libgalera_smm.so'
2026-06-06 19:48:34 0 [Note] WSREP: wsrep_load(): Galera 26.4.27(rf032a460) by Codership Oy <info@codership.com> loaded successfully.
2026-06-06 19:48:34 0 [Note] WSREP: Initializing allowlist service v1
2026-06-06 19:48:34 0 [Note] WSREP: Resolved symbol 'wsrep_node_isolation_mode_set_v1'
2026-06-06 19:48:34 0 [Note] WSREP: Resolved symbol 'wsrep_certify_v1'
2026-06-06 19:48:34 0 [Note] WSREP: CRC-32C: using 64-bit x86 acceleration.
2026-06-06 19:48:34 0 [Note] WSREP: Found saved state: 00000000-0000-0000-0000-000000000000:-1, safe_to_bootstrap: 1
2026-06-06 19:48:34 0 [Note] WSREP: GCache DEBUG: opened preamble:
Version: 2
UUID: 00000000-0000-0000-0000-000000000000
Seqno: -1 - -1
Offset: -1
Synced: 1
2026-06-06 19:48:34 0 [Note] WSREP: Skipped GCache ring buffer recovery: could not determine history UUID.
2026-06-06 19:48:34 0 [Note] WSREP: Passing config to GCS: base_dir = /var/lib/mysql/; base_host = 172.28.3.168; base_port = 4567; cert.log_conflicts = no; cert.optimistic_pa = yes; debug = no; evs.auto_evict = 0; evs.causal_keepalive_period = PT1S; evs.debug_log_mask = 0x1; evs.delay_margin = PT1S; evs.delayed_keep_period = PT30S; evs.inactive_check_period = PT0.5S; evs.inactive_timeout = PT1M; evs.info_log_mask = 0; evs.install_timeout = PT1M; evs.join_retrans_period = PT1S; evs.keepalive_period = PT3S; evs.max_install_timeouts = 3; evs.send_window = 4; evs.stats_report_period = PT1M; evs.suspect_timeout = PT30S; evs.use_aggregate = true; evs.user_send_window = 2; evs.version = 1; evs.view_forget_timeout = PT24H; gcache.dir = /var/lib/mysql/; gcache.keep_pages_size = 0; gcache.keep_plaintext_size = 128M; gcache.mem_size = 0; gcache.name = galera.cache; gcache.page_size = 128M; gcache.recover = yes; gcache.size = 256M; gcomm.thread_prio = ; gcs.check_appl_proto = 1; gcs.fc_debug = 0; gcs.fc_factor = 1.0; gcs.fc_limit = 16; gcs.fc_maste
2026-06-06 19:48:34 0 [Note] WSREP: Start replication
2026-06-06 19:48:34 0 [Note] WSREP: Connecting with bootstrap option: 0
2026-06-06 19:48:34 0 [Note] WSREP: Setting GCS initial position to 00000000-0000-0000-0000-000000000000:-1
2026-06-06 19:48:34 0 [Note] WSREP: protonet asio version 0
2026-06-06 19:48:34 0 [Note] WSREP: Using CRC-32C for message checksums.
2026-06-06 19:48:34 0 [Note] WSREP: backend: asio
2026-06-06 19:48:34 0 [Note] WSREP: gcomm thread scheduling priority set to other:0 
2026-06-06 19:48:34 0 [Note] WSREP: access file(/var/lib/mysql//gvwstate.dat) failed(No such file or directory)
2026-06-06 19:48:34 0 [Note] WSREP: restore pc from disk failed
2026-06-06 19:48:34 0 [Note] WSREP: GMCast version 0
2026-06-06 19:48:34 0 [Note] WSREP: (b3d54ab5-a9bf, 'tcp://0.0.0.0:4567') listening at tcp://0.0.0.0:4567
2026-06-06 19:48:34 0 [Note] WSREP: (b3d54ab5-a9bf, 'tcp://0.0.0.0:4567') multicast: , ttl: 1
2026-06-06 19:48:34 0 [Note] WSREP: EVS version 1
2026-06-06 19:48:34 0 [Note] WSREP: gcomm: connecting to group 'galera_cluster', peer 'app_db:'
2026-06-06 19:48:34 0 [Note] WSREP: (b3d54ab5-a9bf, 'tcp://0.0.0.0:4567') Found matching local endpoint for a connection, blacklisting address tcp://172.28.3.168:4567
2026-06-06 19:48:35 0 [Note] WSREP: EVS version upgrade 0 -> 1
2026-06-06 19:48:35 0 [Note] WSREP: PC protocol upgrade 0 -> 1
2026-06-06 19:48:35 0 [Note] WSREP: No nodes coming from primary view, primary view is not possible
2026-06-06 19:48:35 0 [Note] WSREP: view(view_id(NON_PRIM,b3d54ab5-a9bf,1) memb {
        b3d54ab5-a9bf,0
} joined {
} left {
} partitioned {
})
2026-06-06 19:48:35 0 [Warning] WSREP: last inactive check more than PT1.5S ago (PT1.5006S), skipping check
2026-06-06 19:49:07 0 [Note] WSREP: PC protocol downgrade 1 -> 0
2026-06-06 19:49:07 0 [Note] WSREP: view((empty))
2026-06-06 19:49:07 0 [ERROR] WSREP: failed to open gcomm backend connection: 110: failed to reach primary view
         at ./gcomm/src/pc.cpp:connect():161
2026-06-06 19:49:07 0 [ERROR] WSREP: ./gcs/src/gcs_core.cpp:gcs_core_open():259: Failed to open backend connection: -110 (Connection timed out)
2026-06-06 19:49:07 0 [Note] WSREP: gcomm: terminating thread
2026-06-06 19:49:07 0 [Note] WSREP: gcomm: joining thread
2026-06-06 19:49:07 0 [Note] WSREP: gcomm: closing backend
2026-06-06 19:49:07 0 [Note] WSREP: gcomm: closed
2026-06-06 19:49:07 0 [ERROR] WSREP: ./gcs/src/gcs.cpp:gcs_open():1742: Failed to open channel 'galera_cluster' at 'gcomm://app_db': -110 (Connection timed out)
2026-06-06 19:49:07 0 [ERROR] WSREP: gcs connect failed: Operation timed out
2026-06-06 19:49:07 0 [ERROR] WSREP: wsrep::connect(gcomm://app_db) failed: 7
2026-06-06 19:49:07 0 [ERROR] Aborting