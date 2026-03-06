# ---------- Build stage: install Composer deps with PHP 8.3 + required extensions ----------
FROM php:8.3-cli-bookworm AS vendor

WORKDIR /app

# System deps for intl + zip
RUN apt-get update && apt-get install -y --no-install-recommends \
    git unzip ca-certificates \
    libicu-dev zlib1g-dev libzip-dev \
 && rm -rf /var/lib/apt/lists/*

# PHP extensions needed during composer install
RUN docker-php-ext-install -j$(nproc) intl zip

# Install Composer (from official image)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy composer files and install deps
COPY composer.json composer.lock ./

# IMPORTANT: --no-scripts (so it won't try to run "php artisan ...")
RUN composer install \
    --no-dev \
    --prefer-dist \
    --no-interaction \
    --no-progress \
    --optimize-autoloader \
    --no-scripts

# ---------- Runtime stage: PHP 8.3 FPM + Nginx ----------
FROM php:8.3-fpm-bookworm

# System packages for nginx/supervisor and building PHP extensions (curl needs libcurl dev + pkg-config)
RUN apt-get update && apt-get install -y --no-install-recommends \
    nginx supervisor \
    pkg-config \
    libcurl4-openssl-dev \
    libpq-dev \
    libicu-dev libzip-dev \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    libonig-dev libxml2-dev \
 && rm -rf /var/lib/apt/lists/*

# PHP extensions for Laravel
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install -j$(nproc) \
    pdo pdo_mysql pdo_pgsql mbstring xml curl zip gd opcache intl

WORKDIR /var/www/html

# Copy app source (artisan is here)
COPY . /var/www/html
    RUN rm -f /var/www/html/bootstrap/cache/*.php

# Copy vendor from build stage
COPY --from=vendor /app/vendor /var/www/html/vendor

# Nginx + Supervisor configs
COPY .render/nginx.conf /etc/nginx/sites-available/default
COPY .render/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Permissions
RUN mkdir -p \
    /var/www/html/storage/framework/cache \
    /var/www/html/storage/framework/sessions \
    /var/www/html/storage/framework/views \
    /var/www/html/storage/logs \
    /var/www/html/bootstrap/cache \
 && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
 && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80
CMD ["/usr/bin/supervisord", "-n"]
