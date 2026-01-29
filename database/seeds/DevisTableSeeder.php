<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DevisTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Nettoyage de la table
        DB::table('devis')->truncate();

        DB::table('devis')->insert([
            [
                'id' => 1,
                'user_id' => 25,
                'patient_id' => 126,
                'medecin_id' => 25,
                'nom' => 'POUR CYSTOSCOPIE + DEBIMETRIE URINAIRE',
                'code' => 'DEV-2019-001',
                'acces' => 'acte',
                'nbr_chambre' => 0,
                'nbr_visite' => 1,
                'nbr_ami_jour' => 0,
                'pu_chambre' => 30000,
                'pu_visite' => 15000,
                'pu_ami_jour' => 9000,
                'statut' => 'valide',
                'pourcentage_reduction' => 0,
                'montant_avant_reduction' => 100000,
                'montant_apres_reduction' => 100000,
                'commentaire_medecin' => 'Ancien devis importé',
                'created_at' => '2019-09-27 13:48:57',
                'updated_at' => '2019-10-21 14:23:06',
            ],
            [
                'id' => 2,
                'user_id' => 25,
                'patient_id' => 143,
                'medecin_id' => 25,
                'nom' => 'POUR URETEROSCOPIE SOUPLE LASER + MISE EN PLACE SONDE JJ',
                'code' => 'DEV-2019-002',
                'acces' => 'bloc',
                'nbr_chambre' => 2,
                'nbr_visite' => 2,
                'nbr_ami_jour' => 12,
                'pu_chambre' => 30000,
                'pu_visite' => 10000,
                'pu_ami_jour' => 9000,
                'statut' => 'valide',
                'pourcentage_reduction' => 0,
                'montant_avant_reduction' => 7317000,
                'montant_apres_reduction' => 7317000,
                'commentaire_medecin' => 'Urologie interventionnelle',
                'created_at' => '2019-09-27 15:40:25',
                'updated_at' => '2019-10-31 11:50:03',
            ],
            [
                'id' => 3,
                'user_id' => 25,
                'patient_id' => 156,
                'medecin_id' => 25,
                'nom' => 'RESECTION TRANSURETRALE DE LA PROSTATE',
                'code' => 'DEV-2019-003',
                'acces' => 'bloc',
                'nbr_chambre' => 3,
                'nbr_visite' => 2,
                'nbr_ami_jour' => 3,
                'pu_chambre' => 90000,
                'pu_visite' => 10000,
                'pu_ami_jour' => 9000,
                'statut' => 'en_attente',
                'pourcentage_reduction' => 0,
                'montant_avant_reduction' => 850000,
                'montant_apres_reduction' => 850000,
                'commentaire_medecin' => null,
                'created_at' => '2019-09-27 17:03:29',
                'updated_at' => '2019-11-28 16:53:43',
            ],
            [
                'id' => 4,
                'user_id' => 27,
                'patient_id' => 156,
                'medecin_id' => 25,
                'nom' => 'CYSTOSCOPIE + DECAILLOTAGE SOUS SEDATION',
                'code' => 'DEV-2019-004',
                'acces' => 'acte',
                'nbr_chambre' => 1,
                'nbr_visite' => 1,
                'nbr_ami_jour' => 1,
                'pu_chambre' => 30000,
                'pu_visite' => 10000,
                'pu_ami_jour' => 9000,
                'statut' => 'brouillon',
                'pourcentage_reduction' => 0,
                'montant_avant_reduction' => 500000,
                'montant_apres_reduction' => 500000,
                'commentaire_medecin' => 'Urgent',
                'created_at' => '2019-10-09 10:29:24',
                'updated_at' => '2019-11-28 16:55:40',
            ]
        ]);
    }
}
