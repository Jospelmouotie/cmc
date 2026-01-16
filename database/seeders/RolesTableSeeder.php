<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'id' => '1',
                'name' => 'ADMINISTRATEUR',
                'created_at' => '2019-09-26 16:48:37',
                'updated_at' => '2019-09-26 16:48:37',
            ),
            1 => 
            array (
                'id' => '2',
                'name' => 'MEDECIN',
                'created_at' => '2019-09-26 16:48:38',
                'updated_at' => '2019-09-26 16:48:38',
            ),
            2 => 
            array (
                'id' => '3',
                'name' => 'GESTIONNAIRE',
                'created_at' => '2019-09-26 16:48:38',
                'updated_at' => '2019-09-26 16:48:38',
            ),
            3 => 
            array (
                'id' => '4',
                'name' => 'INFIRMIER',
                'created_at' => '2019-09-26 16:48:38',
                'updated_at' => '2019-09-26 16:48:38',
            ),
            4 => 
            array (
                'id' => '5',
                'name' => 'LOGISTIQUE',
                'created_at' => '2019-09-26 16:48:38',
                'updated_at' => '2019-09-26 16:48:38',
            ),
            5 => 
            array (
                'id' => '6',
                'name' => 'SECRETAIRE',
                'created_at' => '2019-09-26 16:48:38',
                'updated_at' => '2019-09-26 16:48:38',
            ),
            6 => 
            array (
                'id' => '7',
                'name' => 'PHARMACIEN',
                'created_at' => '2019-09-26 16:48:39',
                'updated_at' => '2019-09-26 16:48:39',
            ),
            7 => 
            array (
                'id' => '8',
                'name' => 'QUALITE',
                'created_at' => '2019-09-26 16:48:39',
                'updated_at' => '2019-09-26 16:48:39',
            ),
            8 => 
            array (
                'id' => '9',
                'name' => 'COMPTABLE',
                'created_at' => '2019-09-26 16:48:39',
                'updated_at' => '2019-09-26 16:48:39',
            ),
        ));
        
        
    }
}