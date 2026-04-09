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

### Если в браузере пустая страница или HTTP 500 на `http://localhost:8080/`

Чаще всего это **Redis**: в логах `storage/logs/laravel-*.log` будет `NOAUTH Authentication required`. Контейнер Redis всегда требует пароль (`--requirepass`), а Laravel берёт его из **`REDIS_PASSWORD` в `.env`**. Если переменной нет или она не совпадает с тем, с чем запущен Redis, кэш/сессии падают с 500.

Не задавайте `REDIS_PASSWORD=null`: в Laravel/phpdotenv это читается как «пароля нет», тогда как Redis всё равно ждёт `AUTH` — получится рассинхрон с контейнером `cache`. Используйте обычную строку (как в `.env.example`, `CHANGE_ME` или свой секрет).

Проверьте, что в `.env` задана одна и та же строка `REDIS_PASSWORD=...` (как в `.env.example`), затем перезапустите Redis и приложение:

```bash
docker compose up -d --force-recreate cache app cron
```

Если меняли пароль при уже существующем томе Redis — того же эффекта можно добиться только согласованием `.env` и перезапуском `cache`.

### Если `make migrate` — `Access denied for user 'medniy'`

Пароль в `.env` (`DB_PASSWORD`) не совпадает с паролем пользователя MySQL в томе `db_data`. MySQL создаёт пользователя `medniy` **один раз** при первом создании данных; смена `DB_PASSWORD` в `.env` после этого сама по себе БД не обновляет.

**Вариант 1 — согласовать пароль в MySQL с текущим `.env` (данные сохраняются):**

```bash
docker compose exec db mysql -uroot -p
```

Введите `MYSQL_ROOT_PASSWORD` из `.env`, затем в консоли MySQL (подставьте тот же пароль, что в `DB_PASSWORD`):

```sql
ALTER USER 'medniy'@'%' IDENTIFIED BY 'ВАШ_DB_PASSWORD_ИЗ_ENV';
FLUSH PRIVILEGES;
EXIT;
```

**Вариант 2 — пересоздать том БД с нуля** (все данные MySQL удалятся; дамп из `docker/db/init/` импортируется снова при пустом томе): см. [docker/db/init/README.md](docker/db/init/README.md) (`docker volume rm medniy_db_data` и т.д.). Перед этим убедитесь, что в `.env` уже стоят окончательные `DB_PASSWORD` и `MYSQL_ROOT_PASSWORD`.

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
