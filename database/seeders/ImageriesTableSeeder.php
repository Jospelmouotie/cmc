<?php

use Illuminate\Database\Seeder;

class ImageriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('imageries')->delete();
        
        \DB::table('imageries')->insert(array (
            0 => 
            array (
                'id' => '1',
                'user_id' => '13',
                'patient_id' => '202',
                'radiographie' => '',
                'echographie' => '',
                'scanner' => 'Abdomen-pelvis,Calcul rein gauche',
                'irm' => '',
                'scintigraphie' => '',
                'autre' => '',
                'created_at' => '2019-11-07 17:12:51',
                'updated_at' => '2019-11-07 17:12:51',
            ),
            1 => 
            array (
                'id' => '2',
                'user_id' => '16',
                'patient_id' => '255',
                'radiographie' => '',
                'echographie' => 'Reins et vessie,',
                'scanner' => '',
                'irm' => '',
                'scintigraphie' => '',
                'autre' => '',
                'created_at' => '2019-11-18 09:16:49',
                'updated_at' => '2019-11-18 09:16:49',
            ),
            2 => 
            array (
                'id' => '3',
                'user_id' => '16',
                'patient_id' => '259',
                'radiographie' => '',
                'echographie' => 'Reins et vessie,Scrotum,',
                'scanner' => '',
                'irm' => '',
                'scintigraphie' => '',
                'autre' => '',
                'created_at' => '2019-11-22 09:20:01',
                'updated_at' => '2019-11-22 09:20:01',
            ),
        ));
        
        
    }
}