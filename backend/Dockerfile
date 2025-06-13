# Stage 1: Node.js para construir assets
FROM node:18-alpine as node-builder

WORKDIR /app

# Copy package files
COPY package*.json ./
COPY vite.config.js ./
COPY tailwind.config.js ./

# Install Node dependencies
RUN npm ci

# Copy source files needed for build
COPY resources/ ./resources/
COPY public/ ./public/

# Build assets
RUN npm run build

# Stage 2: PHP con extensiones necesarias
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libssl-dev \
    pkg-config \
    libcurl4-openssl-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql zip mbstring bcmath pcntl exif gd curl

# Install MongoDB extension
RUN pecl install mongodb && \
    docker-php-ext-enable mongodb

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy composer files
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --no-autoloader --no-dev

# Copy application files
COPY . /var/www/html

# Copy built assets from node-builder stage
COPY --from=node-builder /app/public/build ./public/build

# Complete composer installation
RUN composer dump-autoload --optimize

# Create required directories and set permissions
RUN mkdir -p /var/www/html/storage/framework/cache/data \
    /var/www/html/storage/framework/sessions \
    /var/www/html/storage/framework/views \
    /var/www/html/storage/logs \
    /var/www/html/mongodb_data

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public /var/www/html/mongodb_data
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Generate app key if .env exists
RUN if [ -f .env ]; then php artisan key:generate --force; fi

USER www-data

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
