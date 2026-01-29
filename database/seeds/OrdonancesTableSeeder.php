<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Patient;
use App\Models\Ordonance;

class OrdonancesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Détecter le driver de la base de données
        $driver = DB::getDriverName();

        // Nettoyage de la table selon le driver
        if ($driver === 'pgsql') {
            // PostgreSQL : Vide la table, réinitialise l'ID et gère les relations
            DB::statement('TRUNCATE TABLE ordonances RESTART IDENTITY CASCADE;');
        } else {
            // MySQL : Désactive les clés étrangères et vide la table
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table('ordonances')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        // Récupérer tous les patients existants
        $patients = Patient::all();

        if ($patients->isEmpty()) {
            $this->command->error("Aucun patient trouvé. Lancez d'abord le PatientsTableSeeder.");
            return;
        }

        $this->command->info("Génération des ordonnances pour " . $patients->count() . " patients...");

        foreach ($patients as $patient) {
            // Liste de médicaments pour varier
            $listeMedicaments = [
                ['nom' => 'GRISEOFULINE, PEVARYL crème', 'desc' => '1 cp matin et soir, 1 application après la douche', 'qte' => '1 boite, 1 tube'],
                ['nom' => 'PARACETAMOL 1g', 'desc' => '1 cp toutes les 8 heures en cas de douleur', 'qte' => '2 boites'],
                ['nom' => 'XATRAL LP 10 mg', 'desc' => '1 cp le soir après le repas', 'qte' => '1 boite'],
                ['nom' => 'AMOXICILLINE 1g', 'desc' => '1 cp matin et soir pendant 7 jours', 'qte' => '2 boites'],
            ];

            // Sélectionner un médicament au hasard
            $randomMed = $listeMedicaments[array_rand($listeMedicaments)];

            Ordonance::create([
                'user_id'     => $patient->user_id ?? 1, // Fallback sur ID 1 si user_id est null
                'patient_id'  => $patient->id,
                'description' => $randomMed['desc'],
                'medicament'  => $randomMed['nom'],
                'quantite'    => $randomMed['qte'],
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }

        $this->command->info("Ordonnances créées avec succès !");
    }
}
