Vagrant.configure("2") do |config|
  config.vm.box = "generic/debian12"
  config.vbguest.auto_update = true

  config.vm.provision "shell", inline: <<-SHELL
    apt-get update
    apt-get install -y linux-headers-amd64 build-essential dkms

    id -u ansible &>/dev/null || useradd -m -s /bin/bash ansible

    echo "ansible ALL=(ALL) NOPASSWD:ALL" > /etc/sudoers.d/ansible
    chmod 440 /etc/sudoers.d/ansible
  SHELL

  # =========================================================
  # BALANCEADOR
  # =========================================================
  config.vm.define "balanceador" do |balanceador|
    balanceador.vm.hostname = "balanceador"

    # Red de gestión Swarm
    balanceador.vm.network "private_network",
      ip: "10.0.0.10",
      netmask: "255.255.255.0",
      virtualbox__intnet: "gestion-swarm"

    # Red frontend
    balanceador.vm.network "private_network",
      ip: "192.168.56.10"

    
    # Red web
    balanceador.vm.network "private_network",
      ip: "10.10.0.10",
      netmask: "255.255.255.0",
      virtualbox__intnet: "web-net"

    balanceador.vm.provider "virtualbox" do |vb|
      vb.name = "balanceador"
      vb.gui = false
      vb.memory = "2048"
      vb.cpus = 2
      vb.linked_clone = true

      vb.customize ["modifyvm", :id, "--nic3", "natnetwork"]
      vb.customize ["modifyvm", :id, "--nat-network2", "ProyectoNetwork"]

      vb.customize ["modifyvm", :id, "--groups", "/Aguacate3"]
    end

    balanceador.vm.post_up_message = "Buenas, soy el \"balanceador\""
  end

  # =========================================================
  # WEBS
  # =========================================================
  (1..3).each do |i|
    config.vm.define "web#{i}" do |web|
      web.vm.hostname = "web#{i}"

      # Red de gestión Swarm
      web.vm.network "private_network",
        ip: "10.0.0.2#{i}",
        netmask: "255.255.255.0",
      virtualbox__intnet: "gestion-swarm"

      # Red web
      web.vm.network "private_network",
        ip: "10.10.0.2#{i}",
        netmask: "255.255.255.0",
        virtualbox__intnet: "web-net"

      # Red backend
      web.vm.network "private_network",
        ip: "10.10.10.2#{i}",
        netmask: "255.255.255.0",
        virtualbox__intnet: "backend-net"

      web.vm.provider "virtualbox" do |vb|
        vb.name = "web#{i}"
        vb.gui = false
        vb.memory = "2048"
        vb.cpus = 1
        vb.linked_clone = true

        vb.customize ["modifyvm", :id, "--groups", "/Aguacate3"]
      end

      web.vm.post_up_message = "Buenas, soy el \"web#{i}\""
    end
  end

  # =========================================================
  # DATOS
  # =========================================================
  config.vm.define "datos" do |datos|
    datos.vm.hostname = "datos"

    # Red de gestión Swarm
    datos.vm.network "private_network",
      ip: "10.0.0.30",
      netmask: "255.255.255.0",
      virtualbox__intnet: "gestion-swarm"

    # Red backend
    datos.vm.network "private_network",
      ip: "10.10.10.30",
      netmask: "255.255.255.0",
      virtualbox__intnet: "backend-net"

    datos.vm.provider "virtualbox" do |vb|
      vb.name = "datos"
      vb.gui = false
      vb.memory = "2048"
      vb.cpus = 2
      vb.linked_clone = true

      vb.customize ["modifyvm", :id, "--groups", "/Aguacate3"]
    end

    datos.vm.post_up_message = "Buenas, soy el \"datos\""
  end
end
# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|
  config.ssh.insert_key = false
  config.vm.box = "generic/debian12"
  config.vbguest.auto_update = true

  # Aprovisionamiento común para las 8 máquinas
  config.vm.provision "shell", inline: <<-SHELL
    apt-get update
    apt-get install -y linux-headers-amd64 build-essential dkms
  SHELL

  # =========================================================
  # SERVIDORES WEB (3 Máquinas: Apache + Swarm Managers)
  # =========================================================
  (1..3).each do |i|
    config.vm.define "web#{i}" do |web|
      web.vm.hostname = "web#{i}"

      # Red de gestión Swarm (Aislada)
      web.vm.network "private_network",
        ip: "10.0.0.1#{i}",
        netmask: "255.255.255.0",
        virtualbox__intnet: "gestion-swarm"

      # Red Frontend
      web.vm.network "private_network", ip: "192.168.56.1#{i}"

      # Red Web-a-Proxy (Aislada): Para hablar con los HAProxy de la BD
      web.vm.network "private_network",
        ip: "10.10.0.1#{i}",
        netmask: "255.255.255.0",
        virtualbox__intnet: "web-net"

      web.vm.provider "virtualbox" do |vb|
        vb.name = "web#{i}"
        vb.gui = false
        vb.memory = "1024"
        vb.cpus = 1
        vb.linked_clone = true
        vb.customize ["modifyvm", :id, "--groups", "/Aguacate3"]
        vb.customize ["modifyvm", :id, "--nicpromisc2", "allow-all"] # Red Swarm en modo promiscuo
        vb.customize ["modifyvm", :id, "--nic3", "natnetwork"]
        vb.customize ["modifyvm", :id, "--nat-network2", "ProyectoNetwork"]
      end

      web.vm.post_up_message = "Buenas, soy el \"web#{i}\" (Web/Swarm Manager)"
    end
  end

  # =========================================================
  # BALANCEADORES BASE DE DATOS (2 Máquinas: HAProxy + Keepalived)
  # =========================================================
  (1..2).each do |i|
    config.vm.define "lb#{i}" do |lb|
      lb.vm.hostname = "lb#{i}"

      # Red de gestión Swarm
      lb.vm.network "private_network",
        ip: "10.0.0.2#{i}",
        netmask: "255.255.255.0",
        virtualbox__intnet: "gestion-swarm"

      # Red Web-a-Proxy: Escucha las peticiones SQL que manda Apache
      # (Aquí configuraremos la VIP de Keepalived en la IP 10.10.0.200)
      lb.vm.network "private_network",
        ip: "10.10.0.2#{i}",
        netmask: "255.255.255.0",
        virtualbox__intnet: "web-net"

      # Red Backend: Envía el tráfico redirigido hacia el clúster MariaDB
      lb.vm.network "private_network",
        ip: "10.10.10.2#{i}",
        netmask: "255.255.255.0",
        virtualbox__intnet: "backend-net"

      lb.vm.provider "virtualbox" do |vb|
        vb.name = "lb#{i}"
        vb.gui = false
        vb.memory = "512" # Ultra ligero para HAProxy
        vb.cpus = 1
        vb.linked_clone = true
        vb.customize ["modifyvm", :id, "--groups", "/Aguacate3"]
      end

      lb.vm.post_up_message = "Buenas, soy el \"lb#{i}\" (HAProxy/Keepalived)"
    end
  end

  # =========================================================
  # BASES DE DATOS (3 Máquinas: MariaDB Galera Cluster)
  # =========================================================
  (1..3).each do |i|
    config.vm.define "db#{i}" do |db|
      db.vm.hostname = "db#{i}"

      # Red de gestión Swarm
      db.vm.network "private_network",
        ip: "10.0.0.3#{i}",
        netmask: "255.255.255.0",
        virtualbox__intnet: "gestion-swarm"

      # Red Backend: Recibe consultas de HAProxy y ejecuta replicación interna Galera
      db.vm.network "private_network",
        ip: "10.10.10.3#{i}",
        netmask: "255.255.255.0",
        virtualbox__intnet: "backend-net"

      db.vm.provider "virtualbox" do |vb|
        vb.name = "db#{i}"
        vb.gui = false
        vb.memory = "2048" # 2 GB de RAM para que MariaDB respire bien
        vb.cpus = 1        # 1 vCPU para no saturar tu host
        vb.linked_clone = true
        vb.customize ["modifyvm", :id, "--groups", "/Aguacate3"]
      end

      db.vm.post_up_message = "Buenas, soy el \"db#{i}\" (MariaDB Galera Nodo)"
    end
  end
end