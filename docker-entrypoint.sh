#!/usr/bin/env sh
set -eu

export PORT="${PORT:-8080}"

php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link || true

if [ "${AUTO_MIGRATE:-0}" = "1" ]; then
    php artisan migrate --force || true
fi

if [ -f /etc/nginx/nginx.conf ]; then
    envsubst '${PORT}' < /etc/nginx/nginx.conf > /tmp/nginx.conf
    mv /tmp/nginx.conf /etc/nginx/nginx.conf
fi

exec "$@"
