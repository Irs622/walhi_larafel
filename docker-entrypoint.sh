#!/bin/bash
set -e

echo "═══════════════════════════════════════════════════════════"
echo "  WALHI Jabar — Docker Entrypoint"
echo "═══════════════════════════════════════════════════════════"

# ── 1. Ensure all required Laravel storage directories exist ──
echo "[1/7] Creating storage directories..."
mkdir -p storage/framework/views \
         storage/framework/cache/data \
         storage/framework/sessions \
         storage/framework/testing \
         storage/logs \
         storage/app/public \
         bootstrap/cache

# ── 2. Fix permissions ──
echo "[2/7] Setting permissions..."
chmod -R 775 storage bootstrap/cache 2>/dev/null || true

# ── 3. Generate .env from Docker environment variables ──
# Always regenerate .env to ensure Docker env vars take precedence.
# This avoids sed/parsing issues and stale config.
echo "[3/7] Generating .env from environment variables..."

ADMIN_PASS_VAL="${ADMIN_PASSWORD:-}"
if [ -z "$ADMIN_PASS_VAL" ]; then
    ADMIN_PASS_VAL=$(tr -dc 'A-Za-z0-9' < /dev/urandom 2>/dev/null | head -c 16 || date +%s | sha256sum | head -c 16)
fi

cat > .env <<ENVFILE
APP_NAME="${APP_NAME:-Laravel}"
APP_ENV=${APP_ENV:-local}
APP_DEBUG=${APP_DEBUG:-true}
APP_URL=${APP_URL:-http://localhost:8000}
APP_KEY=${APP_KEY:-}

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US
APP_MAINTENANCE_DRIVER=file

BCRYPT_ROUNDS=12

LOG_CHANNEL=${LOG_CHANNEL:-stack}
LOG_STACK=daily
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=${LOG_LEVEL:-debug}

DB_CONNECTION=${DB_CONNECTION:-sqlite}
DB_DATABASE=${DB_DATABASE:-/var/www/html/storage/app/database.sqlite}

SESSION_DRIVER=${SESSION_DRIVER:-database}
SESSION_LIFETIME=120
SESSION_ENCRYPT=true
SESSION_PATH=/
SESSION_DOMAIN=null
SESSION_SECURE_COOKIE=true

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=${QUEUE_CONNECTION:-sync}

CACHE_STORE=${CACHE_STORE:-file}

MAIL_MAILER=log

VITE_APP_NAME="${APP_NAME:-Laravel}"

ADMIN_EMAIL=${ADMIN_EMAIL:-admin@walhi-jabar.org}
ADMIN_PASSWORD=${ADMIN_PASS_VAL}
ENVFILE
chmod 644 .env

# ── 4. Ensure SQLite database file exists ──
if [ "${DB_CONNECTION:-sqlite}" = "sqlite" ]; then
    DB_FILE="${DB_DATABASE:-/var/www/html/storage/app/database.sqlite}"
    mkdir -p "$(dirname "$DB_FILE")"
    if [ ! -f "$DB_FILE" ]; then
        echo "[4/7] Creating SQLite database at $DB_FILE..."
        touch "$DB_FILE"
        chmod 666 "$DB_FILE"
    else
        echo "[4/7] SQLite database already exists at $DB_FILE"
    fi
fi

# ── 5. Generate APP_KEY if empty ──
CURRENT_KEY=$(grep "^APP_KEY=" .env | cut -d'=' -f2- || true)
if [ -z "$CURRENT_KEY" ] || [ "$CURRENT_KEY" = "" ]; then
    echo "[5/7] Generating Application Key..."
    php artisan key:generate --force
else
    echo "[5/7] APP_KEY already set, skipping..."
fi

# ── 6. Create storage link if missing ──
if [ ! -L public/storage ]; then
    echo "[6/7] Creating storage symlink..."
    php artisan storage:link --force 2>/dev/null || true
else
    echo "[6/7] Storage link already exists, skipping..."
fi

# ── 7. Run Database Migrations & Seeding ──
echo "[7/7] Clearing cache & running database migrations..."
php artisan config:clear 2>/dev/null || true
php artisan view:clear 2>/dev/null || true
php artisan route:clear 2>/dev/null || true
php artisan cache:clear 2>/dev/null || true
php artisan migrate --force

if [ "${SEED_ON_START:-false}" = "true" ]; then
    echo "       Seeding database..."
    php artisan db:seed --force
fi

# Final permission fix after all operations
chmod -R 775 storage bootstrap/cache 2>/dev/null || true

echo ""
echo "═══════════════════════════════════════════════════════════"
echo "  ✅ WALHI Jabar is starting on http://0.0.0.0:8000"
echo "  📧 Admin: ${ADMIN_EMAIL:-admin@walhi-jabar.org}"
echo "  🔑 Password: (set via ADMIN_PASSWORD env var)"
echo "═══════════════════════════════════════════════════════════"
echo ""

# Execute the main command (php artisan serve or passed CMD)
exec "$@"
