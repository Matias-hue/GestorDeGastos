# ===========================
# Imagen base PHP-FPM
# ===========================
FROM php:8.2-fpm

# ===========================
# Instalar dependencias del sistema y extensiones PHP
# ===========================
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    libzip-dev \
    libpq-dev \
    nginx \
    nodejs \
    npm \
    && docker-php-ext-install pdo pdo_pgsql pgsql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# ===========================
# Instalar Composer
# ===========================
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ===========================
# Directorio de trabajo
# ===========================
WORKDIR /var/www/html

# ===========================
# Copiar proyecto
# ===========================
COPY . .

# ===========================
# Instalar dependencias PHP
# ===========================
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# ===========================
# Instalar dependencias Node y construir assets
# ===========================
RUN npm install && npm run build

# ===========================
# Permisos correctos
# ===========================
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# ===========================
# Configuración NGINX
# ===========================
COPY docker/nginx/default.conf /etc/nginx/sites-available/default

# ===========================
# Exponer puerto HTTP
# ===========================
EXPOSE 80

# ===========================
# Comando por defecto
# ===========================
CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]
