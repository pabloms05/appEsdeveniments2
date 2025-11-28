# --- STAGE 1: Build de Node (Assets) ---
FROM node:20-alpine AS node_builder
WORKDIR /app

# Copiar dependencias de Node
COPY package*.json ./
RUN npm ci

# Copiar el resto del código y construir assets
COPY . .
RUN npm run build

# --- STAGE 2: PHP + Composer ---
FROM php:8.2-fpm-alpine AS php_builder
WORKDIR /app

# Instalar dependencias del sistema necesarias
RUN set -eux; \
    apk update; \
    apk add --no-cache --virtual .build-deps $PHPIZE_DEPS libzip-dev icu-dev sqlite-dev oniguruma-dev; \
    apk add --no-cache icu sqlite-libs git unzip zip bash; \
    docker-php-ext-configure intl; \
    docker-php-ext-install -j"$(nproc)" intl pdo_sqlite mbstring bcmath zip; \
    docker-php-ext-enable opcache; \
    apk del .build-deps

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copiar código + assets de Node
COPY --from=node_builder /app /app

# Instalar dependencias PHP sin dev (producción)
RUN composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction

# --- STAGE 3: Imagen final ---
FROM php:8.2-fpm-alpine
WORKDIR /var/www/html

# Copiar todo desde la etapa de PHP + Composer
COPY --from=php_builder /app /var/www/html

# Crear carpeta de SQLite y asegurar permisos correctos
RUN mkdir -p database \
    && touch database/database.sqlite \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

# Cambiar a usuario no root
USER www-data

# Configuración de Laravel y cache
RUN if [ ! -f .env ]; then cp .env.example .env; fi \
    && php artisan key:generate \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

EXPOSE 9000
