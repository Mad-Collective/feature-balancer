FROM splitbrain/phpfarm:latest

WORKDIR /app/feature-balancer
VOLUME ["/app/feature-balancer"]

RUN curl -sS https://getcomposer.org/installer | php-5.5 && mv /app/feature-balancer/composer.phar /usr/bin/composer