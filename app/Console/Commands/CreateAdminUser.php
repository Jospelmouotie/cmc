<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'make:admin {login} {password}';
    protected $description = 'Crée un compte administrateur pour CMCUAPP';

    public function handle()
    {
        $login = $this->argument('login');
        $password = $this->argument('password');

        if (User::where('login', $login)->exists()) {
            $this->error("L'utilisateur '$login' existe déjà !");
            return;
        }

        // Création avec TOUS les champs obligatoires détectés dans votre modèle
        $user = User::create([
            'name'           => 'ADMIN',
            'prenom'         => 'Principal',
            'login'          => $login,
            'password'       => Hash::make($password),
            'telephone'      => '000000000',
            'sexe'           => 'M',
            'role_id'        => 1, // ADMINISTRATEUR
            'specialite'     => 'Informatique',
            'lieu_naissance' => 'Douala',         // Ajouté pour corriger l'erreur
            'date_naissance' => '1990-01-01',     // Ajouté par sécurité
            'onmc'           => '0000',           // Ajouté par sécurité (ordre des médecins)
        ]);

        $this->info("Succès : L'administrateur '$login' a été créé avec succès.");
    }
}
