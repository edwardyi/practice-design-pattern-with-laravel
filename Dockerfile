FROM php:7.3-fpm

ARG user
ARG uid

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev

RUN apt-get clean && rm -rf /var/lib/apt/lists/*
RUN apt-get update
RUN apt-get install -y default-mysql-client

RUN pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis \
    && pecl install xdebug-3.1.2 \
    && docker-php-ext-enable xdebug 


# @see https://github.com/beyondcode/laravel-er-diagram-generator/issues/13
RUN apt-get install -y graphviz

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd xml iconv simplexml zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY . .

RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

USER $user
