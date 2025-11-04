FROM php:8.3-fpm

# Install dockerize
ENV DOCKERIZE_VERSION 0.6.1
RUN curl -s -f -L -o /tmp/dockerize.tar.gz https://github.com/jwilder/dockerize/releases/download/v$DOCKERIZE_VERSION/dockerize-linux-amd64-v$DOCKERIZE_VERSION.tar.gz \
    && tar -C /usr/local/bin -xzvf /tmp/dockerize.tar.gz \
    && rm /tmp/dockerize.tar.gz

# Install Composer
ENV COMPOSER_VERSION 2.1.5
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Node.js and npm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest

# Install PHP extensions and required packages
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        libz-dev \
        libpq-dev \
        libjpeg-dev \
        libpng-dev \
        libssl-dev \
        libzip-dev \
        unzip \
        zip \
    && apt-get clean \
    && pecl install redis \
    && docker-php-ext-configure gd \
    && docker-php-ext-configure zip \
    && docker-php-ext-install \
        gd \
        exif \
        opcache \
        pdo_mysql \
        pdo_pgsql \
        pgsql \
        pcntl \
        zip \
    && docker-php-ext-enable redis \
    && rm -rf /var/lib/apt/lists/*

# PHP config
COPY ./docker/php/laravel.ini /usr/local/etc/php/conf.d/laravel.ini

# Copy app
COPY . /var/www/app

# Set ownership and permissions for Laravel
RUN chown -R www-data:www-data /var/www/app \
    && mkdir -p /var/www/app/storage /var/www/app/bootstrap/cache /var/www/app/public/resources/publicFiles \
    && chmod -R 775 /var/www/app/storage /var/www/app/bootstrap/cache /var/www/app/public/resources/publicFiles
