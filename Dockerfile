# Stage 1: PHP with Composer
FROM php:8.1-fpm AS base

WORKDIR /var/www

# Install system packages
RUN apt-get update && apt-get install -y \
    git curl zip unzip libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif bcmath

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy Laravel files
COPY . .

# Install dependencies (ignore platform PHP versions for docker compatibility)
RUN composer install --no-interaction --no-plugins --no-scripts --ignore-platform-reqs

# Set permissions
RUN chmod -R 775 storage bootstrap/cache

# Use CMD with JSON format to avoid signal handling issues
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]

