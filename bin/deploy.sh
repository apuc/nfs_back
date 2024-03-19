#!/bin/bash

if [ "${#*}" -lt 1 ]
then
  cat <<USAGE

This script is to DEPLOY in a specific environment.

Usage:

  ${0} <environment_name>

USAGE
  exit 1
fi

set -e
source ~/.nfs/${1}

ENVIRONMENT=${1}
USER_ID="1100"

git reset --hard
git pull

# Copy dist files
cp env.dist .env
cp env.test .env.test
cp phpstan.neon.dist phpstan.neon
cp phpunit.xml.dist phpunit.xml
cp .php-cs-fixer.dist.php .php-cs-fixer.php

# Replace environment variables
sed -i "s/POSTGRES_USER_HERE/${POSTGRES_USER}/g" .env .env.test env.docker-compose.yml
sed -i "s/POSTGRES_PASSWORD_HERE/${POSTGRES_PASSWORD}/g" .env .env.test env.docker-compose.yml
sed -i "s/POSTGRES_DB_NAME_HERE/${POSTGRES_DB_NAME}/g" .env .env.test env.docker-compose.yml
sed -i "s/FDQN_HERE/${FDQN}/g" docker/nginx/conf.d/nfs.conf

# Restart Staging environment
docker compose --file env.docker-compose.yml down
docker compose --file env.docker-compose.yml up -d

# Run composer install

if [ -d /tmp/vendor ]
then
  echo "Copy vendors data from backup"
  rsync -r /tmp/vendor .
else
  docker run --rm --name composer --user ${USER_ID}:${USER_ID} --workdir="/var/www/NFS" -v ./:/var/www/NFS mureevms/php-base:latest composer install --ignore-platform-reqs --prefer-dist --optimize-autoloader --no-scripts --no-interaction
fi

# Run migrations
docker exec --user ${USER_ID}:${USER_ID} nfs-fpm php bin/console d:m:m -n

rsync -r vendor /tmp/
