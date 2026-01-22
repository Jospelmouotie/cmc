# 1. Image PHP 8.2 avec Apache
FROM php:8.2-apache

# 2. Dépendances système
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libicu-dev \
    libzip-dev \
    zlib1g-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) pdo pdo_pgsql pgsql pdo_mysql gd intl zip

# --- Node.js pour Vite ---
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# 3. Apache Rewrite
RUN a2enmod rewrite

# 4. DocumentRoot
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 5. Workdir
WORKDIR /var/www/html

# 6. Copie du projet
COPY . .

# 7. Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 8. Dépendances PHP
RUN rm -f bootstrap/cache/services.php bootstrap/cache/packages.php
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs --no-scripts

# 9. Compilation des assets Vite
RUN npm install --legacy-peer-deps
RUN npm run build

# 10. Permissions
RUN mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache storage/logs bootstrap/cache
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 11. Entrypoint
RUN chmod +x /var/www/html/script/entrypoint.sh
ENTRYPOINT ["/var/www/html/script/entrypoint.sh"]
