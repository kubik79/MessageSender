FROM php:8.3.4-fpm

ARG DEPLOY_ARG
ENV DEPLOY_ENV=$DEPLOY_ARG \
    HISTFILE=''
ARG OPCACHE_ENABLE
ARG XDEBUG_ENABLE
ARG LOCAL_USER
ARG WORKDIR

RUN ln -fs /usr/share/zoneinfo/Etc/UTC /etc/localtime

RUN apt-get update --fix-missing && apt-get install -y --no-install-recommends \
    bash \
    git \
    libonig-dev \
    libpq-dev \
    libicu-dev \
    && rm -rf /var/lib/apt/lists/*

ENV DEPLOY_ENV=$DEPLOY_ARG\
    PHP_OPCACHE_VALIDATE_TIMESTAMPS="0" \
    PHP_OPCACHE_MAX_ACCELERATED_FILES="1000000" \
    PHP_OPCACHE_MEMORY_CONSUMPTION="1024" \
    PHP_OPCACHE_MAX_WASTED_PERCENTAGE="10" \
    PHP_OPCACHE_ENABLE=$OPCACHE_ENABLE \
    PHP_OPCACHE_CLI_ENABLE=$OPCACHE_ENABLE \
    PHP_XDEBUG_ENABLE=$XDEBUG_ENABLE

RUN docker-php-ext-install opcache
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install pdo pdo_pgsql
RUN docker-php-ext-install pgsql
RUN docker-php-ext-install intl

RUN pecl channel-update pecl.php.net

RUN set -eux; \
    pecl install apcu; \
    docker-php-ext-enable apcu

RUN set -eux; \
    pecl install xdebug; \
    docker-php-ext-enable xdebug

COPY ./docker/php/pool.d/ /etc/php/8.3/fpm/pool.d/
COPY ./docker/php/conf.d/ /usr/local/etc/php/conf.d/

RUN set -eux; \
    chmod -R a+rX /usr/local/etc/php

COPY ./Api /var/www
WORKDIR /var/www
RUN chown -R www-data /var/www

USER www-data
RUN set -eux; \
    mkdir -p /var/www/var/log; \
    mkdir -p /var/www/var/cache; \
    touch /var/www/.env
