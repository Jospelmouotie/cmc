<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $password = Hash::make('1234');

        $users = [
            ['login' => 'admin', 'name' => 'ADMIN', 'role_id' => 1, 'specialite' => null],
            ['login' => 'medecin1', 'name' => 'MARTIN', 'role_id' => 2, 'specialite' => 'Généraliste'],
            ['login' => 'medecin2', 'name' => 'DUBOIS', 'role_id' => 2, 'specialite' => 'Chirurgien'],
            ['login' => 'medecin3', 'name' => 'GARCIA', 'role_id' => 2, 'specialite' => 'Anesthésiste'],
            ['login' => 'infirmier1', 'name' => 'LEROY', 'role_id' => 4, 'specialite' => null],
            ['login' => 'infirmier2', 'name' => 'MOREAU', 'role_id' => 4, 'specialite' => null],
            ['login' => 'infirmier3', 'name' => 'PETIT', 'role_id' => 4, 'specialite' => null],
            ['login' => 'gestionnaire1', 'name' => 'ROUX', 'role_id' => 3, 'specialite' => null],
            ['login' => 'secretaire1', 'name' => 'BOULANGER', 'role_id' => 6, 'specialite' => null],
                  ['login' => 'pharmacien1', 'name' => 'paharmaco', 'role_id' => 7, 'specialite' => null],
        ];

        foreach ($users as $index => $user) {
            DB::table('users')->updateOrInsert(
                ['login' => $user['login']],
                [
                    'name'           => $user['name'],
                    'prenom'         => 'Personnel',
                    // On génère un numéro unique en ajoutant l'index (ex: 2022, 2023, 2024...)
                    'telephone'      => (2022 + $index),
                    'sexe'           => 'Masculin',
                    'lieu_naissance' => 'Douala',
                    'date_naissance' => '1990-01-01 00:00:00',
                    'onmc'           => $user['role_id'] == 2 ? 'ONMC-' . rand(1000, 9999) : null,
                    'password'       => $password,
                    'role_id'        => $user['role_id'],
                    'specialite'     => $user['specialite'],
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]
            );
        }
    }
    
}
