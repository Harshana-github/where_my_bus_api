FROM php:8.1-fpm

# Install nginx and supervisor
RUN apt-get update && apt-get install -y nginx supervisor

# Set working directory
WORKDIR /var/www

# Copy Laravel files
COPY . .

# Copy configuration files
COPY deploy/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY deploy/nginx.conf /etc/nginx/nginx.conf

# Expose port
EXPOSE 80

CMD ["/usr/bin/supervisord"]
