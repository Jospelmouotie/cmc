<?php

use Illuminate\Database\Seeder;

class SqliteSequenceTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sqlite_sequence')->delete();
        
        \DB::table('sqlite_sequence')->insert(array (
            0 => 
            array (
                'name' => 'migrations',
                'seq' => '68',
            ),
            1 => 
            array (
                'name' => 'roles',
                'seq' => '9',
            ),
            2 => 
            array (
                'name' => 'users',
                'seq' => '33',
            ),
            3 => 
            array (
                'name' => 'chambres',
                'seq' => '11',
            ),
            4 => 
            array (
                'name' => 'produits',
                'seq' => '163',
            ),
            5 => 
            array (
                'name' => 'patients',
                'seq' => '291',
            ),
            6 => 
            array (
                'name' => 'facture_consultations',
                'seq' => '249',
            ),
            7 => 
            array (
                'name' => 'events',
                'seq' => '11',
            ),
            8 => 
            array (
                'name' => 'dossiers',
                'seq' => '85',
            ),
            9 => 
            array (
                'name' => 'parametres',
                'seq' => '76',
            ),
            10 => 
            array (
                'name' => 'adaptation_traitements',
                'seq' => '1',
            ),
            11 => 
            array (
                'name' => 'ordonances',
                'seq' => '14',
            ),
            12 => 
            array (
                'name' => 'prescriptions',
                'seq' => '9',
            ),
            13 => 
            array (
                'name' => 'devis',
                'seq' => '6',
            ),
            14 => 
            array (
                'name' => 'clients',
                'seq' => '214',
            ),
            15 => 
            array (
                'name' => 'facture_clients',
                'seq' => '219',
            ),
            16 => 
            array (
                'name' => 'consultation_anesthesistes',
                'seq' => '1',
            ),
            17 => 
            array (
                'name' => 'consultations',
                'seq' => '48',
            ),
            18 => 
            array (
                'name' => 'observation_medicales',
                'seq' => '2',
            ),
            19 => 
            array (
                'name' => 'licences',
                'seq' => '1',
            ),
            20 => 
            array (
                'name' => 'fiche_consommables',
                'seq' => '188',
            ),
            21 => 
            array (
                'name' => 'surveillance_rapproche_parametres',
                'seq' => '62',
            ),
            22 => 
            array (
                'name' => 'prescription_medicales',
                'seq' => '12',
            ),
            23 => 
            array (
                'name' => 'fiche_interventions',
                'seq' => '1',
            ),
            24 => 
            array (
                'name' => 'compte_rendu_bloc_operatoires',
                'seq' => '3',
            ),
            25 => 
            array (
                'name' => 'imageries',
                'seq' => '3',
            ),
            26 => 
            array (
                'name' => 'soins_infirmiers',
                'seq' => '14',
            ),
            27 => 
            array (
                'name' => 'examens',
                'seq' => '21',
            ),
            28 => 
            array (
                'name' => 'consultation_suivis',
                'seq' => '1',
            ),
        ));
        
        
    }
}