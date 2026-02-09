#!/bin/bash
set -e

# If .env doesn't exist, generate one from environment variables
if [ ! -f /var/www/html/.env ]; then
    echo "No .env file found, creating from environment variables..."
    env | grep -E '^(APP_|DB_|SESSION_|CACHE_|MAIL_|REDIS_|LOG_|BROADCAST_|QUEUE_|FILESYSTEM_|PORT|GOOGLE_)' > /var/www/html/.env
fi

# Ensure storage directories exist and have correct permissions
mkdir -p storage/logs storage/framework/cache/data storage/framework/sessions storage/framework/views bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Cache config and routes for production
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Run migrations automatically
php artisan migrate --force || true

# Start Apache
apache2-foreground
