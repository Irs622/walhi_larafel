# ─── Stage 1: Node.js Asset Build ───────────────────────────
FROM node:20-alpine AS frontend
WORKDIR /app
COPY package*.json vite.config.js tailwind.config.js postcss.config.js ./
COPY resources ./resources
COPY public ./public
RUN npm ci || npm install
RUN npm run build

# ─── Stage 2: PHP Application Container (PHP-FPM) ─────────────
FROM php:8.4-fpm-alpine

# Install system dependencies & PHP extensions
RUN apk add --no-cache \
    bash \
    curl \
    git \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    zip \
    unzip \
    sqlite \
    sqlite-dev \
    oniguruma-dev \
    icu-dev \
    sed \
    su-exec \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        pdo_sqlite \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        intl

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy composer files and install dependencies
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# Copy application source
COPY . .

# Copy built assets from frontend stage
COPY --from=frontend /app/public/build ./public/build

# Complete composer autoloader
RUN composer dump-autoload --optimize --no-dev

# Ensure all Laravel storage framework directories exist in the image
RUN mkdir -p storage/framework/views \
             storage/framework/cache/data \
             storage/framework/sessions \
             storage/framework/testing \
             storage/logs \
             storage/app/public \
             bootstrap/cache

# Set permissions for Laravel storage and cache
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache \
    && chmod +x docker-entrypoint.sh

EXPOSE 9000

ENTRYPOINT ["/var/www/html/docker-entrypoint.sh"]
CMD ["php-fpm"]
