#!/bin/bash

if [ "${#*}" -lt 1 ]
then
  cat <<USAGE

This script is to PROVISIONING in a specific environment.

Usage:

  ${0} <environment_name>

USAGE
  exit 1
fi

set -e

source ~/.nfs/${1}

ENVIRONMENT=${1}
DEPLOY_USER=deployer
DEBIAN_FRONTEND=noninteractive

echo
echo =========================================================
echo "Set hostname to $ENVIRONMENT"
echo

hostname "$ENVIRONMENT"
echo "$ENVIRONMENT" | sudo tee /etc/hostname

echo ">>>>>> Hostname set to $DEPLOY_USER"

echo
echo =========================================================
echo "Install Docker"
echo
for pkg in docker.io docker-doc docker-compose docker-compose-v2 podman-docker containerd runc
do
  sudo apt-get remove -y $pkg > /dev/null
done

apt-get update > /dev/null
apt-get install -y ca-certificates curl gnupg > /dev/null
install -m 0755 -d /etc/apt/keyrings > /dev/null
rm -f /etc/apt/keyrings/docker.gpg > /dev/null
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | gpg --dearmor -o /etc/apt/keyrings/docker.gpg
chmod a+r /etc/apt/keyrings/docker.gpg

echo "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/ubuntu \
$(. /etc/os-release && echo "$VERSION_CODENAME") stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

apt-get update > /dev/null
apt-get -y install docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin > /dev/null

echo ">>>>>> Docker installed"

echo
echo =========================================================
echo "Create $DEPLOY_USER user"
echo

if [ $(grep -c "^$DEPLOY_USER:" /etc/passwd) -eq 0 ]
then
  useradd --create-home --home-dir "/home/$DEPLOY_USER" --groups docker --shell /bin/bash "$DEPLOY_USER"
  usermod -u 1100 "$DEPLOY_USER"
  groupmod -g 1100 "$DEPLOY_USER"
fi

echo
echo ">>>>>> $DEPLOY_USER user created"

echo
echo =========================================================
echo "Install and configure Let's Encrypt and get certificate"
echo

apt-get install -y certbot > /dev/null
certbot certonly -m "$ADMIN_EMAIL" --agree-tos --no-eff-email -d "$FDQN" --redirect --standalone

sed -i -E "s/^authenticator =.+$/authenticator = webroot/g" "/etc/letsencrypt/renewal/$FDQN.conf"

if [ $(cat /etc/letsencrypt/renewal/test.notessysadmin.com.conf | grep 'webroot_path' | wc -l) -eq 0 ]
then
  sed -i "/\[renewalparams\]/a webroot_path = /opt/nfs/nginx/.well-known" "/etc/letsencrypt/renewal/$FDQN.conf"
else
  sed -i -E "s/^webroot_path =.+$/webroot_path = /opt/nfs/nginx/.well-known/g" "/etc/letsencrypt/renewal/$FDQN.conf"
fi

sed -i -E "s/^ExecStart.+$/ExecStart=\/usr\/bin\/certbot -q renew --post-hook \/opt\/bin\/restart_frontend.sh/g" /lib/systemd/system/certbot.service
sed -i sed "s/certbot -q renew$/certbot -q renew --post-hook \/opt\/bin\/restart_frontend.sh/g" /etc/cron.d/certbot

mkdir /opt/bin -p
cat <<EOF > /opt/bin/restart_frontend.sh
#!/bin/bash

docker restart nfs-nginx

EOF

chmod +x /opt/bin/restart_frontend.sh

echo ">>>>>> Let's Encrypt installed"

echo
echo =========================================================
echo "Create work directoies"
echo

sudo -iu "$DEPLOY_USER" <<CMD

mkdir ~/.nfs/

CMD

sudo mkdir /opt/nfs/logs -p
sudo mkdir /opt/nfs/postgresql/data -p
sudo mkdir /opt/nfs/nginx/.well-known -p

echo ">>>>>> Work directoies created"

echo =========================================================
echo "Done. Reboot me"
