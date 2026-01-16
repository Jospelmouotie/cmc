<?php

use Illuminate\Database\Seeder;

class ExamensTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('examens')->delete();
        
        \DB::table('examens')->insert(array (
            0 => 
            array (
                'id' => '18',
                'patient_id' => '104',
                'type' => 'Echographie',
                'image' => '1573214446.jpg',
                'created_at' => '2019-11-08 13:00:46',
                'updated_at' => '2019-11-08 13:00:46',
            ),
            1 => 
            array (
                'id' => '19',
                'patient_id' => '104',
                'type' => 'Echographie',
                'image' => '1573214726.jpg',
                'created_at' => '2019-11-08 13:05:26',
                'updated_at' => '2019-11-08 13:05:26',
            ),
            2 => 
            array (
                'id' => '20',
                'patient_id' => '112',
                'type' => 'Echographie',
                'image' => '1573218842.jpg',
                'created_at' => '2019-11-08 14:14:02',
                'updated_at' => '2019-11-08 14:14:02',
            ),
            3 => 
            array (
                'id' => '21',
                'patient_id' => '285',
                'type' => 'biopsie',
                'image' => '1574955865.PNG',
                'created_at' => '2019-11-28 16:44:25',
                'updated_at' => '2019-11-28 16:44:25',
            ),
        ));
        
        
    }
}