<?php

use Illuminate\Database\Seeder;

class ChambresTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('chambres')->delete();
        
        \DB::table('chambres')->insert(array (
            0 => 
            array (
                'id' => '1',
                'user_id' => '5',
                'numero' => '101 Lit 1',
                'categorie' => 'CLASSIQUE',
                'patient' => 'null',
                'prix' => '50000',
                'jour' => 'null',
                'statut' => 'libre',
                'created_at' => '2019-09-26 16:48:47',
                'updated_at' => '2019-09-26 17:49:23',
            ),
            1 => 
            array (
                'id' => '2',
                'user_id' => '5',
                'numero' => '101 Lit 2',
                'categorie' => 'CLASSIQUE',
                'patient' => 'null',
                'prix' => '50000',
                'jour' => NULL,
                'statut' => 'libre',
                'created_at' => '2019-09-26 16:48:48',
                'updated_at' => '2019-09-26 16:48:48',
            ),
            2 => 
            array (
                'id' => '3',
                'user_id' => '5',
                'numero' => '102 Lit 1',
                'categorie' => 'CLASSIQUE',
                'patient' => 'null',
                'prix' => '50000',
                'jour' => NULL,
                'statut' => 'libre',
                'created_at' => '2019-09-26 16:48:48',
                'updated_at' => '2019-09-26 16:48:48',
            ),
            3 => 
            array (
                'id' => '4',
                'user_id' => '5',
                'numero' => '102 Lit 2',
                'categorie' => 'CLASSIQUE',
                'patient' => 'null',
                'prix' => '50000',
                'jour' => NULL,
                'statut' => 'libre',
                'created_at' => '2019-09-26 16:48:48',
                'updated_at' => '2019-09-26 16:48:48',
            ),
            4 => 
            array (
                'id' => '5',
                'user_id' => '5',
                'numero' => '103 Lit 1',
                'categorie' => 'CLASSIQUE',
                'patient' => 'null',
                'prix' => '50000',
                'jour' => NULL,
                'statut' => 'libre',
                'created_at' => '2019-09-26 16:48:48',
                'updated_at' => '2019-09-26 16:48:48',
            ),
            5 => 
            array (
                'id' => '6',
                'user_id' => '5',
                'numero' => '103 Lit 2',
                'categorie' => 'CLASSIQUE',
                'patient' => 'null',
                'prix' => '50000',
                'jour' => NULL,
                'statut' => 'libre',
                'created_at' => '2019-09-26 16:48:48',
                'updated_at' => '2019-09-26 16:48:48',
            ),
            6 => 
            array (
                'id' => '7',
                'user_id' => '5',
                'numero' => '104 Lit 1',
                'categorie' => 'CLASSIQUE',
                'patient' => 'null',
                'prix' => '50000',
                'jour' => NULL,
                'statut' => 'libre',
                'created_at' => '2019-09-26 16:48:49',
                'updated_at' => '2019-09-26 16:48:49',
            ),
            7 => 
            array (
                'id' => '8',
                'user_id' => '5',
                'numero' => '104 Lit 2',
                'categorie' => 'CLASSIQUE',
                'patient' => 'null',
                'prix' => '50000',
                'jour' => NULL,
                'statut' => 'libre',
                'created_at' => '2019-09-26 16:48:49',
                'updated_at' => '2019-09-26 16:48:49',
            ),
            8 => 
            array (
                'id' => '9',
                'user_id' => '5',
                'numero' => '105',
                'categorie' => 'VIP',
                'patient' => 'null',
                'prix' => '100000',
                'jour' => NULL,
                'statut' => 'libre',
                'created_at' => '2019-09-26 16:48:49',
                'updated_at' => '2019-09-26 16:48:49',
            ),
            9 => 
            array (
                'id' => '10',
                'user_id' => '5',
                'numero' => 'BLOC 1',
                'categorie' => 'BLOC OPERATOIRE',
                'patient' => 'null',
                'prix' => NULL,
                'jour' => NULL,
                'statut' => 'libre',
                'created_at' => '2019-09-26 16:48:49',
                'updated_at' => '2019-09-26 16:48:49',
            ),
            10 => 
            array (
                'id' => '11',
                'user_id' => '5',
                'numero' => 'BLOC 2',
                'categorie' => 'BLOC OPERATOIRE',
                'patient' => 'null',
                'prix' => NULL,
                'jour' => NULL,
                'statut' => 'libre',
                'created_at' => '2019-09-26 16:48:49',
                'updated_at' => '2019-09-26 16:48:49',
            ),
        ));
        
        
    }
}