<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
  public function run()
{
    // 1. Création de l'admin
    DB::table('users')->updateOrInsert(
        ['login' => 'admin'],
        [
            'name'           => 'ADMINISTRATEUR',
            'prenom'         => 'CMC',
            'telephone'      => '000000000',
            'sexe'           => 'Masculin',
            'lieu_naissance' => 'Non spécifié',
            'date_naissance' => '1990-01-01 00:00:00',
            'password'       => Hash::make('admin123'),
            'role_id'        => 1,
            'specialite'     => 'Admin',
            'onmc'           => '0000',
            'created_at'     => now(),
            'updated_at'     => now(),
        ]
    );

    // 2. Correction de la Licence (doit matcher ta migration)
    DB::table('licences')->updateOrInsert(
        ['id' => 1],
        [
            'license_key' => 'FREE-TRIAL-2026',
            'client'      => 'CMCU-RENDER',
            'create_date' => now(),
            'active_date' => now(),
            'expire_date' => now()->addYears(10), // Correction du nom de la colonne
        ]
    );
}
}
