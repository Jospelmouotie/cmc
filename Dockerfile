# 1. Image PHP 8.2 avec Apache
FROM php:8.2-apache

# 2. Installation de TOUTES les dépendances système en une seule fois
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

# 3. Activation du module rewrite d'Apache
RUN a2enmod rewrite

# 4. Configuration du DocumentRoot sur /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 5. Dossier de travail
WORKDIR /var/www/html

# 6. Copie de tout le projet
COPY . .

# 7. Installation de Composer et dépendances
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# Ajout de --ignore-platform-reqs pour éviter les blocages mineurs
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# 8. Gestion des permissions
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# 9. Préparation du script de démarrage
# Vérifie bien que ton fichier est dans le dossier /scripts/ dans ton projet
RUN chmod +x /var/www/html/scripts/entrypoint.sh
RUN ln -s /var/www/html/scripts/entrypoint.sh /usr/local/bin/entrypoint.sh

# 10. Port exposé
EXPOSE 80

# 11. Point d'entrée
ENTRYPOINT ["entrypoint.sh"]
