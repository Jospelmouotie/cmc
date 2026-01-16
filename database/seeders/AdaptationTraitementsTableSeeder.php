<?php

use Illuminate\Database\Seeder;

class AdaptationTraitementsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('adaptation_traitements')->delete();
        
        \DB::table('adaptation_traitements')->insert(array (
            0 => 
            array (
                'id' => '1',
                'user_id' => '4',
                'patient_id' => '20',
                'medicament_posologie_dosage' => 'paracetamol 500mg',
                'arret' => NULL,
                'poursuivre' => NULL,
                'continuer' => NULL,
                'j' => 'Ok',
                'j0' => NULL,
                'j1' => NULL,
                'j2' => NULL,
                'm' => NULL,
                'mi' => NULL,
                'n' => NULL,
                's' => NULL,
                'm1' => NULL,
                'mi1' => NULL,
                's1' => NULL,
                'n1' => NULL,
                'date' => '2019-09-25T12:00',
            ),
        ));
        
        
    }
}