# Stage 1: Build & Compile (Menggunakan Debian untuk keandalan)
FROM php:8.2-fpm AS builder

# Set non-interactive mode untuk apt-get
ENV DEBIAN_FRONTEND=noninteractive

WORKDIR /var/www/html

# Install build-time system dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    build-essential curl unzip zip libzip-dev libpng-dev libjpeg-dev libfreetype6-dev libgmp-dev ca-certificates gnupg \
    && mkdir -p /etc/apt/keyrings \
    && curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg \
    && NODE_MAJOR=18 \
    && echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_$NODE_MAJOR.x nodistro main" | tee /etc/apt/sources.list.d/nodesource.list \
    && apt-get update && apt-get install -y nodejs && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) pdo pdo_mysql gd zip gmp bcmath opcache

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy package files terlebih dahulu untuk optimasi cache
COPY package.json package-lock.json ./
RUN npm ci

# Copy SEMUA sisa file aplikasi
COPY . .

# Terima dan set environment variables untuk build frontend
ARG VITE_API_URL
ARG VITE_APP_NAME
ENV VITE_API_URL=$VITE_API_URL
ENV VITE_APP_NAME=$VITE_APP_NAME

# Jalankan build frontend
RUN NODE_OPTIONS=--max-old-space-size=8192 npm run build

# Install dependensi backend
RUN composer install --no-interaction --no-plugins --no-scripts --prefer-dist --optimize-autoloader

# --- PERBAIKAN FINAL UNTUK ARTISAN ---
# 1. Buat file .env dari contoh agar Artisan tidak error karena koneksi DB
RUN cp .env.example .env

# 2. Generate kunci aplikasi karena .env yang baru dibuat belum ada kuncinya
RUN php artisan key:generate
# --- AKHIR PERBAIKAN FINAL ---

# SEKARANG, jalankan optimasi Laravel
RUN php artisan optimize:clear && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache


# -----------------------------------------------------------------------------

# Stage 2: Final production image (Tetap menggunakan Debian)
FROM php:8.2-fpm

ENV DEBIAN_FRONTEND=noninteractive
WORKDIR /var/www/html

# Install only necessary RUNTIME system dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    nginx libzip4 libpng16-16 libjpeg62-turbo libfreetype6 libgmp10 \
    && rm -rf /var/lib/apt/lists/*

# Copy ekstensi PHP yang sudah dikompilasi dari builder stage
COPY --from=builder /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/
COPY --from=builder /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/

# Copy aplikasi yang sudah di-build dari builder stage
COPY --from=builder /var/www/html .

# Copy Nginx dan startup script configurations
COPY .docker/nginx.conf /etc/nginx/sites-available/default
COPY .docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# Set permissions again for the final stage
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

CMD ["start.sh"]
