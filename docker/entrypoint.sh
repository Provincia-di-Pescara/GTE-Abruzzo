#!/bin/sh
set -e

# Cache Laravel configuration, routes and compiled views for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run pending database migrations automatically on startup
php artisan migrate --force --no-interaction

# Hand off to Supervisor, which manages PHP-FPM and Nginx
exec /usr/bin/supervisord -n -c /etc/supervisor/conf.d/supervisord.conf
