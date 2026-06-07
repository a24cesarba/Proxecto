# Instruccións para comprobar o funcionamento de sistemas do cluster

## Autoscaler
Para elevar o consumo de cpu dos contenedores web por riba do límite 
necesario para o escalado utilizaremos o comando ab. Require instalar 
apache2-utils (sudo apt install apache2-utils). O seguinte comando 
será suficiente para provocar o salto de 3 a 4 contenedores. Debese 
substituir [ip_nodo_traefik] por unha das IPs recibidas ao final da 
execución de apuntes.sh

`ab -n 100000 -c 5 http://[ip_nodo_traefik]/testapp.php`

Para conseguir un maior número de réplicas pódese aumentar a cantidade 
de peticións simultáneas (argumento -c). Accedendo a un nodo mánager 
dende outra terminal pódese observar o número de réplicas actuais.

`vagrant ssh web1`

`watch docker service ls --filter name=app_web --format "{{.Replicas}}"`

Dende web1 pódese acceder á métrica de Prometheus para comprobar si se 
está superando o límite necesario para escalar neste instante:

`curl -sg 'http://localhost:9090/api/v1/query?query=avg(rate(container_cpu_usage_seconds_total{container_label_com_docker_swarm_service_name="app_web"}[2m]))' | python3 -m json.tool`

Debese manter por riba do 0.70 durante 2 minutos para provocar o escalado

## GlusterFS
Para comprobar o correcto funcionamento de GlusterFS pódese acceder 
á aplicación web con calquera usuario e subir unha imaxe. Despois, 
debese comprobar en web1, 2 e 3 a existencia desa imaxe en `/mnt/almacenamiento_compartido/imaxes/`

`vagrant ssh web1`

`vagrant ssh web2`

`vagrant ssh web3`

En cada un deles:

`ls /mnt/almacenamiento_compartido/imaxes/`

Buscar o nome de arquivo da imaxe subida

## Galera
Para comprobar o correcto funcionamento da replicación Galera pódese 
crear un usuario na app web. Despois, a través da liña de comandos, 
pódese comprobar a escritura na base de datos nos tres nodos:

`vagrant ssh db1`

`vagrant ssh db2`

`vagrant ssh db3`

En cada un deles:

`docker exec -it $(docker ps -q --filter name=app_db) mysql -uroot -p`

Debese introducir o contrasinal definido durante o despregue

Despois, en MariaDB:

`use app;`

`select * from usuarios;`

En cada un dos nodos debe aparecer o mesmo.