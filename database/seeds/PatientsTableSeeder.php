<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Patient;
use Faker\Factory;

class PatientsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();

        // 1. Récupération des médecins cibles
        $medecins = User::whereIn('login', ['medecin1', 'medecin2', 'medecin3'])->get();

        if ($medecins->isEmpty()) {
            $this->command->error("Aucun médecin trouvé avec les logins 'medecin1', 'medecin2' ou 'medecin3'.");
            return;
        }

        foreach ($medecins as $medecin) {
            $this->command->info("Création des patients pour : {$medecin->login}");

            for ($i = 1; $i <= 5; $i++) {

                // 2. Création du Patient (Table: patients)
                $patient = Patient::create([
                    'user_id'          => $medecin->id,
                    'numero_dossier'   => $faker->unique()->numberBetween(100000, 999999),
                    'name'             => strtoupper($faker->lastName),
                    'prenom'           => $faker->firstName,
                    'assurance'        => 'AXA',
                    'montant'          => 25000,
                    'assurancec'       => 5000,
                    'assurec'          => 20000,
                    'avance'           => 0,
                    'reste'            => 20000,
                    'motif'            => 'Consultation de suivi',
                    'medecin_r'        => $medecin->login,
                    'date_insertion'   => now()->toDateString(),
                ]);

                // 3. Création du Dossier (Table: dossiers)
                // Inclus 'sexe' et 'date_naissance' pour éviter les erreurs SQL
                DB::table('dossiers')->insert([
                    'patient_id'     => $patient->id,
                    'portable_1'     => $faker->phoneNumber,
                    'sexe'           => $faker->randomElement(['M', 'F']),
                    'date_naissance' => $faker->date('Y-m-d', '-30 years'),
                    'adresse'        => $faker->address,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);

                // 4. Création de la Consultation (Table: consultations)
                // Inclus 'proposition_therapeutique' requis par ta migration
                DB::table('consultations')->insert([
                    'patient_id'                => $patient->id,
                    'user_id'                   => $medecin->id,
                    'diagnostic'                => 'Patient en bonne progression.',
                    'interrogatoire'            => 'Pas de douleurs signalées.',
                    'medecin_r'                 => $medecin->login,
                    'proposition_therapeutique' => 'Continuer le traitement actuel.',
                    'proposition'               => 'Revoir dans 15 jours.',
                    'created_at'                => now(),
                    'updated_at'                => now(),
                ]);

                // 5. Création de la Fiche de Prescription (Table: fiche_prescription_medicales)
                // Note: user_id est retiré ici car absent de ta table de fiches
                $ficheId = DB::table('fiche_prescription_medicales')->insertGetId([
                    'patient_id' => $patient->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // 6. Création de la Prescription (Table: prescription_medicales)
                DB::table('prescription_medicales')->insert([
                    'fiche_prescription_medicale_id' => $ficheId,
                    'user_id'    => $medecin->id,
                    'medicament' => 'Paracétamol 1g',
                    'posologie'  => '1 comprimé 3 fois par jour',
                    'voie'       => 'Orale',
                    'horaire'    => '8h - 14h - 20h',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $this->command->info("Seed terminé ! Toutes les relations sont établies.");
    }
}
