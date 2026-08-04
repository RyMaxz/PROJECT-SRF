FROM node:22-bookworm-slim AS node-assets

FROM php:8.3-fpm-bookworm AS builder

WORKDIR /var/www/html

ENV DEBIAN_FRONTEND=noninteractive \
    APP_ENV=production \
    APP_DEBUG=false

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        ca-certificates \
        curl \
        git \
        libfreetype6-dev \
        libicu-dev \
        libjpeg62-turbo-dev \
        libonig-dev \
        libpng-dev \
        libxml2-dev \
        libzip-dev \
        unzip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY --from=node-assets /usr/local /usr/local

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        bcmath \
        exif \
        gd \
        intl \
        mbstring \
        opcache \
        pcntl \
        pdo_mysql \
        zip

COPY composer.json composer.lock ./
RUN composer install --no-interaction --no-progress --prefer-dist --no-dev --no-scripts --no-autoloader

COPY package*.json ./
RUN npm ci --ignore-scripts

COPY . .

RUN composer dump-autoload --optimize --no-dev \
    && php artisan package:discover --ansi \
    && php artisan filament:upgrade --ansi \
    && npm run build

FROM php:8.3-fpm-bookworm

WORKDIR /var/www/html

ENV DEBIAN_FRONTEND=noninteractive \
    APP_ENV=production \
    APP_DEBUG=false

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        curl \
        gettext-base \
        libfreetype6-dev \
        libicu-dev \
        libjpeg62-turbo-dev \
        libonig-dev \
        libpng-dev \
        libxml2-dev \
        libzip-dev \
        nginx \
        supervisor \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        bcmath \
        exif \
        gd \
        intl \
        mbstring \
        opcache \
        pcntl \
        pdo_mysql \
        zip \
    && ln -s /usr/sbin/php-fpm8.3 /usr/local/bin/php-fpm \
    && { \
        echo 'opcache.enable=1'; \
        echo 'opcache.enable_cli=0'; \
        echo 'opcache.memory_consumption=128'; \
        echo 'opcache.max_accelerated_files=10000'; \
        echo 'opcache.validate_timestamps=0'; \
    } > /usr/local/etc/php/conf.d/opcache.ini

COPY --from=builder /var/www/html /var/www/html

COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
COPY nginx.conf /etc/nginx/nginx.conf
COPY supervisord.conf /etc/supervisor/conf.d/laravel.conf

RUN chmod +x /usr/local/bin/docker-entrypoint.sh \
    && rm -rf /var/www/html/node_modules \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public \
    && chmod -R ug+rwX /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public \
    && chmod -R 755 /var/www/html/public \
    && mkdir -p /run/php /run/nginx \
    && touch /run/nginx.pid

EXPOSE 8080

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
CMD ["supervisord", "-n", "-c", "/etc/supervisor/supervisord.conf"]
