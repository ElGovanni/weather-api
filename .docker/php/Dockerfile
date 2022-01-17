FROM php:8.0-alpine
ENV XDEBUG_MODE=coverage

RUN apk add --no-cache $PHPIZE_DEPS \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug
