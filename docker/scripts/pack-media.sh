#!/usr/bin/env bash
set -euo pipefail

PROJECT_DIR="$(cd "$(dirname "$0")/../.." && pwd)"
OUT="${1:-$PROJECT_DIR/medniy-media.tar.gz}"

MEDIA_DIRS=(
    public/img
    public/assets
    public/pdf
    storage/app/public
)

existing=()
for d in "${MEDIA_DIRS[@]}"; do
    if [ -d "$PROJECT_DIR/$d" ]; then
        existing+=("$d")
    else
        echo "⚠ Каталог $d не найден — пропускаю"
    fi
done

if [ ${#existing[@]} -eq 0 ]; then
    echo "Нет медиа-каталогов для упаковки." >&2
    exit 1
fi

echo "=== Упаковка медиа-архива ==="
for d in "${existing[@]}"; do
    size=$(du -sh "$PROJECT_DIR/$d" 2>/dev/null | cut -f1)
    echo "  • $d ($size)"
done

tar czf "$OUT" -C "$PROJECT_DIR" "${existing[@]}"

size=$(du -sh "$OUT" | cut -f1)
echo "=== Готово: $OUT ($size) ==="
