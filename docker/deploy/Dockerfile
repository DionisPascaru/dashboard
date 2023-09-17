FROM richarvey/nginx-php-fpm:1.7.2

COPY . .

# Install Composer
ENV COMPOSER_VERSION 2.1.5

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=$COMPOSER_VERSION

# Install nodejs
RUN curl -fsSL https://deb.nodesource.com/setup_19.x | bash -  \
    && apt-get install -y nodejs \
    && npm install -g npm@9.7.2 \
    && node --version \
    && npm --version \

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
        nodejs \
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
    && rm -rf /var/lib/apt/lists/*;

COPY ./docker/php/laravel.ini /usr/local/etc/php/conf.d/laravel.ini

WORKDIR /usr/src/app

RUN chown -R www-data:www-data .

# Image config
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Laravel config
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

# Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER 1

CMD ["/start.sh"]
