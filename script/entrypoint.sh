#!/bin/bash

# Supprimer les anciens caches pour éviter les conflits de configuration
php artisan config:clear
php artisan cache:clear

# Indispensable après avoir renommé un dossier pour que Linux mette à jour les chemins
composer dump-autoload --optimize

echo "Exécution des migrations..."
# Rappel : Vérifie bien tes variables DB_HOST etc. sur Render si ça bloque ici
php artisan migrate --force

echo "Création du compte administrateur..."
# Appel de la classe avec son namespace complet
php artisan db:seed --class="Database\\Seeders\\AdminUserSeeder" --force

echo "Activation de la licence..."
php artisan nksoftcare:active-licence-key

echo "Démarrage d'Apache..."
exec apache2-foreground
