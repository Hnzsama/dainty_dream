#!/bin/sh

# Set fallback port if not provided by Railway
PORT=${PORT:-8080}

# Update Nginx config to listen on the correct Railway port
sed -i "s/listen 80;/listen ${PORT};/g" /etc/nginx/http.d/default.conf

# Ensure SQLite database exists if configured
if [ "${DB_CONNECTION}" = "sqlite" ] || [ -z "${DB_CONNECTION}" ]; then
    echo "Using SQLite database. Ensuring database file exists..."
    mkdir -p /var/www/html/database
    touch /var/www/html/database/database.sqlite
    chown -R www-data:www-data /var/www/html/database
fi

# Run migrations and optimize Laravel
echo "Caching Laravel configuration, routes, and views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Running migrations..."
php artisan migrate --force

# Start Nginx in background
echo "Starting Nginx..."
nginx

# Start PHP-FPM in foreground
echo "Starting PHP-FPM..."
php-fpm
