FROM php:7.4-fpm

WORKDIR /var/www

COPY . /var/www

RUN apt-get update && apt-get install -y \
    net-tools

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000"]

