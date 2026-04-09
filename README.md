# medniy.moscow

Сайт на Laravel 5.6 (PHP 7.3): публичная часть и админка Sleeping Owl.

## Что нужно для развёртывания

| Компонент | Откуда | Размер |
|-----------|--------|--------|
| Репозиторий | `git clone` | ~30 МБ (только код) |
| Медиа-архив | `medniy-media.tar.gz` (передаётся отдельно) | ~600 МБ |
| Дамп БД | `01_medniy_seed.sql.gz` (передаётся отдельно) | ~10 МБ |

**Медиа и дамп БД не хранятся в репозитории.** Их передаёт ответственный разработчик (архив + файл дампа) любым удобным способом: по сети, через файлообменник, на флешке.

### Требования

- Docker ≥ 20.10, Docker Compose v2, GNU **make**

## Быстрый старт (Docker)

### 1. Клонировать репозиторий

```bash
git clone <url> medniy && cd medniy
```

### 2. Положить дамп БД

Скопировать полученный дамп в `docker/db/init/`:

```bash
cp /path/to/01_medniy_seed.sql.gz docker/db/init/
```

MySQL автоматически импортирует его при первом создании тома `db_data`.

### 3. Распаковать медиа

```bash
make media-unpack FILE=/path/to/medniy-media.tar.gz
```

Архив распакует:

- `public/img/` — изображения сайта
- `public/assets/` — статика (галерея, схемы, карты)
- `public/pdf/` — PDF-документы
- `storage/app/public/` — пользовательские загрузки (фото хода строительства и т.д.)

### 4. Настроить окружение

```bash
cp .env.example .env
# Заполнить: DB_PASSWORD, MYSQL_ROOT_PASSWORD, REDIS_PASSWORD, APP_URL
```

### 5. Запустить

```bash
docker compose up -d
make key
docker compose up -d --force-recreate app cron
make migrate
docker compose exec app php artisan storage:link
```

Сайт: `https://medniy.moscow` (`HTTP_PORT` в `.env`).

> `--force-recreate` после `key:generate` обязателен: иначе контейнер использует старый пустой `APP_KEY`.

## Make-команды

| Команда | Описание |
|---------|----------|
| `make up` | Запуск контейнеров |
| `make down` | Остановка контейнеров |
| `make build` | Пересборка образов |
| `make logs` | Просмотр логов |
| `make shell` | Консоль в контейнере `app` |
| `make key` | Генерация `APP_KEY` |
| `make migrate` | Миграции БД |
| `make restart` | Перезапуск контейнеров |
| `make backup` | Бэкап БД + медиа в `backups/` |
| `make restore FILE=...` | Восстановление из бэкапа (`.sql.gz` или `media.tar.gz`) |
| `make media-pack` | Создать `medniy-media.tar.gz` для передачи |
| `make media-unpack FILE=...` | Распаковать медиа-архив |

## Переменные `.env` (обязательные для Docker)

| Переменная | Назначение |
|------------|------------|
| `APP_KEY` | `make key` |
| `DB_PASSWORD` / `MYSQL_ROOT_PASSWORD` | Пароли MySQL (разные значения) |
| `REDIS_PASSWORD` | Совпадает с паролем Redis в compose |
| `APP_URL` | Публичный URL сайта |

Остальное — `.env.example`.

## Хранение данных

| Что | Где | Бэкап | В git? |
|-----|-----|-------|--------|
| Код | всё, кроме ниже | — | да |
| БД | том `db_data` | `make backup` → `backups/db_*.sql.gz` | нет |
| Изображения сайта | `public/img/`, `public/assets/`, `public/pdf/` | `make backup` / `make media-pack` | нет |
| Загрузки | `storage/app/public/` + симлинк `public/storage` | `make backup` / `make media-pack` | нет |
| Redis | том `cache_data` | не обязателен | нет |
| Логи | `storage/logs/` | по желанию | нет |

## Кэш после смены данных

Модели с **Rememberable** кешируют выборки. Очистка:
`docker compose exec app php artisan cache:clear`.

## Периодические задачи

Контейнер `cron` раз в минуту выполняет `php artisan schedule:run` (в коде: `app:import` — почасово).

Логи: `docker compose logs -f cron`.

## Обслуживание

```bash
make logs                     # все контейнеры
make backup                   # бэкап БД + медиа в backups/
make restore FILE=backups/db_YYYYMMDD_HHMMSS.sql.gz
make restore FILE=backups/media_YYYYMMDD_HHMMSS.tar.gz
docker compose build && docker compose up -d   # обновление образов
```

Переимпорт БД из `docker/db/init/` — только при **пустом** томе MySQL; иначе см. `docker/db/init/README.md` (удаление тома `db_data`).

### Автобэкап на хосте (crontab)

```
0 3 * * * cd /path/to/medniy && ./docker/scripts/backup.sh >> /var/log/medniy-backup.log 2>&1
```

## Архитектура контейнеров

```text
Браузер → nginx (HTTP_PORT) → php-fpm (app) → MySQL (db), Redis (cache)
                                    ↑
                                 cron (schedule)
```

## Локальная разработка без Docker

После `composer install` скопируйте патч админки (совместимость Sleeping Owl с `laravel-breadcrumbs` 5.x):

```bash
cp docker/patches/vendor/laravelrus/sleepingowl/src/Templates/Breadcrumbs.php \
   vendor/laravelrus/sleepingowl/src/Templates/Breadcrumbs.php
```

Сборка фронта: корневой `package.json`, `webpack.mix.js`.

### Калькулятор (React)

В `react-calculator`: `npm install`, `yarn start`. Собранные скрипты копировать в `public/mortgage/static/`, как в истории проекта.
