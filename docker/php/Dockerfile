FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    openssl zip unzip git curl \
    libzip-dev libonig-dev libicu-dev \
    autoconf pkg-config libssl-dev \
    libxml2-dev libpng-dev \
    libpq-dev  # Missing PostgreSQL dev library

RUN docker-php-ext-install dom gd
RUN docker-php-ext-install bcmath mbstring intl opcache zip
RUN docker-php-ext-install pdo pdo_pgsql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get clean && rm -rf /var/lib/apt/lists/*
