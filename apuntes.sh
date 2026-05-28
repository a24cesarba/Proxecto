#/bin/bash
set -euo pipefail

VAGRANT_DIR="${VAGRANT_DIR:-$(pwd)}"

# 1. Vagrant
if ! command -v vagrant &>/dev/null; then
    echo "ERROR: Vagrant no está instalado."
    exit 1
fi
echo "Vagrant: OK"

# 2. VirtualBox
if ! command -v vboxmanage &>/dev/null && ! command -v VBoxManage &>/dev/null; then
    echo "ERROR: VirtualBox no está instalado."
    exit 1
fi
echo "VirtualBox: OK"

# 3. Plugin vagrant-vbguest
if ! vagrant plugin list 2>/dev/null | grep -q "vagrant-vbguest"; then
    echo "Plugin vagrant-vbguest no encontrado. Instalando..."
    vagrant plugin install vagrant-vbguest
fi
echo "Plugin vagrant-vbguest: OK"

# 4. Máquinas
if [[ ! -f "${VAGRANT_DIR}/Vagrantfile" ]]; then
    echo "ERROR: No se encontró Vagrantfile en ${VAGRANT_DIR}"
    exit 1
fi

cd "${VAGRANT_DIR}"

echo "Comprobando máquinas..."
vagrant status --machine-readable 2>/dev/null | awk -F',' '$3=="state" {print $2, $4}' | \
while read -r machine state; do
    if [[ "$state" = "running" ]]; then
        echo "Máquina '$machine': ya está corriendo"
    elif [[ "$state" = "saved" ]]; then
        vagrant resume "$machine"
    else 
        vagrant up "$machine"
    fi
done

vagrant ssh-config > ./ansible/ssh_config
cd ./ansible/

ansible-playbook instalar.yml
ansible-playbook gluster.yml
ansible-playbook swarm.yml
ansible-playbook iptables.yml
ansible-playbook docker-tls.yml
ansible-playbook desplegar.yml
ansible-playbook desplegar-monitoring.yml
