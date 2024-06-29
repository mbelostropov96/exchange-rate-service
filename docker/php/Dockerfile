FROM php:8.1-fpm

WORKDIR /var/www/exchange-rate-service

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install bcmath pdo_mysql
