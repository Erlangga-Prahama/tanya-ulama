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

echo "=== DEBUG: Checking view files ==="
ls -la /var/www/html/resources/views/livewire/auth/ || echo "FOLDER NOT FOUND"
echo "=== END DEBUG 2 ==="

echo "=== DEBUG: Checking php-fpm socket ==="
find / -name "*.sock" 2>/dev/null
cat /etc/nginx/conf.d/*.conf 2>/dev/null | grep -i fastcgi_pass
echo "=== END DEBUG 3 ==="