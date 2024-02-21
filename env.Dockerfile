ARG PHP_IMAGE
FROM ${PHP_IMAGE}

ENV DEBIAN_FRONTEND noninteractive
ENV ACCEPT_EULA=Y
ENV SUDO_FORCE_REMOVE=yes
ENV LANGUAGE=ru_RU.UTF-8
ENV LANG=ru_RU.UTF-8
ENV LC_ALL=ru_RU.UTF-8

##APT
RUN apt-get update -qq && \
    apt-get install -yqq --no-install-recommends \
      libc-client2007e-dev \
      libssl-dev \
      libkrb5-dev \
  		libpq-dev \
  		libzip-dev \
  		libicu-dev \
  		zip \
  		unzip \
  		gnupg2 \
      locales \
      git && \
    echo ru_RU.UTF-8 UTF-8 > /etc/locale.gen && \
    locale-gen ru_RU.UTF-8 && \
    dpkg-reconfigure locales && \
    rm -rf /var/lib/apt/lists/*

# PECL
RUN pecl install && \
    docker-php-ext-install \
  		pdo_pgsql \
  		pgsql \
  		zip \
  		intl

ARG COMPOSER_CACHE_DIR
ENV COMPOSER_CACHE_DIR=${COMPOSER_CACHE_DIR}
ARG WORKDIR
WORKDIR ${WORKDIR}

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ARG USER_ID
RUN usermod -u ${USER_ID} www-data \
    && groupmod -g ${USER_ID} www-data \
    && addgroup nobody www-data \
    && chown -R www-data:www-data /var/www
