#!/usr/bin/env bash
set -euo pipefail

PROJECT_DIR="$(cd "$(dirname "$0")/../.." && pwd)"

if [ -f "$PROJECT_DIR/.env" ]; then
  set -a
  # shellcheck disable=SC1091
  source "$PROJECT_DIR/.env"
  set +a
fi

if [ -z "${1:-}" ]; then
    echo "Использование: $0 <файл>"
    echo ""
    echo "Поддерживаемые форматы:"
    echo "  db_XXXXXX.sql.gz      — дамп БД"
    echo "  medniy-media.tar.gz   — медиа-архив"
    echo "  media_XXXXXX.tar.gz   — медиа-бэкап (из make backup)"
    echo ""
    echo "Доступные бэкапы:"
    ls -lh "$PROJECT_DIR/backups"/db_*.sql.gz 2>/dev/null || echo "  (нет бэкапов БД)"
    ls -lh "$PROJECT_DIR/backups"/media_*.tar.gz 2>/dev/null || echo "  (нет бэкапов медиа)"
    exit 1
fi

FILE="$1"

case "$FILE" in
    *media*.tar.gz | *medniy-media*.tar.gz)
        echo "=== Восстановление медиа из $FILE ==="
        "$PROJECT_DIR/docker/scripts/unpack-media.sh" "$FILE"
        ;;
    *db*.sql.gz | *.sql.gz)
        echo "=== Восстановление БД из $FILE ==="
        echo "ВНИМАНИЕ: текущие данные будут перезаписаны!"
        read -p "Продолжить? (y/N) " -n 1 -r
        echo
        [[ $REPLY =~ ^[Yy]$ ]] || exit 0

        gunzip -c "$FILE" | docker compose -f "$PROJECT_DIR/docker-compose.yml" exec -T db \
            mysql -u root -p"${MYSQL_ROOT_PASSWORD}" "${DB_DATABASE}"

        docker compose -f "$PROJECT_DIR/docker-compose.yml" exec app php artisan cache:clear
        echo "=== Готово ==="
        ;;
    *)
        echo "Неизвестный формат файла: $FILE" >&2
        echo "Ожидается *.sql.gz (БД) или *media*.tar.gz (медиа)" >&2
        exit 1
        ;;
esac
