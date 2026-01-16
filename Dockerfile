# 1. Image PHP 8.2 avec Apache
FROM php:8.2-apache

# 2. Dépendances système
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libicu-dev \
    zlib1g-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    pdo \
    pdo_pgsql \
    pgsql \
    pdo_mysql \
    gd \
    intl

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

# 7. Installation de Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 8. Installation des dépendances (UNE SEULE FOIS)
# On force la suppression du cache des services pour éviter l'erreur IdeHelper
RUN rm -f bootstrap/cache/services.php bootstrap/cache/packages.php
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs --no-scripts
# 9. Permissions
# On crée les dossiers au cas où ils manquent, puis on change les droits
RUN mkdir -p storage bootstrap/cache storage/framework/sessions storage/framework/views storage/framework/cache
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache
# 10. Entrypoint
RUN chmod +x /var/www/html/scripts/entrypoint.sh
RUN ln -sf /var/www/html/scripts/entrypoint.sh /usr/local/bin/entrypoint.sh

EXPOSE 80

ENTRYPOINT ["entrypoint.sh"]
