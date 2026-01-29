<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Patient;

class PatientsTableSeeder extends Seeder
{
    public function run()
    {
        // Nettoyage des tables (Ordre respectant les clés étrangères)
        DB::table('prescription_medicales')->delete();
        DB::table('fiche_prescription_medicales')->delete();
        DB::table('consultations')->delete();
        DB::table('dossiers')->delete();
        DB::table('patients')->delete();

        $medecins = User::whereIn('login', ['medecin1', 'medecin2', 'medecin3'])->get();

        if ($medecins->isEmpty()) {
            $this->command->error("Aucun médecin trouvé. Lancez d'abord l'AdminUserSeeder.");
            return;
        }

        foreach ($medecins as $medecin) {
            $this->command->info("Création des patients pour : {$medecin->login}");

            for ($i = 1; $i <= 5; $i++) {
                // Remplacement de Faker par des données statiques/aléatoires simples
                $numDossier = rand(100000, 999999);

                $patient = Patient::create([
                    'user_id'          => $medecin->id,
                    'numero_dossier'   => $numDossier,
                    'name'             => "NOM-" . $numDossier,
                    'prenom'           => "Prenom-" . $i,
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

                DB::table('dossiers')->insert([
                    'patient_id'     => $patient->id,
                    'portable_1'     => '06000000' . $i,
                    'sexe'           => ($i % 2 == 0) ? 'M' : 'F',
                    'date_naissance' => '1990-01-01',
                    'adresse'        => 'Adresse de test ' . $i,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);

                // ... (Le reste du code pour consultations et prescriptions reste identique)
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

                $ficheId = DB::table('fiche_prescription_medicales')->insertGetId([
                    'patient_id' => $patient->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

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
    }
}
