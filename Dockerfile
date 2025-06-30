# Stage 1: Build assets and install dependencies
# Menggunakan PHP 8.2 agar konsisten dengan workflow CI Anda
FROM php:8.2-fpm-alpine AS builder

WORKDIR /var/www/html

# Install build-time system dependencies
# Menggunakan nama paket yang benar untuk Alpine
RUN apk add --no-cache \
    build-base \
    curl \
    unzip \
    zip \
    # Dependensi untuk ekstensi PHP
    libzip-dev \
    libpng-dev \
    jpeg-dev \
    freetype-dev \
    # Dependensi untuk Node.js & NPM
    nodejs \
    npm

# Install PHP extensions required for Composer and Laravel
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql zip bcmath opcache

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy dependency definitions
COPY package.json package-lock.json ./
# Install NPM dependencies and build assets
RUN npm install && npm run build

# Copy PHP dependency definitions
COPY composer.json composer.lock ./
# Install PHP dependencies
RUN composer install --no-interaction --no-plugins --no-scripts --prefer-dist --optimize-autoloader

# Copy the rest of the application code
COPY . .

# Clear cache and optimize
RUN composer dump-autoload --optimize && \
    php artisan optimize:clear && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache


# -----------------------------------------------------------------------------

# Stage 2: Final production image
# Menggunakan PHP 8.2 agar konsisten
FROM php:8.2-fpm-alpine

WORKDIR /var/www/html

# Install only necessary runtime system dependencies
RUN apk add --no-cache \
    nginx \
    # Dependensi runtime untuk ekstensi GD
    libzip \
    libpng \
    jpeg \
    freetype

# Install PHP extensions needed at runtime (HARUS SAMA DENGAN BUILDER)
RUN docker-php-ext-install pdo pdo_mysql zip bcmath opcache gd

# Copy application from builder stage
# Menyalin semua file aplikasi yang sudah di-build
COPY --from=builder /var/www/html .

# Copy Nginx, PHP-FPM, and startup script configurations
# Pastikan path ini benar di repository Anda
COPY .docker/nginx.conf /etc/nginx/nginx.conf
COPY .docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# Set permissions again for the final stage
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 8080

CMD ["start.sh"]
