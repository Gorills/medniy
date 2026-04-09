.PHONY: up down build logs shell backup restore key restart migrate \
       media-pack media-unpack

up:
	docker compose up -d

down:
	docker compose down

build:
	docker compose build

logs:
	docker compose logs -f

shell:
	docker compose exec app sh

key:
	docker compose exec app php artisan key:generate --force

migrate:
	docker compose exec app php artisan migrate --force

restart:
	docker compose restart

backup:
	./docker/scripts/backup.sh

restore:
	@test -n "$(FILE)" || (echo "Использование: make restore FILE=<db_xxx.sql.gz | medniy-media.tar.gz>" && exit 1)
	./docker/scripts/restore.sh $(FILE)

# --- Медиа-архив для передачи ---

media-pack:
	./docker/scripts/pack-media.sh $(or $(OUT),medniy-media.tar.gz)

media-unpack:
	@test -n "$(FILE)" || (echo "Использование: make media-unpack FILE=medniy-media.tar.gz" && exit 1)
	./docker/scripts/unpack-media.sh $(FILE)
