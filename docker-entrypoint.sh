#!/bin/bash
set -e

# Cache config and routes for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations automatically
php artisan migrate --force

# Start Apache
apache2-foreground
