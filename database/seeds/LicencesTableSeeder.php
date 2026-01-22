<?php

use Illuminate\Database\Seeder;

class LicencesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('licences')->delete();
        
        \DB::table('licences')->insert(array (
            0 => 
            array (
                'id' => '1',
                'license_key' => '',
                'client' => 'cmcuapp',
                'create_date' => '2020-10-07',
                'active_date' => '2020-10-07',
                'expire_date' => '2021-01-01',
            ),
            0 => 
            array (
                'id' => '1',
                'license_key' => '',
                'client' => 'cmcuapp',
                'create_date' => '2020-01-02',
                'active_date' => '2020-10-07',
                'expire_date' => '2021-01-01',
            ),
        ));
        
        
    }
}