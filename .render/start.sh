#!/usr/bin/env sh
set -e

cd /var/www/html

php artisan migrate --force

exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
