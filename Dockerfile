# --- STAGE 1: Build de Node (Assets) ---
FROM node:20-alpine AS node_builder
WORKDIR /app

# Copiar package.json y package-lock.json
COPY package*.json ./

# Instalar dependencias de Node
RUN npm ci

# Copiar el resto del código
COPY . .

# Construir assets
RUN npm run build

# --- STAGE 2: PHP + Composer ---
FROM php:8.2-fpm-alpine AS php_builder
WORKDIR /app

# Instalar dependencias de sistema necesarias
RUN set -eux; \
    apk update; \
    apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        libzip-dev \
        icu-dev \
        sqlite-dev \
        oniguruma-dev; \
    apk add --no-cache \
        icu \
        sqlite-libs \
        git \
        unzip \
        zip \
        bash; \
    \
    # Instalar extensiones PHP
    docker-php-ext-configure intl; \
    docker-php-ext-install -j"$(nproc)" \
        intl \
        pdo_sqlite \
        pdo_mysql \
        mbstring \
        bcmath \
        zip; \
    docker-php-ext-enable opcache; \
    \
    # Limpiar dependencias de compilación
    apk del .build-deps

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copiar código + assets desde node_builder
COPY --from=node_builder /app /app

# Instalar dependencias PHP
RUN composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction

# --- STAGE 3: Imagen final ---
FROM php:8.2-fpm-alpine

WORKDIR /var/www/html

# Copiar PHP + Composer + código final
COPY --from=php_builder /app /var/www/html

# Ajustar permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Generar key y cache (puedes quitar migrate si no quieres migraciones automáticas)
USER www-data
RUN if [ ! -f .env ]; then cp .env.example .env; fi \
    && php artisan key:generate \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

EXPOSE 9000
