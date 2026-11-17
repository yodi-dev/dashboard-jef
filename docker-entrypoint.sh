#!/bin/sh
set -e

# Ensure storage link exists
php artisan storage:link --no-interaction || true

# In production, cache config & routes if possible
if [ "$APP_ENV" = "production" ]; then
    php artisan config:cache || true
    php artisan route:cache || true
    php artisan view:cache || true
fi

# Run FrankenPHP
exec frankenphp run --config /etc/caddy/Caddyfile
