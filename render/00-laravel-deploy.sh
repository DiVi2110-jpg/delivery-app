#!/usr/bin/env sh
set -e

cd /var/www/html

# Install PHP dependencies
composer install --no-dev --optimize-autoloader --no-interaction

# If no app key provided, keep running but warn in logs
php artisan config:clear || true
php artisan cache:clear || true

# Ensure writable dirs exist
mkdir -p storage/framework/{cache,sessions,views}
mkdir -p bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache || true

# SQLite database file (for free, simplest)
if [ ! -f database/database.sqlite ]; then
  touch database/database.sqlite
  chown www-data:www-data database/database.sqlite || true
fi

# Run migrations if DB configured
php artisan migrate --force || true

# Optimize
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true