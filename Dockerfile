# Stage 1: install PHP dependencies (Flux UI menyimpan CSS-nya di vendor/,
# jadi harus ada sebelum build asset frontend)
FROM composer:2 AS vendor
WORKDIR /app
COPY . .
RUN composer install --no-dev --no-scripts --ignore-platform-reqs --optimize-autoloader

# Stage 2: build frontend assets (Tailwind, Alpine, Flux)
FROM node:20-alpine AS assets
WORKDIR /app
COPY --from=vendor /app /app
RUN npm install
RUN npm run build

# Stage 3: image final PHP + nginx
FROM richarvey/nginx-php-fpm:3.1.6
COPY --from=assets /app /var/www/html

ENV SKIP_COMPOSER=1
ENV WEBROOT=/var/www/html/public
ENV PHP_ERRORS_STDERR=1
ENV RUN_SCRIPTS=1
ENV REAL_IP_HEADER=1
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV NGINX_STATIC_INDEX=index.php

CMD ["/start.sh"]