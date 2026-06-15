#!/bin/sh
set -e

cd /var/www/html

php artisan config:cache
php artisan route:cache
php artisan view:cache

if [ "${RUN_MIGRATIONS:-false}" = "true" ]; then
    if [ "${FRESH_MIGRATIONS:-false}" = "true" ]; then
        php artisan migrate:fresh --force --seed
    else
        php artisan migrate --force
    fi
fi

php artisan storage:link || true

exec "$@"
