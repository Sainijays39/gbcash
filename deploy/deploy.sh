#!/bin/bash
#
# Run this from the project root on the VPS, after the latest code is already
# in place (git pull / rsync / upload done). Safe to re-run on every deploy.
#
# Usage: bash deploy/deploy.sh
set -euo pipefail

echo "==> Putting the app into maintenance mode"
php artisan down --retry=15 || true

echo "==> Installing PHP dependencies (production only)"
composer install --no-dev --optimize-autoloader --no-interaction

echo "==> Installing JS dependencies and building assets"
npm ci
npm run build

echo "==> Linking storage"
php artisan storage:link --force

echo "==> Running database migrations"
php artisan migrate --force

echo "==> Caching config, routes, views and events"
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

echo "==> Fixing storage/cache permissions"
chmod -R 775 storage bootstrap/cache
# Adjust www-data to whatever user your PHP-FPM pool runs as (check
# /etc/php/*/fpm/pool.d/www.conf for the "user"/"group" directives).
chown -R "$(whoami)":www-data storage bootstrap/cache

echo "==> Bringing the app back up"
php artisan up

echo "==> Restarting PHP-FPM (adjust the service name to your installed PHP version)"
sudo systemctl restart php8.3-fpm || true

echo "Deploy complete."
