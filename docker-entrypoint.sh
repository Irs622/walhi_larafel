#!/bin/bash
set -e

# Copy .env if not present
if [ ! -f .env ]; then
    echo "Creating .env from .env.example..."
    cp .env.example .env
fi

# Ensure SQLite database file exists if DB_CONNECTION is sqlite
if [ "${DB_CONNECTION:-sqlite}" = "sqlite" ]; then
    mkdir -p database
    if [ ! -f database/database.sqlite ]; then
        echo "Creating database/database.sqlite..."
        touch database/database.sqlite
    fi
fi

# Generate APP_KEY if empty
if ! grep -q "^APP_KEY=base64:" .env || [ -z "$(grep "^APP_KEY=" .env | cut -d'=' -f2)" ]; then
    echo "Generating Application Key..."
    php artisan key:generate --force
fi

# Ensure permissions for storage and bootstrap/cache
chmod -R 777 storage bootstrap/cache

# Create storage link if missing
if [ ! -L public/storage ]; then
    echo "Creating storage link..."
    php artisan storage:link --force || true
fi

# Run Database Migrations
echo "Running database migrations..."
php artisan migrate --force

# Seed database if database is fresh / requested
if [ "${SEED_ON_START:-true}" = "true" ]; then
    echo "Seeding database..."
    php artisan db:seed --force || true
fi

echo "WALHI Jabar application is starting on http://0.0.0.0:8000"

# Execute the main command (php artisan serve or passed CMD)
exec "$@"
