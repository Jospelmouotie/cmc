#!/bin/bash
#!/bin/bash
# Re-générer la liste des services (vu qu'on a utilisé --no-scripts)
php artisan package:discover --ansi
php artisan config:clear
php artisan cache:clear

echo "Exécution des migrations..."
php artisan migrate --force

# AJOUT DE CETTE LIGNE :
echo "Création du compte administrateur..."
php artisan db:seed --class=AdminUserSeeder --force

echo "Activation de la licence..."
php artisan nksoftcare:active-licence-key

echo "Démarrage d'Apache..."
exec apache2-foreground

#!/bin/bash

