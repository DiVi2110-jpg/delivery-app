# ---------- Build stage: install Composer deps with PHP 8.3 + required extensions ----------
FROM php:8.3-cli-bookworm AS vendor

WORKDIR /app

# System deps for intl + zip (and git/unzip for composer downloads)
RUN apt-get update && apt-get install -y --no-install-recommends \
    git unzip ca-certificates \
    libicu-dev zlib1g-dev libzip-dev \
 && rm -rf /var/lib/apt/lists/*

# PHP extensions needed during composer install
RUN docker-php-ext-install -j$(nproc) intl zip

# Install Composer (from official image)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy only composer files first (cache-friendly)
COPY composer.json composer.lock ./

# IMPORTANT: no-scripts so it doesn't try to run "php artisan ..."
RUN composer install \
    --no-dev \
    --prefer-dist \
    --no-interaction \
    --no-progress \
    --optimize-autoloader \
    --no-scripts

# ---------- Runtime stage: PHP 8.3 FPM + Nginx ----------
FROM php:8.3-fpm-bookworm

# System packages for nginx/supervisor and PHP extensions build
RUN apt-get update && apt-get install -y --no-install-recommends \
    nginx supervisor \
    pkg-config \
    libcurl4-openssl-dev \
    libicu-dev libzip-dev \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    libonig-dev libxml2-dev \
 && rm -rf /var/lib/apt/lists/*

# PHP extensions for Laravel
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install -j$(nproc) \
    pdo pdo_mysql mbstring xml curl zip gd opcache intl

WORKDIR /var/www/html

# Copy app source (now artisan exists here)
COPY . /var/www/html

# Copy vendor from build stage
COPY --from=vendor /app/vendor /var/www/html/vendor

# Nginx + Supervisor configs
COPY .render/nginx.conf /etc/nginx/sites-available/default
COPY .render/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Permissions
RUN chown -R www-data:www-data /var/www/html \
 && mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache \
 && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

CMD ["/usr/bin/supervisord", "-n"]