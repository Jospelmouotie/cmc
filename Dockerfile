# 1. Image PHP 8.2 avec Apache
FROM php:8.2-apache

# 2. Installation des dépendances système et PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libpng-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_pgsql pgsql

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

# 7. Installation de Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader

# 8. Gestion des permissions
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# 9. Préparation du script de démarrage
# On s'assure que le script est copié et exécutable
RUN chmod +x /var/www/html/scripts/entrypoint.sh
RUN cp /var/www/html/scripts/entrypoint.sh /usr/local/bin/entrypoint.sh

# 10. Port exposé
EXPOSE 80

# 11. Point d'entrée (Lancement des migrations + Apache)
ENTRYPOINT ["entrypoint.sh"]
