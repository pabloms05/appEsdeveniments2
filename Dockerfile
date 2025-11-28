# --- STAGE 1: Build de Node (Assets) ---
FROM node:20-alpine AS node_builder
WORKDIR /app

COPY package*.json ./
RUN npm ci

COPY . .
RUN npm run build


# --- STAGE 2: PHP + Composer ---
FROM php:8.2-fpm-alpine AS php_builder
WORKDIR /app

RUN set -eux; \
    apk update; \
    apk add --no-cache --virtual .build-deps $PHPIZE_DEPS libzip-dev icu-dev sqlite-dev; \
    apk add --no-cache icu sqlite-libs git unzip zip bash; \
    docker-php-ext-configure intl; \
    docker-php-ext-install -j"$(nproc)" intl pdo_sqlite mbstring bcmath zip; \
    docker-php-ext-enable opcache; \
    apk del .build-deps

# (Opcional) instal·lar pdo_mysql si requereixes MySQL
# RUN docker-php-ext-install pdo_mysql

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY --from=node_builder /app /app

RUN composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction


# --- STAGE 3: Imagen Final ---
FROM php:8.2-fpm-alpine
WORKDIR /var/www/html

COPY --from=php_builder /app /var/www/html

RUN mkdir -p database \
    && touch database/database.sqlite \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html

USER www-data

RUN cp .env.example .env || true \
    && php artisan key:generate \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

EXPOSE 9000
