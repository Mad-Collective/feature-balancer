FROM php:8.0-fpm-alpine

RUN apk add --no-cache \
        curl
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

WORKDIR /app/feature-balancer
