FROM php:8.1-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    supervisor \
    unzip \
    curl \
    git \
    libzip-dev \
    zip

# Set working directory
WORKDIR /var/www

# Copy Laravel source
COPY . .

# Install Laravel dependencies
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    composer install

# Copy configs
COPY deploy/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY deploy/nginx.conf /etc/nginx/nginx.conf

# Expose port
EXPOSE 80

# Start services
CMD ["/usr/bin/supervisord"]
