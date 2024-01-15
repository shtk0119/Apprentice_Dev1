FROM php:8.3.1-apache

RUN apt-get update && \
    docker-php-ext-install pdo_mysql mysqli

RUN pecl install xdebug && \
    docker-php-ext-enable xdebug
    
WORKDIR /var/www/html