#!/bin/bash
# ─────────────────────────────────────────────────────────────
# WALHI Jawa Barat — Automated Database Backup Script
# ─────────────────────────────────────────────────────────────
set -e

BACKUP_DIR="${BACKUP_DIR:-./storage/backups}"
TIMESTAMP=$(date +"%Y%m%d_%H%M%S")
mkdir -p "$BACKUP_DIR"

echo "📦 Starting WALHI database backup: $TIMESTAMP"

# 1. Check if production MySQL container is running
if docker ps --format '{{.Names}}' | grep -q "^walhi_prod_db$"; then
    echo "💾 Backing up MySQL database from walhi_prod_db..."
    BACKUP_FILE="$BACKUP_DIR/walhi_prod_mysql_$TIMESTAMP.sql.gz"
    docker exec walhi_prod_db mysqldump -u "${DB_USERNAME:-walhi_user}" -p"${DB_PASSWORD:-walhi_secret_pass}" "${DB_DATABASE:-walhi_prod}" | gzip > "$BACKUP_FILE"
    echo "✅ MySQL backup saved: $BACKUP_FILE ($(du -h "$BACKUP_FILE" | cut -f1))"

# 2. Check if SQLite database exists
elif [ -f "./storage/app/database.sqlite" ]; then
    echo "💾 Backing up SQLite database..."
    BACKUP_FILE="$BACKUP_DIR/walhi_sqlite_$TIMESTAMP.sqlite.gz"
    gzip -c "./storage/app/database.sqlite" > "$BACKUP_FILE"
    echo "✅ SQLite backup saved: $BACKUP_FILE ($(du -h "$BACKUP_FILE" | cut -f1))"

else
    echo "⚠️ No running database container or SQLite file found to back up."
    exit 1
fi

# 3. Clean up backups older than 30 days
find "$BACKUP_DIR" -type f -name "walhi_*" -mtime +30 -exec rm {} \;
echo "🧹 Old backups (>30 days) cleaned up."
echo "🎉 Backup completed successfully!"
