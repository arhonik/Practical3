FROM php:8.0-fpm

RUN usermod -u 1000 www-data

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN export CFLAGS="$PHP_CFLAGS" CPPFLAGS="$PHP_CPPFLAGS" LDFLAGS="$PHP_LDFLAGS" && \
    apt-get update && apt-get install -y \
    libmagickwand-dev \
    git \
    wget \
    zip \
    unzip \
    cron \
    openssl \
    dpkg-dev \
    libmcrypt-dev \
    zlib1g-dev \
    libjpeg-dev \
    libonig-dev \
    libsodium-dev \
    libxml2-dev \
    libssl-dev \
    libpq-dev \
    libbz2-dev \
    libpng-dev \
    libzip-dev \
    procps \
    nano

RUN pecl install imagick && \
    docker-php-ext-enable imagick

RUN docker-php-ext-install opcache && \
    docker-php-ext-install zip && \
    docker-php-ext-install bz2 && \
    docker-php-ext-install iconv && \
    docker-php-ext-install calendar && \
    docker-php-ext-install dom && \
    docker-php-ext-install gd && \
    docker-php-ext-install mbstring && \
    docker-php-ext-install sodium && \
    docker-php-ext-install mysqli && \
    docker-php-ext-install pdo pdo_mysql && \
    docker-php-ext-install soap && \
    docker-php-ext-install sockets

RUN rm -rf /var/lib/apt/lists/*

RUN chown www-data:1000 /var/www

VOLUME ["/var/www"]

WORKDIR /var/www/public

EXPOSE 9000

CMD ["php-fpm"]
