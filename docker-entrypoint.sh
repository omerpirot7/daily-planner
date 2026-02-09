#!/bin/bash
set -e

# Configure Apache to listen on the platform-provided PORT
PORT_TO_USE="${PORT:-8000}"
sed -i -E "s/^Listen .*/Listen ${PORT_TO_USE}/" /etc/apache2/ports.conf
sed -i -E "s/<VirtualHost \*:[0-9]+>/<VirtualHost *:${PORT_TO_USE}>/" /etc/apache2/sites-available/000-default.conf

# Ensure storage directories exist and have correct permissions
mkdir -p storage/logs storage/framework/cache/data storage/framework/sessions storage/framework/views bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# If a .env file isn't present (common on platforms), generate one from env vars
if [ ! -f /var/www/html/.env ]; then
	env | grep -E '^(APP_|DB_|SESSION_|CACHE_|MAIL_|REDIS_|LOG_|BROADCAST_|QUEUE_|FILESYSTEM_|GOOGLE_)' > /var/www/html/.env || true
	chown www-data:www-data /var/www/html/.env || true
	chmod 0644 /var/www/html/.env || true
fi

# Clear any cached config so .env is read fresh
php artisan config:clear || true

# Run migrations automatically
php artisan migrate --force || true

# Cache views for performance
php artisan view:cache || true

# Start Apache
apache2-foreground
