#!/bin/bash
set +e

chown -R www-data:www-data storage bootstrap/cache || true
chmod -R 775 storage bootstrap/cache || true

# 2️⃣ Nettoyage cache Laravel (non bloquant)
php artisan config:clear || true
php artisan cache:clear || true
php artisan view:clear || true

# 3️⃣ Autoloader (non bloquant)
composer dump-autoload --optimize || true

# 4️⃣ Migration (non bloquante)
echo "→ Migrations"
php artisan migrate:fresh  --force || true

# 5️⃣ Exécuter UNIQUEMENT les 3 seeders demandés
echo "→ Seeders spécifiques"

php artisan db:seed --class="Database\Seeders\RolesTableSeeder" --force || true
php artisan db:seed --class="Database\Seeders\AdminUserSeeder" --force || true
php artisan db:seed --class="Database\Seeders\UsersTableSeeder" --force ||
php artisan db:seed --class="Database\Seeders\PatientsTableSeeder" --force || true
php artisan db:seed --class="Database\Seeders\ProduitsTableSeeder" --force || true

# 6️⃣ Permission cache (si package présent)
php artisan permission:cache-reset || true

# 7️⃣ Licence (facultatif, non bloquant)
php artisan nksoftcare:active-licence-key || echo "Licence skip."

# 8️⃣ Lancer Apache (UN SEUL exec)
echo "=== Lancement Apache ==="
exec apache2-foreground
