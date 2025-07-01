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

# Copy & build frontend assets
COPY package.json package-lock.json ./
RUN npm ci

# --- PERUBAHAN DEBUGGING DI SINI ---
# Terima build arguments dari file workflow .yml
ARG VITE_API_URL
ARG VITE_APP_NAME

# Jadikan sebagai environment variable
ENV VITE_API_URL=$VITE_API_URL
ENV VITE_APP_NAME=$VITE_APP_NAME

# LANGKAH DEBUG #1: Cetak semua environment variable yang ada untuk verifikasi
RUN echo "--- Printing Environment Variables ---" && printenv && echo "------------------------------------"

# LANGKAH DEBUG #2: Jalankan build dengan flag --debug untuk output yang lebih detail
# Tanda '--' di tengah penting untuk meneruskan flag ke vite, bukan ke npm
RUN NODE_OPTIONS=--max-old-space-size=8192 npm run build -- --debug
# --- AKHIR PERUBAHAN DEBUGGING ---

# Copy & install backend dependencies
COPY composer.json composer.lock ./
# ... sisa file sengaja di-comment untuk mempercepat debug, kita bisa kembalikan nanti
# RUN composer install --no-interaction --no-plugins --no-scripts --prefer-dist --optimize-autoloader
# COPY . .
# RUN composer dump-autoload --optimize && \
#     php artisan optimize:clear && \
#     php artisan config:cache && \
#     php artisan route:cache && \
#     php artisan view:cache
# RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Untuk sementara, kita tidak perlu stage 2
# [ ... Sisa Dockerfile di-comment out ... ]
