# 1. Image PHP 8.2 avec Apache
FROM php:8.2-apache

# 2. Dépendances système
RUN apt-get update && apt-get install -y \
    libpq-dev libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    libicu-dev libzip-dev zlib1g-dev zip unzip git curl \
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

# 7. Installer Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# --- OPTIMISATION : COPIE AVEC DROITS DIRECTS ---
# On copie tout en assignant immédiatement le propriétaire www-data
COPY --chown=www-data:www-data . .

# 8. Dépendances PHP
# On nettoie le cache avant l'install pour éviter l'erreur IdeHelper
RUN rm -f bootstrap/cache/*.php
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs --no-scripts

# 9. Compilation des assets Vite
RUN npm install --legacy-peer-deps
RUN npm run build

# --- NETTOYAGE : Supprimer node_modules après le build pour alléger l'image ---
RUN rm -rf node_modules

# 10. Permissions ciblées (uniquement ce qui est nécessaire)
RUN mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache storage/logs bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# 11. Entrypoint
RUN chmod +x script/entrypoint.sh
ENTRYPOINT ["script/entrypoint.sh"]
