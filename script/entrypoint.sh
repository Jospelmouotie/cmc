#!/bin/bash

# Supprimer les anciens caches pour forcer Laravel à relire config/app.php
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Re-générer la liste des services disponibles
php artisan package:discover --ansi

echo "Exécution des migrations..."
php artisan migrate --force

echo "Création du compte administrateur..."
php artisan db:seed --class=AdminUserSeeder --force

echo "Activation de la licence..."
php artisan nksoftcare:active-licence-key

echo "Démarrage d'Apache..."
exec apache2-foreground
