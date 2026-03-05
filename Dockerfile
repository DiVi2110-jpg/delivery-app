FROM richarvey/nginx-php-fpm:latest

# Laravel code goes to /var/www/html in this image
COPY . /var/www/html

# Nginx config (overrides default)
COPY .render/nginx.conf /etc/nginx/sites-available/default.conf

# Startup/deploy script
COPY .render/00-laravel-deploy.sh /etc/cont-init.d/00-laravel-deploy.sh
RUN chmod +x /etc/cont-init.d/00-laravel-deploy.sh

# Permissions for Laravel writable dirs
RUN chown -R www-data:www-data /var/www/html \
  && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
