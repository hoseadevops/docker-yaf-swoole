#dockerfile 一般分成四部分：基础镜像信息、维护者信息、镜像操作指令、容器启动时执行的指令
# this dockerfile uses the php image
# version
# Author：
#第一行 必须指定基于的基础镜像

# Extensions: ctype, dom, fileinfo, ftp, hash, iconv, json, pdo, pdo_sqlite, session,
# tokenizer, simplexml, xml, xmlreader, xmlwriter and phar are bundled and compiled into
# PHP by default. If missing, install them directly by `docker-php-ext-install extension_name`

# Notice:
# 1. Mcrypt was DEPRECATED in PHP 7.1.0, and REMOVED in PHP 7.2.0.
# 2. opcache requires PHP version >= 7.0.0.
# 3. soap requires libxml2-dev.
# 4. xml, xmlrpc, wddx require libxml2-dev and libxslt-dev.
# 5. Line `&& :\` is just for better reading and do nothing.

FROM php:7.3.3-fpm

RUN ln -sf /usr/share/zoneinfo/Asia/Shanghai /etc/localtime
ADD sources.list /etc/apt/sources.list

## Update Ubuntu
RUN apt-get update

## Tool
RUN apt-get install -y \
        wget \
        vim \
        libmemcached-dev \
        cron \
        rsyslog

## GD
RUN apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev \
        && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
        && docker-php-ext-install gd

## soap xsl wddx
RUN apt-get install -y libxml2-dev \
        && apt-get install -y libxslt-dev \
        && docker-php-ext-install soap \
        && docker-php-ext-install xsl \
        && docker-php-ext-install wddx
## zip
RUN apt-get install -y zip libzip-dev \
  && docker-php-ext-configure zip --with-libzip \
  && docker-php-ext-install zip

## General
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
        && docker-php-ext-install pcntl \
        && docker-php-ext-install mysqli \
        && docker-php-ext-install pdo_mysql \
        && docker-php-ext-install mbstring \
        && docker-php-ext-install exif \
        && docker-php-ext-install bcmath \
        && docker-php-ext-install calendar \
        && docker-php-ext-install sockets \
        && docker-php-ext-install gettext \
        && docker-php-ext-install shmop \
        && docker-php-ext-install sysvmsg \
        && docker-php-ext-install sysvsem \
        && docker-php-ext-install sysvshm \
        && docker-php-ext-install opcache

#RUN pear config-set http_proxy http://127.0.0.1:1087
#RUN pecl install swoole-4.3.0 && pecl -vvv install redis-4.2.0 && pecl install memcached-3.1.3

RUN curl -fsSL 'http://pecl.php.net/get/swoole-4.3.0.tgz' -o swoole-4.3.0.tgz \
    && mkdir -p /tmp/swoole \
    && tar -zxvf swoole-4.3.0.tgz -C /tmp/swoole --strip-components=1 \
    && rm swoole-4.3.0.tgz \
    && docker-php-ext-configure /tmp/swoole --enable-swoole \
    && docker-php-ext-install /tmp/swoole \
    && rm -r /tmp/swoole

RUN curl -fsSL 'http://pecl.php.net/get/redis-4.2.0.tgz' -o redis-4.2.0.tgz \
    && mkdir -p /tmp/redis \
    && tar -zxvf redis-4.2.0.tgz -C /tmp/redis --strip-components=1 \
    && rm redis-4.2.0.tgz \
    && docker-php-ext-configure /tmp/redis --enable-redis \
    && docker-php-ext-install /tmp/redis \
    && rm -r /tmp/redis

RUN curl -fsSL 'http://pecl.php.net/get/memcached-3.1.3.tgz' -o memcached-3.1.3.tgz \
    && mkdir -p /tmp/memcached \
    && tar -zxvf memcached-3.1.3.tgz -C /tmp/memcached --strip-components=1 \
    && rm memcached-3.1.3.tgz \
    && docker-php-ext-configure /tmp/memcached --enable-memcached \
    && docker-php-ext-install /tmp/memcached \
    && rm -r /tmp/memcached

COPY .bashrc /root/

RUN wget -O /tmp/phpunit.phar https://phar.phpunit.de/phpunit-8.0.4.phar && mv /tmp/phpunit.phar /usr/local/bin/phpunit && chmod a+x /usr/local/bin/phpunit

COPY ../composer/1.8.4/composer.phar composer.phar
RUN mv composer.phar /usr/bin/composer \
    && composer config -g repo.packagist composer https://packagist.phpcomposer.com

RUN rm -rf /var/lib/apt/lists/*
