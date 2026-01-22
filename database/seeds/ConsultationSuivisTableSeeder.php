<?php

use Illuminate\Database\Seeder;

class ConsultationSuivisTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('consultation_suivis')->delete();
        
        \DB::table('consultation_suivis')->insert(array (
            0 => 
            array (
                'id' => '1',
                'patient_id' => '256',
                'user_id' => '16',
                'interrogatoire' => 'va mieux sous traitement; 
disparitions des lésions cutanées avec desquamation de la peau',
                'commentaire' => 'Bilan normal. 
surveillance
retour en consultation en cas de récidive.',
                'date_creation' => '2019-11-26',
            ),
        ));
        
        
    }
}