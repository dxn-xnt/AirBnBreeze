# --- Build Stage ---
FROM node:18 as nodebuild
WORKDIR /app

# Copy only Vite-related files first for caching
COPY package*.json ./
RUN npm install

# Copy rest of the app
COPY . .
RUN npm run build

# --- PHP/Laravel Stage ---
FROM php:8.2-cli

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

# Laravel config
RUN php artisan config:cache

# Set permissions
RUN chown -R www-data:www-data /var/www

# Expose public port (important for Render)
EXPOSE 8000

# Start Laravel dev server (for production you should use nginx, but this works fine for testing)
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
