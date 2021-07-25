FROM php:8.0-fpm

RUN apt-get update && \
 apt-get install --yes git libzip-dev zip && \
 apt-get clean && \
 docker-php-ext-install zip && yes no | pecl install xdebug apcu && docker-php-ext-enable xdebug zip

WORKDIR /app

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony
