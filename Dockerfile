# Use the official PHP 8.2 image with Apache
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip curl zip libzip-dev libpng-dev libonig-dev libxml2-dev libcurl4-openssl-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Enable Apache rewrite module
RUN a2enmod rewrite

# Copy application code
COPY . .

# Install Composer globally
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install Laravel dependencies
RUN composer install --optimize-autoloader --no-dev

# Set appropriate permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# Expose port 80 (used by Apache)
EXPOSE 80

# Use Laravel's storage and cache folders
RUN chmod -R 775 storage bootstrap/cache

# Set environment to production
ENV APP_ENV=production

# Apache serves from /var/www/html by default
