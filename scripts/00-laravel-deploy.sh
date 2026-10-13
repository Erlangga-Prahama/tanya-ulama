#!/usr/bin/env bash
mkdir -p storage/app/public storage/app/private
chown -R nginx:nginx storage bootstrap/cache

php artisan config:cache
php artisan storage:link
php artisan migrate --force
php artisan db:seed --class=RoleSeeder --force