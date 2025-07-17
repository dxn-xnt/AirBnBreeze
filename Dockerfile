# --- Build Vite Assets ---
FROM node:18 as nodebuild
WORKDIR /app

# Install Node dependencies
COPY package*.json vite.config.js ./
RUN npm install

# Copy frontend assets
COPY resources/ resources/
COPY public/ public/
COPY vite.config.js .

# Run Vite build (will generate public/build/manifest.json)
RUN npm run build

# --- PHP + Laravel Stage ---
FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip curl libpq-dev libzip-dev zip && \
    docker-php-ext-install pdo pdo_pgsql zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy Laravel source (excluding node_modules, etc.)
COPY . .

# Copy only the Vite build output
COPY --from=nodebuild /app/public/build /var/www/public/build

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Laravel configuration
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Set correct permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage /var/www/bootstrap/cache

# Expose port (optional for Docker local run)
EXPOSE 8000

# Start Laravel's development server (for production, use PHP-FPM + Nginx)
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
