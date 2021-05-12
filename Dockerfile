FROM php:7.3-fpm
COPY app/. /var/www/
EXPOSE 9000
