cd ansible/
ansible web1 -m copy -a "src=./ansible/docker-stack.yml dest=/opt/swarm-stack/docker-stack.yml mode=0644" --become
ansible web1 -m command -a "docker stack deploy -c /opt/swarm-stack/docker-stack.yml app" --become
ansible web1 -m copy -a "src=./ansible/imaxes/ dest=/mnt/almacenamiento_compartido mode=0755" --become