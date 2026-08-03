#!/usr/bin/env bash
echo "Installing composer dependencies..."
composer install --no-dev --working-dir=/var/www/html --optimize-autoloader

echo "Caching config & routes..."
php artisan config:cache
php artisan route:cache

echo "Linking storage..."
php artisan storage:link

echo "Running migrations..."
php artisan migrate --force

echo "Seeding roles & users..."
php artisan db:seed --class=RoleSeeder --force
php artisan db:seed --class=UserSeeder --force
php artisan db:seed --class=UstazSeeder --force