cd ansible/
ansible web1 -m copy -a "src=./docker-stack.yml dest=/opt/swarm-stack/docker-stack.yml mode=0644" --become
ansible web1 -m command -a "docker stack deploy -c /opt/swarm-stack/docker-stack.yml app" --become