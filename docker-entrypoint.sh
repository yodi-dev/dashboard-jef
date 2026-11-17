#!/bin/sh
set -e

# Ensure storage directories exist with full write permissions
mkdir -p storage/app/public/heroes \
         storage/app/public/profiles \
         storage/app/public/portfolios/thumbnails \
         storage/app/public/portfolios/galleries \
         storage/app/public/articles/covers \
         storage/framework/cache/data \
         storage/framework/sessions \
         storage/framework/views \
         storage/logs
chmod -R 777 storage bootstrap/cache

# Recreate fresh storage symlink
rm -rf public/storage
php artisan storage:link --no-interaction || true

# In production, cache config & routes if possible
if [ "$APP_ENV" = "production" ]; then
    php artisan config:cache || true
    php artisan route:cache || true
    php artisan view:cache || true
fi

# Run FrankenPHP
exec frankenphp run --config /etc/caddy/Caddyfile
