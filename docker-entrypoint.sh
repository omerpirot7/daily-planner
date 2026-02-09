#!/bin/bash
set -e

# Ensure storage directories exist and have correct permissions
mkdir -p storage/logs storage/framework/cache/data storage/framework/sessions storage/framework/views bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Clear any cached config so .env is read fresh
php artisan config:clear || true

# Run migrations automatically
php artisan migrate --force || true

# Cache views for performance
php artisan view:cache || true

# Start Apache
apache2-foreground
