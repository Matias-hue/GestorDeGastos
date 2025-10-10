# ===========================
# Imagen base con PHP
# ===========================
FROM php:8.2-cli

# ===========================
# Instalar dependencias del sistema y extensiones de PHP
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
    mariadb-client \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# ===========================
# Instalar Composer
# ===========================
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ===========================
# Instalar Node.js y npm (para Vite)
# ===========================
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest

# ===========================
# Establecer directorio de trabajo
# ===========================
WORKDIR /var/www/html

# ===========================
# Copiar archivos del proyecto
# ===========================
COPY . .

# ===========================
# Instalar dependencias de PHP
# ===========================
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# ===========================
# Instalar dependencias de Node.js y construir assets
# ===========================
RUN npm install
RUN npm run build

# ===========================
# Dar permisos correctos
# ===========================
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# ===========================
# Exponer puerto HTTP
# ===========================
EXPOSE 8080

# ===========================
# Comando por defecto para servir Laravel
# ===========================
CMD php artisan serve --host=0.0.0.0 --port=8080
