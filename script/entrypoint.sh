#!/bin/bash
set +e

chown -R www-data:www-data storage bootstrap/cache || true
chmod -R 775 storage bootstrap/cache || true

# Nettoyage
php artisan config:clear || true
php artisan cache:clear || true

# Migrations
echo "→ Migrations"
php artisan migrate:fresh --force || true

# Seeders
echo "→ Seeders"
php artisan db:seed --class="Database\Seeders\RolesTableSeeder" --force || true
php artisan db:seed --class="Database\Seeders\UsersTableSeeder" --force || true
php artisan db:seed --class="Database\Seeders\AdminUserSeeder" --force || true
php artisan db:seed --class="Database\Seeders\PatientsTableSeeder" --force || true
php artisan db:seed --class="Database\Seeders\ProduitsTableSeeder" --force || true
php artisan db:seed --class="Database\Seeders\OrdonancesTableSeeder" --force || true
php artisan db:seed --class="Database\Seeders\ChambresTableSeeder" --force || true

# FIX SEQUENCES POSTGRESQL (CRITIQUE)
echo "→ Resetting PG sequences..."
php artisan tinker --execute="foreach(DB::select(\"SELECT 'SELECT setval(' || quote_literal(pg_get_serial_sequence(quote_ident(table_name), quote_ident(column_name))) || ', coalesce(max(' || quote_ident(column_name) || '), 1)) FROM ' || quote_ident(table_name) AS query FROM information_schema.columns WHERE column_default LIKE 'nextval%' AND table_schema = 'public'\") as \$row) { if(\$row->query) DB::statement(\$row->query); }"

# Finalisation
php artisan permission:cache-reset || true
exec apache2-foreground
