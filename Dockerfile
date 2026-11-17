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
RUN apk add --no-cache ca-certificates curl

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

# Install production PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Prepare storage & cache directories with proper permissions
RUN mkdir -p storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache

# Copy custom Caddyfile and entrypoint script
COPY Caddyfile /etc/caddy/Caddyfile
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENV PORT=8000
EXPOSE 8000

ENTRYPOINT ["docker-entrypoint.sh"]
