FROM composer as builder
WORKDIR /app
# Install dependencies
COPY composer.json composer.json
COPY composer.lock composer.lock
RUN composer install --no-autoloader --no-progress --no-dev

# Copy codebase
COPY . ./

# Create Autoloading
RUN composer dump-autoload --optimize --no-interaction --no-cache
#RUN rm -f /app/app/config/config.local.neon

FROM php:8.0-apache as app
RUN docker-php-ext-install pdo pdo_mysql
RUN a2enmod rewrite
RUN a2enmod deflate
COPY php.ini /usr/local/etc/php/php.ini
COPY virtualhost.conf /etc/apache2/sites-enabled/000-default.conf
COPY --from=builder /app /var/www/html/
RUN chmod -R 0777 /var/www/html/temp && chmod -R 0777 /var/www/html/log
