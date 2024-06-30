FROM php:8.1-fpm

RUN apt-get update && apt-get -y install && \
    apt-get -y install build-essential \
        libpng-dev \
        libfreetype6-dev \
        locales \
        zip \
        libzip-dev \
        jpegoptim optipng pngquant gifsicle \
        vim \
        unzip \
        git \
        curl \
        openssl \
        bash \
        make \
        strace \
        openssh-server \
        sudo

RUN docker-php-ext-install bcmath pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/exchange-rate-service
