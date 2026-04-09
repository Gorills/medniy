#!/usr/bin/env bash
set -euo pipefail

PROJECT_DIR="$(cd "$(dirname "$0")/../.." && pwd)"
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="${BACKUP_DIR:-$PROJECT_DIR/backups}"
KEEP_DAYS="${KEEP_DAYS:-7}"

if [ -f "$PROJECT_DIR/.env" ]; then
  set -a
  # shellcheck disable=SC1091
  source "$PROJECT_DIR/.env"
  set +a
fi

mkdir -p "$BACKUP_DIR"

echo "=== Бэкап БД ==="
docker compose -f "$PROJECT_DIR/docker-compose.yml" exec -T db \
    mysqldump -u root -p"${MYSQL_ROOT_PASSWORD}" "${DB_DATABASE}" \
    | gzip > "$BACKUP_DIR/db_$DATE.sql.gz"
echo "  → $BACKUP_DIR/db_$DATE.sql.gz"

echo "=== Бэкап медиа (public + storage/app/public) ==="
tar czf "$BACKUP_DIR/media_$DATE.tar.gz" \
    -C "$PROJECT_DIR" public/img public/assets public/pdf storage/app/public 2>/dev/null || true
echo "  → $BACKUP_DIR/media_$DATE.tar.gz"

echo "=== Ротация (оставить $KEEP_DAYS дней) ==="
find "$BACKUP_DIR" -name "db_*.sql.gz" -mtime "+$KEEP_DAYS" -delete
find "$BACKUP_DIR" -name "media_*.tar.gz" -mtime "+$KEEP_DAYS" -delete

echo "=== Готово ==="
