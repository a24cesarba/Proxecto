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