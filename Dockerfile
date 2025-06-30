# Stage 1: Build assets and install dependencies
FROM php:8.1-fpm-alpine AS builder

WORKDIR /var/www/html

# Install system dependencies
RUN apk add --no-cache \
    build-base shadow \
    curl \
    zip \
    unzip \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    oniguruma-dev \
    supervisor \
    nginx

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql zip bcmath opcache

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy dependency definitions
COPY composer.json composer.lock ./

# Install dependencies
RUN composer install --no-interaction --no-plugins --no-scripts --prefer-dist --optimize-autoloader

# Copy application code
COPY . .

# Generate optimized autoload files
RUN composer dump-autoload --optimize

# Generate application key (ini akan di-override oleh environment variable di Kubernetes)
RUN php artisan key:generate

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache


# Stage 2: Final production image
FROM php:8.1-fpm-alpine

WORKDIR /var/www/html

# Install only necessary runtime dependencies
RUN apk add --no-cache nginx libzip

# Install PHP extensions needed at runtime
RUN docker-php-ext-install pdo pdo_mysql zip

# Copy application from builder stage
COPY --from=builder /var/www/html .
COPY --from=builder /usr/bin/composer /usr/bin/composer

# Copy Nginx and PHP-FPM configurations
COPY .docker/nginx.conf /etc/nginx/nginx.conf
COPY .docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 8080

CMD ["start.sh"]