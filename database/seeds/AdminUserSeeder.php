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
        // On utilise updateOrInsert pour éviter les erreurs si tu lances le seeder plusieurs fois
        DB::table('users')->updateOrInsert(
            ['login' => 'admin'], // Cherche si cet utilisateur existe déjà
            [
                'name'           => 'ADMINISTRATEUR',
                'prenom'         => 'CMC',
                'telephone'      => '000000000',
                'sexe'           => 'Masculin',
                'lieu_naissance' => 'Non spécifié',
                'date_naissance' => '1990-01-01 00:00:00',
                'password'       => Hash::make('admin123'),
                'role_id'        => 1, // 1 = ADMINISTRATEUR selon ton RolesTableSeeder
                'specialite'     => 'Admin',
                'onmc'           => '0000',
                'created_at'     => now(),
                'updated_at'     => now(),
            ]
        );
        DB::table('licences')->insert([
    'active_date' => now(),
    'expiration_date' => now()->addYears(10),
    'is_active' => true,
    // ajoute les autres colonnes requises par ta table
]);
    }
}
