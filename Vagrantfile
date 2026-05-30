Vagrant.configure("2") do |config|
  config.vm.box = "generic/debian12"
  config.vbguest.auto_update = true

  config.vm.provision "shell", inline: <<-SHELL
    apt-get update
    apt-get install -y linux-headers-amd64 build-essential dkms
  SHELL

  # =========================================================
  # TRAEFIK (2 Máquinas: reverse proxy HTTP — Swarm Workers)
  # Reciben tráfico HTTP/HTTPS (192.168.56.2x).
  # Acceden a la Docker API del manager via TCP+mTLS (10.0.0.11:2376).
  # =========================================================
  (1..2).each do |i|
    config.vm.define "traefik#{i}" do |tr|
      tr.vm.hostname = "traefik#{i}"

      # Gestión Swarm + ruta a la Docker API del manager
      tr.vm.network "private_network",
        ip: "10.0.0.4#{i}",
        netmask: "255.255.255.0",
        virtualbox__intnet: "gestion-swarm"

      # Data-path Swarm (overlay encriptado)
      tr.vm.network "private_network",
        ip: "10.10.0.4#{i}",
        netmask: "255.255.255.0",
        virtualbox__intnet: "datos-swarm"

      # Frontend — puertos 80/443 accesibles desde el host
      tr.vm.network "private_network", ip: "192.168.56.2#{i}"

      tr.vm.provider "virtualbox" do |vb|
        vb.name = "traefik#{i}"
        vb.gui = false
        vb.memory = "512"
        vb.cpus = 1
        vb.linked_clone = true
        vb.customize ["modifyvm", :id, "--groups", "/Aguacate3"]
      end

      tr.vm.post_up_message = "Buenas, soy el \"traefik#{i}\" (Traefik edge proxy)"
    end
  end
  
  # =========================================================
  # SERVIDORES WEB (3 Máquinas: Apache + Swarm Managers)
  # =========================================================
  (1..3).each do |i|
    config.vm.define "web#{i}" do |web|
      web.vm.hostname = "web#{i}"

      web.vm.network "private_network",
        ip: "10.0.0.1#{i}",
        netmask: "255.255.255.0",
        virtualbox__intnet: "gestion-swarm"

      web.vm.network "private_network",
        ip: "10.10.0.1#{i}",
        netmask: "255.255.255.0",
        virtualbox__intnet: "datos-swarm"

      # Solo para admin/dashboard — el tráfico HTTP ya no entra aquí
      web.vm.network "private_network", ip: "192.168.56.1#{i}"

      web.vm.provider "virtualbox" do |vb|
        vb.name = "web#{i}"
        vb.gui = false
        vb.memory = "1024"
        vb.cpus = 1
        vb.linked_clone = true
        # vb.customize ["modifyvm", :id, "--nic4", "natnetwork"]
        # vb.customize ["modifyvm", :id, "--nat-network3", "ProyectoNetwork"]
      end

      web.vm.post_up_message = "Buenas, soy el \"web#{i}\" (Web/Swarm Manager)"
    end
  end

  # =========================================================
  # BALANCEADORES MySQL (2 Máquinas: HAProxy L4 para Galera)
  # =========================================================
  (1..2).each do |i|
    config.vm.define "lb#{i}" do |lb|
      lb.vm.hostname = "lb#{i}"

      lb.vm.network "private_network",
        ip: "10.0.0.2#{i}",
        netmask: "255.255.255.0",
        virtualbox__intnet: "gestion-swarm"

      lb.vm.network "private_network",
        ip: "10.10.0.2#{i}",
        netmask: "255.255.255.0",
        virtualbox__intnet: "datos-swarm"

      lb.vm.provider "virtualbox" do |vb|
        vb.name = "lb#{i}"
        vb.gui = false
        vb.memory = "512"
        vb.cpus = 1
        vb.linked_clone = true
        vb.customize ["modifyvm", :id, "--groups", "/Aguacate3"]
      end

      lb.vm.post_up_message = "Buenas, soy el \"lb#{i}\" (HAProxy MySQL)"
    end
  end

  # =========================================================
  # BASES DE DATOS (3 Máquinas: MariaDB Galera Cluster)
  # =========================================================
  (1..3).each do |i|
    config.vm.define "db#{i}" do |db|
      db.vm.hostname = "db#{i}"

      db.vm.network "private_network",
        ip: "10.0.0.3#{i}",
        netmask: "255.255.255.0",
        virtualbox__intnet: "gestion-swarm"

      db.vm.network "private_network",
        ip: "10.10.0.3#{i}",
        netmask: "255.255.255.0",
        virtualbox__intnet: "datos-swarm"
  
      db.vm.provider "virtualbox" do |vb|
        vb.name = "db#{i}"
        vb.gui = false
        vb.memory = "2048"
        vb.cpus = 1
        vb.linked_clone = true
        vb.customize ["modifyvm", :id, "--groups", "/Aguacate3"]
      end

      db.vm.post_up_message = "Buenas, soy el \"db#{i}\" (MariaDB Galera Nodo)"
    end
  end
end
