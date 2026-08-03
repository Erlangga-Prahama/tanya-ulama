#!/usr/bin/env bash
echo "Caching config..."
php artisan config:cache

echo "Linking storage..."
php artisan storage:link

echo "Running migrations..."
php artisan migrate --force

echo "Seeding roles & users..."
php artisan db:seed --class=RoleSeeder --force
php artisan db:seed --class=UserSeeder --force
php artisan db:seed --class=UstazSeeder --force

echo "=== DEBUG: Checking registered routes ==="
php artisan route:list | grep -i login || echo "NO LOGIN ROUTE FOUND"
echo "=== END DEBUG ==="