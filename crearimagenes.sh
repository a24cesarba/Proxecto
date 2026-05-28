#/bin/bash

docker build -t a24cesarba/app-web:latest ./ansible/web/
docker push a24cesarba/app-web:latest
docker build -t a24cesarba/galera-mariadb:10.11 ./ansible/galera/
docker push a24cesarba/galera-mariadb:10.11
docker build -t a24cesarba/swarm-autoscaler:1.0 ./ansible/autoescalador/
docker push a24cesarba/swarm-autoscaler:1.0
