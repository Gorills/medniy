FROM php:7.3-fpm-bullseye

RUN apt-get update && apt-get install -y --no-install-recommends \
    cron \
    curl \
    git \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-configure gd \
        --with-freetype-dir=/usr/include/ \
        --with-jpeg-dir=/usr/include/ \
        --with-png-dir=/usr/include/ \
    && docker-php-ext-install -j"$(nproc)" \
    bcmath \
    exif \
    gd \
    opcache \
    pdo_mysql \
    mbstring \
    zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json ./
RUN composer install --no-dev --no-scripts --prefer-dist --no-interaction --no-autoloader

COPY . .
RUN composer dump-autoload -o --no-dev --no-scripts
COPY docker/patches/vendor/laravelrus/sleepingowl/src/Templates/Breadcrumbs.php \
    vendor/laravelrus/sleepingowl/src/Templates/Breadcrumbs.php
RUN php artisan package:discover --ansi || true

COPY docker/php/conf.d/custom.ini /usr/local/etc/php/conf.d/zz-custom.ini
COPY docker/php/entrypoint.sh /usr/local/bin/app-entrypoint
RUN chmod +x /usr/local/bin/app-entrypoint

ENTRYPOINT ["app-entrypoint"]
CMD ["php-fpm"]
