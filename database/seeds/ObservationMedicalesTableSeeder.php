<?php

use Illuminate\Database\Seeder;

class ObservationMedicalesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('observation_medicales')->delete();
        
        \DB::table('observation_medicales')->insert(array (
            0 => 
            array (
                'id' => '1',
                'user_id' => '16',
                'patient_id' => '92',
                'observation' => 'patient à J 1 post opératoire d\'une TURP
constantes correctes, 
continuer traitement',
                'anesthesiste' => 'TENKE Christelle',
                'date' => '2019-10-09',
            ),
            1 => 
            array (
                'id' => '2',
                'user_id' => '16',
                'patient_id' => '225',
                'observation' => 'Ceftriaxone 2g /24H; Gentamycine 240 mg / 24 h pendant 48 heures
prévoir matériel de sondage transuréétral (sonde siliconée 18 ch)
prélèvement à faire : NFS , ECBU, CRP',
                'anesthesiste' => 'TENKE Christelle',
                'date' => '2019-11-18',
            ),
        ));
        
        
    }
}