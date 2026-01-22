<?php

use Illuminate\Database\Seeder;

class FicheInterventionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('fiche_interventions')->delete();
        
        \DB::table('fiche_interventions')->insert(array (
            0 => 
            array (
                'id' => '1',
                'user_id' => '13',
                'patient_id' => '104',
                'nom_patient' => 'CHATUE',
                'prenom_patient' => 'Gaston',
                'sexe_patient' => 'Masculin',
                'date_naiss_patient' => '1961-10-01',
                'portable_patient' => '698482572',
                'type_intervention' => 'Biopsies prostatiques sous sédation',
                'dure_intervention' => '00:30',
                'position_patient' => 'Lithotomie,',
                'decubitus' => '',
                'laterale' => '',
                'lombotomie' => '',
                'date_intervention' => '2019-11-07',
                'medecin' => 'NJINOU NGNINKEU Bertin',
                'aide_op' => 'Non',
                'hospitalisation' => NULL,
                'ambulatoire' => 'Ambulatoire',
                'anesthesie' => 'AG',
                'recommendation' => NULL,
                'created_at' => '2019-11-07 13:10:23',
                'updated_at' => '2019-11-07 13:10:23',
            ),
        ));
        
        
    }
}