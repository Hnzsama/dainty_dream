# Stage 1: Build Assets
FROM node:20-alpine AS node-stage
WORKDIR /app
COPY package*.json vite.config.js ./
RUN npm ci
COPY resources ./resources
COPY public ./public
RUN npm run build

# Stage 2: PHP Application Server
FROM php:8.2-fpm-alpine

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apk add --no-cache \
    nginx \
    curl \
    git \
    unzip \
    libzip-dev

# Install PHP extensions
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions gd bcmath zip pdo_mysql pdo_pgsql opcache intl pdo_sqlite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configure Nginx
COPY docker/nginx.conf /etc/nginx/http.d/default.conf
RUN sed -i 's/user nginx;/user www-data;/g' /etc/nginx/nginx.conf
RUN mkdir -p /run/nginx && chown -R www-data:www-data /run/nginx

# Copy application code
COPY . .

# Copy compiled assets from node stage
COPY --from=node-stage /app/public/build ./public/build

# Copy environment file template
RUN cp .env.example .env

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress

# Setup storage and cache permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Copy startup script
COPY docker/startup.sh /usr/local/bin/startup.sh
RUN chmod +x /usr/local/bin/startup.sh

# Expose default port
EXPOSE 8080

# Run entrypoint script
ENTRYPOINT ["/usr/local/bin/startup.sh"]
