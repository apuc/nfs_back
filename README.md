# NFS

## Technical requirements

- php-fpm v8.1.19
- PostgresSQL v14.8
- Docker

## Local environment

### With Docker

Локально окружение разворачивается в Docker. Для сборки клонировать проект, в корне запустить `make setup`, дождаться сборки. В браузере ввести http://localhost:82

###  Without Docker

1. Клонировать проект
1. Дать права на исполнение файлов в папке `bin/*`
1. Скопировать `.env.dist` в `.env`
1. Выполнить в корне `composer install --prefer-dist --optimize-autoloader --no-scripts --no-interaction`
1. Выполнить в корне `php bin/console cache:clear --no-debug`
1. Выполнить в корне (для создания БД) `php bin/console doctrine:database:create --if-not-exists -n`
1. Выполнить в корне (для выполнения миграций) `php bin/console d:m:m -n`

## Preparation of the environment. Install dependencies on server

Сделать требуется один раз при установке сервера

**FDQN должен существовать и резолвиться** до запуска скрипта, иначе SSL сертификат не будет выпущен.


1. Зайти под рутом
1. Объявить переменные
  `FDQN` - FDQN или доменное имя по которому должно быть доступно окружение \
  `ADMIN_EMAIL` - мыло на которое будут приходить письма о скором истечении сертификата, если он по каким-то причинам автоматически не продлится
1. Разместить проект на сервере и запустить `bin/provisioning.sh` скрипт

Пример:

```
sudo su
export FDQN=admin.nfsmir.ru
export ADMIN_EMAIL=mail@gmail.com
chmod +x bin/provisioning.sh
bin/provisioning.sh staging

exit
```

### Create SWAP (optional)

Если на сервере нет SWAP раздела, надо его создать через файл. Выполнить один раз:

```
sudo fallocate -l 500M /swapfile
sudo chmod 600 /swapfile
sudo mkswap /swapfile
sudo swapon /swapfile
echo "/swapfile none swap sw 0 0" | sudo tee -a /etc/fstab
```

## Deployment

### Build base docker image

Имадж билдится один раз и каждый раз при изменении кода пересобирать его не требуется, поскольку он пушится на Docker Hub и при запуске на сервере пулится оттуда.

На данный момент используется мой аккаунт (IMAGE_PATH="mureevms"), можно продолжать его использовать, но в этом случае билдить имадж придется мне, при необходимости его изменения. А можно залить имадж в свой аккаунт или свой Docker Registry, тогда билдить может любой у кого есть доступ к этому аккаунте или регистри.

Билд базового имаджа:

```
source env.base.docker

docker buildx build --platform linux/amd64 \
  --label PHP_VERSION="$PHP_VERSION" \
  --label NAME="$IMAGE_NAME" \
  --tag "$IMAGE_PATH"/"$IMAGE_NAME":"$PHP_VERSION" \
  --tag "$IMAGE_PATH"/"$IMAGE_NAME":latest \
  --build-arg PHP_IMAGE="$PHP_IMAGE" \
  --build-arg WORKDIR="$WORKDIR" \
  --build-arg COMPOSER_CACHE_DIR="$COMPOSER_CACHE_DIR" \
  --build-arg USER_ID="$USER_ID" \
  -f env.Dockerfile . \
  --push
```

Для ARM архитектуры (macOS M series, например) изменить параметр на `--platform linux/arm64` или чтобы сбилдить сразу для двух архитектур - `--platform linux/arm64,linux/amd64`

Если убрать ключ `--push`, то имадж просто соберется локально без пуша в регистри, указанного в параметре `--tag`

### Deploy environment

Один раз перед первым деплоем надо заполнить файл с переменными и секретами для `deployer` пользователя `~/.nfs/<environment_name>` с таким содержимым:

```
FDQN=<FDQN>
POSTGRES_USER=<POSTGRES_USER>
POSTGRES_PASSWORD=<POSTGRES_PASSWORD>
POSTGRES_DB_NAME=<POSTGRES_DB_NAME>
```

Например файл `~/.nfs/staging`:

```
FDQN=admin.nfsmir.ru
POSTGRES_USER=nfs_staging
POSTGRES_PASSWORD=S0pT4RavrJZXK04sdnJP
POSTGRES_DB_NAME=nfs_staging
```

Запустить на сервере скрипт деплоя из каталога проекта от нужного пользователя:

```
cd ~/<repo>
bin/deploy.sh <environment_name>
```

Например:

```
sudo -iu deployer
cd ~/nfs_back
bin/deploy.sh staging
```
