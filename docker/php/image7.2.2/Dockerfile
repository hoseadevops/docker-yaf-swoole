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

FROM php:7.2.2-fpm

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
        rsyslog \
        libmagickwand-dev \
        libmagickcore-dev

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

## General
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
        && docker-php-ext-install zip \
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

COPY ./yaf-3.0.8.tgz yaf-3.0.8.tgz
COPY ./swoole-4.3.6.tgz swoole-4.3.6.tgz
COPY ./redis-5.0.1.tgz redis-5.0.1.tgz
COPY ./memcached-3.1.3.tgz memcached-3.1.3.tgz
COPY ./imagick-3.4.4.tgz imagick-3.4.4.tgz

RUN mkdir -p /tmp/imagick \
&& tar -zxvf imagick-3.4.4.tgz -C /tmp/imagick --strip-components=1 \
&& rm imagick-3.4.4.tgz \
&& docker-php-ext-configure /tmp/imagick --enable-imagick \
&& docker-php-ext-install /tmp/imagick \
&& rm -r /tmp/imagick

RUN mkdir -p /tmp/yaf \
&& tar -zxvf yaf-3.0.8.tgz -C /tmp/yaf --strip-components=1 \
&& rm yaf-3.0.8.tgz \
&& docker-php-ext-configure /tmp/yaf --enable-yaf \
&& docker-php-ext-install /tmp/yaf \
&& rm -r /tmp/yaf

RUN mkdir -p /tmp/swoole \
&& tar -zxvf swoole-4.3.6.tgz -C /tmp/swoole --strip-components=1 \
&& rm swoole-4.3.6.tgz \
&& docker-php-ext-configure /tmp/swoole --enable-swoole \
&& docker-php-ext-install /tmp/swoole \
&& rm -r /tmp/swoole

RUN mkdir -p /tmp/redis \
&& tar -zxvf redis-5.0.1.tgz -C /tmp/redis --strip-components=1 \
&& rm redis-5.0.1.tgz \
&& docker-php-ext-configure /tmp/redis --enable-redis \
&& docker-php-ext-install /tmp/redis \
&& rm -r /tmp/redis

RUN mkdir -p /tmp/memcached \
&& tar -zxvf memcached-3.1.3.tgz -C /tmp/memcached --strip-components=1 \
&& rm memcached-3.1.3.tgz \
&& docker-php-ext-configure /tmp/memcached --enable-memcached \
&& docker-php-ext-install /tmp/memcached \
&& rm -r /tmp/memcached

COPY .bashrc /root/

RUN wget -O /tmp/phpunit.phar https://phar.phpunit.de/phpunit-7.phar && mv /tmp/phpunit.phar /usr/local/bin/phpunit && chmod a+x /usr/local/bin/phpunit

RUN rm -rf /var/lib/apt/lists/*
