FROM php:8.1.4-fpm-alpine

WORKDIR /var/www

RUN apk update && apk add \
    build-base \
    vim \
    curl

RUN docker-php-ext-install pdo pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN addgroup -g 1000 -S www && \
    adduser -u 1000 -S www -G www

USER www

COPY --chown=www:www .  /var/www

EXPOSE 9000