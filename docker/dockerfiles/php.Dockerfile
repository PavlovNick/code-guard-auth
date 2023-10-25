FROM php:8.1-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql

# Install composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin

WORKDIR /var/www/project
