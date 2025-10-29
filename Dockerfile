# Use an official PHP FPM image
FROM php:8.2-fpm

# Install system deps and extensions commonly used
RUN apt-get update && apt-get install -y \
    nginx \
    git \
    unzip \
    libzip-dev \
    zip \
 && docker-php-ext-install pdo pdo_mysql zip

# Install composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Create web root
WORKDIR /var/www/html

# Copy app
COPY . /var/www/html

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction || true

# Copy nginx config
COPY docker/nginx.conf /etc/nginx/sites-available/default

# Ensure permissions
RUN chown -R www-data:www-data /var/www/html \
 && chmod -R 755 /var/www/html

# Expose port
EXPOSE 3000

# Start php-fpm and nginx when container starts
CMD php -S 0.0.0.0:$PORT -t public

