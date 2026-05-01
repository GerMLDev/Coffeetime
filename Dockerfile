FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git \
    libpng-dev libjpeg-dev libfreetype6-dev libwebp-dev \
    libonig-dev libxml2-dev default-mysql-client \
  && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
  && docker-php-ext-install gd pdo pdo_mysql zip bcmath \
  && a2enmod rewrite \
  && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf \
 && sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

EXPOSE 80
CMD ["apache2-foreground"]
