# ---------- Build stage: install Composer deps with PHP 8.3 ----------
FROM composer:2 AS vendor

WORKDIR /app

# Copy only composer files first (better cache)
COPY composer.json composer.lock ./

# Install dependencies (prod only) into /app/vendor
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress --optimize-autoloader

# ---------- Runtime stage: PHP 8.3 + Nginx ----------
FROM php:8.3-fpm-bookworm

# Install system packages: nginx + supervisor + required libs
RUN apt-get update && apt-get install -y --no-install-recommends \
    nginx supervisor git unzip ca-certificates \
    libzip-dev libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    libonig-dev libxml2-dev \
 && rm -rf /var/lib/apt/lists/*

# PHP extensions commonly needed by Laravel
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install -j$(nproc) pdo pdo_mysql mbstring xml curl zip gd opcache

# App directory
WORKDIR /var/www/html

# Copy app source
COPY . /var/www/html

# Copy vendor from build stage
COPY --from=vendor /app/vendor /var/www/html/vendor

# Nginx + Supervisor configs
COPY .render/nginx.conf /etc/nginx/sites-available/default
COPY .render/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Permissions for Laravel writable dirs
RUN chown -R www-data:www-data /var/www/html \
 && mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache \
 && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

CMD ["/usr/bin/supervisord", "-n"]
