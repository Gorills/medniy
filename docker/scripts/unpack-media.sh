#!/usr/bin/env bash
set -euo pipefail

PROJECT_DIR="$(cd "$(dirname "$0")/../.." && pwd)"
ARCHIVE="${1:-}"

if [ -z "$ARCHIVE" ]; then
    echo "Использование: $0 <путь к medniy-media.tar.gz>"
    echo ""
    echo "Архив должен содержать:"
    echo "  public/img/        — изображения сайта"
    echo "  public/assets/     — статика (галерея, схемы)"
    echo "  public/pdf/        — PDF-документы"
    echo "  storage/app/public/ — пользовательские загрузки"
    exit 1
fi

if [ ! -f "$ARCHIVE" ]; then
    echo "Файл не найден: $ARCHIVE" >&2
    exit 1
fi

echo "=== Распаковка медиа из $ARCHIVE ==="
tar xzf "$ARCHIVE" -C "$PROJECT_DIR"

for d in public/img public/assets public/pdf storage/app/public; do
    if [ -d "$PROJECT_DIR/$d" ]; then
        size=$(du -sh "$PROJECT_DIR/$d" 2>/dev/null | cut -f1)
        echo "  ✓ $d ($size)"
    fi
done

echo "=== Готово ==="
