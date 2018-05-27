FROM php:7.0-apache

RUN docker-php-ext-install pdo pdo_mysql

RUN pear install Mail && \
    pear install Mail_Mime && \
    pear install pear/Net_SMTP
