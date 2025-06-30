# Stage 1: Build & Compile
# Menggunakan PHP 8.2 agar konsisten dengan workflow CI Anda
FROM php:8.2-fpm-alpine AS builder

WORKDIR /var/www/html

# Install build-time system dependencies
# Menambahkan gmp-dev untuk ekstensi gmp
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
    gmp-dev \
    # Dependensi untuk Node.js & NPM
    nodejs-lts \
    npm

# Install PHP extensions
# Menambahkan gmp
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql zip gmp bcmath opcache

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy & build frontend assets
COPY package.json package-lock.json ./
RUN npm ci
RUN NODE_OPTIONS=--max-old-space-size=4096 npm run build

# Copy & install backend dependencies
COPY composer.json composer.lock ./
RUN composer install --no-interaction --no-plugins --no-scripts --prefer-dist --optimize-autoloader

# Copy the rest of the application code
COPY . .

# Optimize Laravel untuk production
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

# Install only necessary RUNTIME system dependencies
# Menambahkan gmp
RUN apk add --no-cache \
    nginx \
    libzip \
    libpng \
    jpeg \
    freetype \
    gmp

# Copy ekstensi PHP yang sudah dikompilasi dari builder stage
COPY --from=builder /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/
COPY --from=builder /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/

# Copy aplikasi yang sudah di-build dari builder stage
COPY --from=builder /var/www/html .

# Copy Nginx dan startup script configurations
COPY .docker/nginx.conf /etc/nginx/nginx.conf
COPY .docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# Set permissions again for the final stage
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 8080

CMD ["start.sh"]
