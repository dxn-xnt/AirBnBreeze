# --- Build Stage ---
FROM node:18 as nodebuild
WORKDIR /app

# Copy only Vite-related files first for caching
COPY package*.json ./
RUN npm install

# Copy rest of the app
COPY . .

# Build the frontend (Vite)
RUN npm run build

# --- PHP/Laravel Stage ---
FROM php:8.2-fpm

# System dependencies
RUN apt-get update && apt-get install -y \
    git unzip curl libpq-dev libzip-dev zip && \
    docker-php-ext-install pdo pdo_pgsql zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy Laravel app
COPY . .

# Copy Vite build from previous stage
COPY --from=nodebuild /app/public/build /var/www/public/build

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Laravel commands
RUN php artisan config:cache

# Permissions (adjust as needed)
RUN chown -R www-data:www-data /var/www

EXPOSE 9000
CMD ["php-fpm"]
