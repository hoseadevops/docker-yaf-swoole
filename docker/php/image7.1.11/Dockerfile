#dockerfile 一般分成四部分：基础镜像信息、维护者信息、镜像操作指令、容器启动时执行的指令
# this dockerfile uses the php image
# version
# Author：
#第一行 必须指定基于的基础镜像

FROM php:7.1.11-fpm

RUN ln -sf /usr/share/zoneinfo/Asia/Shanghai /etc/localtime
ADD sources.list /etc/apt/sources.list
RUN apt-get update && apt-get install -y \
        vim \
        libmemcached-dev \
        libmcrypt-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng12-dev \
        cron \
        rsyslog \
        && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
        && docker-php-ext-install mysqli \
        && docker-php-ext-install pdo_mysql \
        && docker-php-ext-install zip \
        && docker-php-ext-install gd \
        && docker-php-ext-install mbstring \
        && docker-php-ext-install mcrypt \
        && docker-php-ext-install sockets \
        && docker-php-ext-install opcache

#RUN pecl -vvv install yaf-3.0.5 && pecl install swoole-1.9.22 && pecl -vvv install redis-3.1.4 && pecl install memcached-3.0.4

RUN curl -fsSL 'http://pecl.php.net/get/yaf-3.0.5.tgz' -o yaf-3.0.5.tgz \
    && mkdir -p /tmp/yaf \
    && tar -zxvf yaf-3.0.5.tgz -C /tmp/yaf --strip-components=1 \
    && rm yaf-3.0.5.tgz \
    && docker-php-ext-configure /tmp/yaf --enable-yaf \
    && docker-php-ext-install /tmp/yaf \
    && rm -r /tmp/yaf

RUN curl -fsSL 'http://pecl.php.net/get/swoole-1.9.23.tgz' -o swoole-1.9.23.tgz \
    && mkdir -p /tmp/swoole \
    && tar -zxvf swoole-1.9.23.tgz -C /tmp/swoole --strip-components=1 \
    && rm swoole-1.9.23.tgz \
    && docker-php-ext-configure /tmp/swoole --enable-swoole \
    && docker-php-ext-install /tmp/swoole \
    && rm -r /tmp/swoole

RUN curl -fsSL 'http://pecl.php.net/get/redis-3.1.4.tgz' -o redis-3.1.4.tgz \
    && mkdir -p /tmp/redis \
    && tar -zxvf redis-3.1.4.tgz -C /tmp/redis --strip-components=1 \
    && rm redis-3.1.4.tgz \
    && docker-php-ext-configure /tmp/redis --enable-redis \
    && docker-php-ext-install /tmp/redis \
    && rm -r /tmp/redis

RUN curl -fsSL 'http://pecl.php.net/get/memcached-3.0.4.tgz' -o memcached-3.0.4.tgz \
    && mkdir -p /tmp/memcached \
    && tar -zxvf memcached-3.0.4.tgz -C /tmp/memcached --strip-components=1 \
    && rm memcached-3.0.4.tgz \
    && docker-php-ext-configure /tmp/memcached --enable-memcached \
    && docker-php-ext-install /tmp/memcached \
    && rm -r /tmp/memcached

COPY .bashrc /root/

RUN curl -L https://phar.phpunit.de/phpunit-5.7.phar >> /tmp/phpunit.phar && mv /tmp/phpunit.phar /usr/local/bin/phpunit && chmod a+x /usr/local/bin/phpunit
