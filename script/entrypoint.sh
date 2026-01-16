#!/bin/bash

# 1. Nettoyage radical des caches
rm -f bootstrap/cache/config.php
php artisan config:clear
php artisan cache:clear

# 2. Re-générer l'autoloader
composer dump-autoload --optimize

# 3. CRÉER LES TABLES (La migration doit être faite EN PREMIER)
echo "Création des tables dans la base de données..."
php artisan migrate --force

# 4. REMPLIR LES DONNÉES (Seulement après les migrations)
echo "Création du compte administrateur..."
php artisan db:seed --class="Database\\Seeders\\AdminUserSeeder" --force

# 5. ACTIONS ADDITIONNELLES
echo "Activation de la licence..."
php artisan nksoftcare:active-licence-key

# 6. LANCER LE SERVEUR
echo "Démarrage d'Apache..."
exec apache2-foreground
