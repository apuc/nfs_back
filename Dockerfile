FROM php:8.1.19-fpm as base-image

ENV DEBIAN_FRONTEND noninteractive
ENV ACCEPT_EULA=Y
ENV SUDO_FORCE_REMOVE=yes
ENV LANGUAGE=ru_RU.UTF-8
ENV LANG=ru_RU.UTF-8
ENV LC_ALL=ru_RU.UTF-8
ENV COMPOSER_CACHE_DIR=/var/www/.cache
WORKDIR /var/www/NFS

RUN usermod -u 1000 www-data \
    && groupmod -g 1000 www-data \
    && addgroup nobody www-data \
    && chown -R www-data:www-data /var/www

##APT
RUN apt-get update -qq \
    && apt-get install -yqq --no-install-recommends \
        libc-client2007e-dev \
        libssl-dev \
        libkrb5-dev \
		libpq-dev \
		libzip-dev \
		libicu-dev \
		zip \
		unzip \
		gnupg2 \
        nginx \
        sudo \
        locales \
        git \
    && echo ru_RU.UTF-8 UTF-8 > /etc/locale.gen \
    && locale-gen ru_RU.UTF-8 \
    && dpkg-reconfigure locales \
    && rm -rf /var/lib/apt/lists/*

ADD ./docker/php/php.ini /usr/local/etc/php/php.ini

# PECL
RUN pecl install \
    && docker-php-ext-install \
		pdo_pgsql \
		pgsql \
		zip \
		intl

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ========================================  app-image  ========================================
FROM base-image as app-image

COPY --chown=www-data:www-data . /var/www/NFS
RUN sudo -u www-data mkdir -p var/cache var/log; \
    sudo -u www-data composer install --prefer-dist --no-cache --no-progress --optimize-autoloader --no-interaction; \
    sudo -u www-data composer dump-autoload --no-dev --classmap-authoritative; \
    sudo -u www-data php bin/console cache:clear --env=prod --no-debug; \
    touch .env;

# ========================================  web-image  ========================================
FROM app-image as web-image

COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
COPY docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker/nginx/nfs.conf /etc/nginx/sites-enabled/default
ENTRYPOINT ["/entrypoint.sh"]

# ========================================  local-image  ========================================
FROM web-image as local-image
RUN sudo -u www-data composer install --prefer-dist --no-progress --no-scripts --no-interaction
