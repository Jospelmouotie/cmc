<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // On crée l'utilisateur seulement s'il n'existe pas déjà
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'], // Remplace par ton email
            [
                'name' => 'admin',
                'login' => 'admin',
                'password' => Hash::make('admin'), // CHANGE-LE !
                'role' => 'admin', // Vérifhie le nom de la colonne rôle dans ta table users
            ]
        );
    }
}
