<?php

use Illuminate\Database\Seeder;

class CompteRenduBlocOperatoiresTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('compte_rendu_bloc_operatoires')->delete();
        
        \DB::table('compte_rendu_bloc_operatoires')->insert(array (
            0 => 
            array (
                'id' => '1',
                'patient_id' => '104',
                'chirurgien' => 'NJINOU NGNINKEU Bertin',
                'aide_op' => 'DJOUFANG Rodrigue',
                'anesthesiste' => 'TENKE Christelle',
                'infirmier_anesthesiste' => 'TOMDIO PRISCA',
                'date_intervention' => '2019-11-07',
                'dure_intervention' => '00:30',
                'compte_rendu_o' => 'Patient en position de la taille
Asepsie classique
Echographe BK et sonde biplan
Echographie transrectale retrouvant des zones hypo-échogènes au niveau des lobes droit et gauche
Vésicules séminales normales
Prostate évaluée à 98 cc
Biopsies prostatiques en sextant au niveau des lobes droit et gauche (2 pots)',
                'indication_operatoire' => 'Augmentation anormale des PSA à 8.8 ng/ml avec ratio à 35%
IRM avec zones PIRADS 4',
                'resultat_histo' => 'En cours',
                'suite_operatoire' => 'Simples',
                'traitement_propose' => 'Poursuite Ofloxacine 200 mg 2x/j pendant 2 jours',
                'soins' => 'Bonne hydratation et mictions régulières',
                'date_e' => '2019-11-07',
                'date_s' => '2019-11-07',
                'type_e' => 'Ambulatoire',
                'type_s' => 'Retour au domicile',
                'conclusion' => 'Echographie transrectale et Biopsies échoguidées de la prostate

Histologie en cours
RDV en consultation dans 15 jours',
                'created_at' => '2019-11-07 13:16:32',
                'updated_at' => '2019-11-08 10:23:43',
                'type_intervention' => 'Biopsies prostatiques sous sédation',
                'titre_intervention' => 'Biopsies prostatiques sous sédation',
                'proposition_suivi' => '',
            ),
        ));
        
        
    }
}