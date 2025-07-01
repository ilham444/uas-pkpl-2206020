# =================================================================
# TAHAP 1: BUILDER - Untuk menginstall dependency Composer
# =================================================================
# Menggunakan image PHP 8.2 CLI (Command Line) sebagai dasar
FROM php:8.2-cli as builder

# Set direktori kerja di dalam container
WORKDIR /app

# Install ekstensi PHP yang umum dibutuhkan oleh Laravel
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-install \
    pdo_mysql \
    zip \
    bcmath \
    gd

# Install Composer (cara resmi dan direkomendasikan)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# [OPTIMASI CACHE] Salin hanya file composer terlebih dahulu
# Jika file ini tidak berubah, Docker tidak akan menjalankan ulang 'composer install'
COPY composer.json composer.lock ./

# Install dependency tanpa paket development dan optimalkan autoloader
RUN composer install --no-interaction --no-plugins --no-scripts --no-dev --prefer-dist --optimize-autoloader

# [PERBAIKAN] Salin semua file aplikasi ke dalam image
# Langkah ini yang sebelumnya hilang, menyebabkan error '.env.example' tidak ditemukan
COPY . .

# [PERBAIKAN] Buat file .env dari contoh agar perintah artisan tidak error
RUN cp .env.example .env

# Generate application key
RUN php artisan key:generate

# Optimasi untuk production
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache


# =================================================================
# TAHAP 2: FINAL - Image akhir yang akan dijalankan
# =================================================================
# Menggunakan image PHP-FPM yang ringan (Alpine) untuk production
FROM php:8.2-fpm-alpine

# Set direktori kerja
WORKDIR /var/www/html

# Install ekstensi yang dibutuhkan oleh aplikasi saat berjalan
RUN docker-php-ext-install pdo_mysql

# Salin file aplikasi yang sudah di-build dari tahap 'builder'
# Ini termasuk folder /vendor dan semua file yang sudah dioptimasi
COPY --from=builder /app /var/www/html

# Atur kepemilikan file agar web server (Nginx/Apache) bisa menulis ke folder storage
# Pengguna www-data adalah user default untuk Nginx dan Apache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port 9000 untuk komunikasi dengan Nginx melalui PHP-FPM
EXPOSE 9000

# Perintah default untuk menjalankan container
CMD ["php-fpm"]
