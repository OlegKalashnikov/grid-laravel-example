FROM php:7.1-fpm-alpine

RUN apk update
RUN apk add curl
RUN apk add vim
RUN apk add wget
RUN apk add git
RUN apk add postgresql-dev

RUN docker-php-ext-install pdo pdo_pgsql pgsql

# Установка composer
ADD docker/php/composer-setup.sh /composer-setup.sh
RUN chmod +x /composer-setup.sh
RUN /composer-setup.sh
RUN rm /composer-setup.sh

RUN mv composer.phar /usr/local/bin/composer
RUN chmod +x /usr/local/bin/composer


WORKDIR /app
ADD . /app

RUN chmod -R 777 /app/storage
RUN chmod -R 777 /app/bootstrap
