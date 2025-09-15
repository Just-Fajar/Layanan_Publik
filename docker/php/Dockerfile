FROM php:8.2-fpm-alpine

# System deps minimal untuk Laravel
RUN apk add --no-cache \
    git curl \
    libzip-dev \
    libxml2-dev \
    oniguruma-dev \
    zlib-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    $PHPIZE_DEPS

# Ekstensi PHP yang umum dipakai Laravel (tanpa Vite)
# Catatan: pdo/tokenizer/ctype/iconv sudah builtin di PHP 8.2
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j"$(nproc)" \
    pdo_mysql mbstring zip opcache xml gd
    
# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Opcache (mode dev: auto-reload)
RUN { \
  echo 'opcache.enable=1'; \
  echo 'opcache.enable_cli=1'; \
  echo 'opcache.validate_timestamps=1'; \
  echo 'opcache.revalidate_freq=0'; \
  echo 'opcache.memory_consumption=256'; \
  echo 'opcache.max_accelerated_files=20000'; \
} > /usr/local/etc/php/conf.d/opcache.ini

WORKDIR /var/www/html
