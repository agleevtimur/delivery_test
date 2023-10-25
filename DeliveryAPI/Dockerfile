FROM php:7.4-cli

WORKDIR /var/app

COPY . /var/app

RUN apt-get update && apt-get install -y \
    curl \
    git

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install

EXPOSE 8001

CMD ["php", "-S", "0.0.0.0:8001"]