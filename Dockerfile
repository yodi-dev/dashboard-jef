# -------------------------------------------------------------
# Stage 1: Build Frontend Assets (Tailwind & Alpine)
# -------------------------------------------------------------
FROM node:20-alpine AS frontend
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# -------------------------------------------------------------
# Stage 2: Production PHP Application Server (FrankenPHP)
# -------------------------------------------------------------
FROM dunglas/frankenphp:1-php8.3-alpine AS runner

WORKDIR /app

# Install system dependencies & CA certificates for secure TLS connections
# Note: libcap-utils & setcap -r is required for unprivileged container runtimes like Render
RUN apk add --no-cache ca-certificates curl libcap-utils && \
    setcap -r /usr/local/bin/frankenphp

# Install PHP extensions required by Laravel
RUN install-php-extensions \
    pdo_mysql \
    bcmath \
    intl \
    zip \
    opcache

# Copy composer from official image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy application source
COPY . .
COPY --from=frontend /app/public/build ./public/build

# Configure PHP upload limits (32M) and memory
RUN cp $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini && \
    echo "upload_max_filesize = 32M" >> $PHP_INI_DIR/conf.d/uploads.ini && \
    echo "post_max_size = 32M" >> $PHP_INI_DIR/conf.d/uploads.ini && \
    echo "memory_limit = 256M" >> $PHP_INI_DIR/conf.d/uploads.ini

# Install production PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Prepare storage & cache directories with proper permissions for unprivileged runtime
RUN mkdir -p storage/app/public/heroes \
    storage/app/public/profiles \
    storage/app/public/portfolios/thumbnails \
    storage/app/public/portfolios/galleries \
    storage/app/public/articles/covers \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache && \
    chmod -R 777 storage bootstrap/cache

# Copy custom Caddyfile and entrypoint script
COPY Caddyfile /etc/caddy/Caddyfile
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENV PORT=8000
ENV LOG_CHANNEL=stderr
EXPOSE 8000

ENTRYPOINT ["docker-entrypoint.sh"]
