<?php

use Illuminate\Database\Seeder;

class FicheConsommablesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('fiche_consommables')->delete();
        
        \DB::table('fiche_consommables')->insert(array (
            0 => 
            array (
                'id' => '1',
                'user_id' => '8',
                'patient_id' => '21',
                'consommable' => 'gants de soins',
                'jour' => '3',
                'nuit' => '2',
                'date' => '2019-10-29',
            ),
            1 => 
            array (
                'id' => '2',
                'user_id' => '8',
                'patient_id' => '21',
                'consommable' => 'kt  G20',
                'jour' => NULL,
                'nuit' => NULL,
                'date' => '2019-10-30',
            ),
            2 => 
            array (
                'id' => '3',
                'user_id' => '12',
                'patient_id' => '190',
                'consommable' => 'Carbocaine 200mg/20ml',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2000-01-01',
            ),
            3 => 
            array (
                'id' => '4',
                'user_id' => '12',
                'patient_id' => '198',
                'consommable' => 'gants de soins',
                'jour' => '3',
                'nuit' => NULL,
                'date' => '2019-11-07',
            ),
            4 => 
            array (
                'id' => '5',
                'user_id' => '12',
                'patient_id' => '198',
                'consommable' => 'catherter G18',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-07',
            ),
            5 => 
            array (
                'id' => '6',
                'user_id' => '12',
                'patient_id' => '198',
                'consommable' => 'catherter G20',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-07',
            ),
            6 => 
            array (
                'id' => '7',
                'user_id' => '12',
                'patient_id' => '198',
                'consommable' => 'bandelette a glycemie',
                'jour' => '2',
                'nuit' => NULL,
                'date' => '2019-11-07',
            ),
            7 => 
            array (
                'id' => '8',
                'user_id' => '12',
                'patient_id' => '198',
                'consommable' => 'seringue 10cc',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-07',
            ),
            8 => 
            array (
                'id' => '9',
                'user_id' => '12',
                'patient_id' => '198',
                'consommable' => 'sale 250cc',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-07',
            ),
            9 => 
            array (
                'id' => '10',
                'user_id' => '12',
                'patient_id' => '198',
                'consommable' => 'perfuseur',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-07',
            ),
            10 => 
            array (
                'id' => '11',
                'user_id' => '12',
                'patient_id' => '198',
                'consommable' => 'prolongateur',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-07',
            ),
            11 => 
            array (
                'id' => '12',
                'user_id' => '12',
                'patient_id' => '198',
                'consommable' => 'robinet',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-07',
            ),
            12 => 
            array (
                'id' => '13',
                'user_id' => '12',
                'patient_id' => '198',
                'consommable' => 'cefotaxime 1g',
                'jour' => '4',
                'nuit' => NULL,
                'date' => '2019-11-07',
            ),
            13 => 
            array (
                'id' => '14',
                'user_id' => '4',
                'patient_id' => '112',
                'consommable' => 'nefopam',
                'jour' => '3',
                'nuit' => NULL,
                'date' => '2019-11-07',
            ),
            14 => 
            array (
                'id' => '15',
                'user_id' => '4',
                'patient_id' => '112',
                'consommable' => 'sale 250cc',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-07',
            ),
            15 => 
            array (
                'id' => '16',
                'user_id' => '4',
                'patient_id' => '112',
                'consommable' => 'seringue 10cc',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-07',
            ),
            16 => 
            array (
                'id' => '17',
                'user_id' => '4',
                'patient_id' => '112',
                'consommable' => 'gant soin',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-07',
            ),
            17 => 
            array (
                'id' => '18',
                'user_id' => '6',
                'patient_id' => '112',
                'consommable' => 'NaCl 250ml',
                'jour' => '0',
                'nuit' => '1',
                'date' => '2019-11-08',
            ),
            18 => 
            array (
                'id' => '19',
                'user_id' => '6',
                'patient_id' => '112',
                'consommable' => 'cefttiaxone 1g',
                'jour' => NULL,
                'nuit' => '1',
                'date' => '2019-11-08',
            ),
            19 => 
            array (
                'id' => '20',
                'user_id' => '6',
                'patient_id' => '112',
                'consommable' => 'gant de soins',
                'jour' => NULL,
                'nuit' => '3',
                'date' => '2019-11-08',
            ),
            20 => 
            array (
                'id' => '21',
                'user_id' => '6',
                'patient_id' => '198',
                'consommable' => 'gant de soins',
                'jour' => NULL,
                'nuit' => '2',
                'date' => '2019-11-08',
            ),
            21 => 
            array (
                'id' => '22',
                'user_id' => '12',
                'patient_id' => '204',
                'consommable' => 'catherter G20',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-08',
            ),
            22 => 
            array (
                'id' => '23',
                'user_id' => '12',
                'patient_id' => '204',
                'consommable' => 'gant de soins',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-08',
            ),
            23 => 
            array (
                'id' => '24',
                'user_id' => '12',
                'patient_id' => '85',
                'consommable' => 'catherter G18',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-08',
            ),
            24 => 
            array (
                'id' => '25',
                'user_id' => '12',
                'patient_id' => '85',
                'consommable' => 'gants de soins',
                'jour' => '2',
                'nuit' => NULL,
                'date' => '2019-11-08',
            ),
            25 => 
            array (
                'id' => '26',
                'user_id' => '12',
                'patient_id' => '111',
                'consommable' => 'catherter G20',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-08',
            ),
            26 => 
            array (
                'id' => '27',
                'user_id' => '12',
                'patient_id' => '111',
                'consommable' => 'gants de soins',
                'jour' => '2',
                'nuit' => NULL,
                'date' => '2019-11-08',
            ),
            27 => 
            array (
                'id' => '28',
                'user_id' => '12',
                'patient_id' => '112',
                'consommable' => 'Paracetamol 1000mg/100ml',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-08',
            ),
            28 => 
            array (
                'id' => '29',
                'user_id' => '12',
                'patient_id' => '112',
                'consommable' => 'Nefropan 20mg/2ml',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-08',
            ),
            29 => 
            array (
                'id' => '30',
                'user_id' => '12',
                'patient_id' => '112',
                'consommable' => 'LOVENOX 4000 IE-ui',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-08',
            ),
            30 => 
            array (
                'id' => '31',
                'user_id' => '12',
                'patient_id' => '198',
                'consommable' => 'gants de soins',
                'jour' => '2',
                'nuit' => NULL,
                'date' => '2019-11-08',
            ),
            31 => 
            array (
                'id' => '32',
                'user_id' => '12',
                'patient_id' => '211',
                'consommable' => 'catherter G20',
                'jour' => '2',
                'nuit' => NULL,
                'date' => '2019-11-08',
            ),
            32 => 
            array (
                'id' => '33',
                'user_id' => '12',
                'patient_id' => '211',
                'consommable' => 'gants de soins',
                'jour' => '2',
                'nuit' => NULL,
                'date' => '2019-11-08',
            ),
            33 => 
            array (
                'id' => '34',
                'user_id' => '3',
                'patient_id' => '198',
                'consommable' => 'poche a urine 2 l',
                'jour' => NULL,
                'nuit' => '1',
                'date' => '2019-11-08',
            ),
            34 => 
            array (
                'id' => '35',
                'user_id' => '3',
                'patient_id' => '198',
                'consommable' => 'gants de soins',
                'jour' => NULL,
                'nuit' => '4',
                'date' => '2019-11-08',
            ),
            35 => 
            array (
                'id' => '36',
                'user_id' => '3',
                'patient_id' => '198',
                'consommable' => 'paracetamol 500mg cp',
                'jour' => NULL,
                'nuit' => '2',
                'date' => '2019-11-08',
            ),
            36 => 
            array (
                'id' => '37',
                'user_id' => '3',
                'patient_id' => '112',
                'consommable' => 'PARACETAMOL 500MG CP',
                'jour' => NULL,
                'nuit' => '2',
                'date' => '2019-11-08',
            ),
            37 => 
            array (
                'id' => '38',
                'user_id' => '3',
                'patient_id' => '112',
                'consommable' => 'GANTS SOINS',
                'jour' => NULL,
                'nuit' => '2',
                'date' => '2019-11-08',
            ),
            38 => 
            array (
                'id' => '39',
                'user_id' => '3',
                'patient_id' => '211',
                'consommable' => 'catheter 18g',
                'jour' => NULL,
                'nuit' => '2',
                'date' => '2019-11-08',
            ),
            39 => 
            array (
                'id' => '40',
                'user_id' => '3',
                'patient_id' => '211',
                'consommable' => 'catheter 20g',
                'jour' => NULL,
                'nuit' => '1',
                'date' => '2019-11-08',
            ),
            40 => 
            array (
                'id' => '41',
                'user_id' => '3',
                'patient_id' => '211',
                'consommable' => 'gants soins',
                'jour' => NULL,
                'nuit' => '1',
                'date' => '2019-11-08',
            ),
            41 => 
            array (
                'id' => '42',
                'user_id' => '3',
                'patient_id' => '204',
                'consommable' => 'gants soins',
                'jour' => NULL,
                'nuit' => '4',
                'date' => '2019-11-08',
            ),
            42 => 
            array (
                'id' => '43',
                'user_id' => '3',
                'patient_id' => '204',
                'consommable' => 'lyrica 50',
                'jour' => NULL,
                'nuit' => '1',
                'date' => '2019-11-09',
            ),
            43 => 
            array (
                'id' => '44',
                'user_id' => '3',
                'patient_id' => '204',
                'consommable' => 'gants  soins',
                'jour' => NULL,
                'nuit' => '2',
                'date' => '2019-11-09',
            ),
            44 => 
            array (
                'id' => '45',
                'user_id' => '3',
                'patient_id' => '198',
                'consommable' => 'bandelette a gly',
                'jour' => NULL,
                'nuit' => '1',
                'date' => '2019-11-09',
            ),
            45 => 
            array (
                'id' => '46',
                'user_id' => '3',
                'patient_id' => '198',
                'consommable' => 'seringue 10',
                'jour' => NULL,
                'nuit' => '1',
                'date' => '2019-11-09',
            ),
            46 => 
            array (
                'id' => '47',
                'user_id' => '3',
                'patient_id' => '198',
                'consommable' => 'gants de soins',
                'jour' => NULL,
                'nuit' => '3',
                'date' => '2019-11-09',
            ),
            47 => 
            array (
                'id' => '48',
                'user_id' => '3',
                'patient_id' => '211',
                'consommable' => 'SERIGUE 10 CC',
                'jour' => NULL,
                'nuit' => '1',
                'date' => '2019-11-09',
            ),
            48 => 
            array (
                'id' => '49',
                'user_id' => '3',
                'patient_id' => '211',
                'consommable' => 'GANTS SOINS',
                'jour' => NULL,
                'nuit' => '2',
                'date' => '2019-11-09',
            ),
            49 => 
            array (
                'id' => '50',
                'user_id' => '3',
                'patient_id' => '112',
                'consommable' => 'bandelette a gly',
                'jour' => NULL,
                'nuit' => '2',
                'date' => '2019-11-09',
            ),
            50 => 
            array (
                'id' => '51',
                'user_id' => '3',
                'patient_id' => '112',
                'consommable' => 'seringue 10',
                'jour' => NULL,
                'nuit' => '1',
                'date' => '2019-11-09',
            ),
            51 => 
            array (
                'id' => '52',
                'user_id' => '3',
                'patient_id' => '112',
                'consommable' => 'gants de soin',
                'jour' => NULL,
                'nuit' => '4',
                'date' => '2019-11-09',
            ),
            52 => 
            array (
                'id' => '53',
                'user_id' => '12',
                'patient_id' => '112',
                'consommable' => 'LOVENOX IE-IU',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-09',
            ),
            53 => 
            array (
                'id' => '54',
                'user_id' => '12',
                'patient_id' => '112',
                'consommable' => 'gants de soins',
                'jour' => '2',
                'nuit' => NULL,
                'date' => '2019-11-09',
            ),
            54 => 
            array (
                'id' => '55',
                'user_id' => '12',
                'patient_id' => '204',
                'consommable' => 'perfalgan 1g',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-09',
            ),
            55 => 
            array (
                'id' => '56',
                'user_id' => '12',
                'patient_id' => '204',
                'consommable' => 'nefopam 20mg',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-09',
            ),
            56 => 
            array (
                'id' => '57',
                'user_id' => '12',
                'patient_id' => '204',
                'consommable' => 'ketoprofene 100mg',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-09',
            ),
            57 => 
            array (
                'id' => '58',
                'user_id' => '12',
                'patient_id' => '204',
                'consommable' => 'gants de soins',
                'jour' => '2',
                'nuit' => NULL,
                'date' => '2019-11-09',
            ),
            58 => 
            array (
                'id' => '59',
                'user_id' => '12',
                'patient_id' => '198',
                'consommable' => 'lovenox IE-IU',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-09',
            ),
            59 => 
            array (
                'id' => '60',
                'user_id' => '12',
                'patient_id' => '198',
                'consommable' => 'GANTS DE SOINS',
                'jour' => '2',
                'nuit' => NULL,
                'date' => '2019-11-09',
            ),
            60 => 
            array (
                'id' => '61',
                'user_id' => '12',
                'patient_id' => '198',
                'consommable' => 'perfalgan 1g',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-09',
            ),
            61 => 
            array (
                'id' => '62',
                'user_id' => '3',
                'patient_id' => '198',
                'consommable' => 'poche a urine 2 l',
                'jour' => NULL,
                'nuit' => '1',
                'date' => '2019-11-09',
            ),
            62 => 
            array (
                'id' => '63',
                'user_id' => '3',
                'patient_id' => '198',
                'consommable' => 'gants de soins',
                'jour' => NULL,
                'nuit' => '1',
                'date' => '2019-11-09',
            ),
            63 => 
            array (
                'id' => '64',
                'user_id' => '3',
                'patient_id' => '198',
                'consommable' => 'LYRICA 25MG CP',
                'jour' => NULL,
                'nuit' => '2',
                'date' => '2019-11-09',
            ),
            64 => 
            array (
                'id' => '65',
                'user_id' => '3',
                'patient_id' => '204',
                'consommable' => 'ketoprofene 100mg cp',
                'jour' => NULL,
                'nuit' => '1',
                'date' => '2019-11-10',
            ),
            65 => 
            array (
                'id' => '66',
                'user_id' => '3',
                'patient_id' => '204',
                'consommable' => 'gants de soins',
                'jour' => NULL,
                'nuit' => '2',
                'date' => '2019-11-10',
            ),
            66 => 
            array (
                'id' => '67',
                'user_id' => '3',
                'patient_id' => '112',
                'consommable' => 'bandelette a gly',
                'jour' => NULL,
                'nuit' => '1',
                'date' => '2019-11-10',
            ),
            67 => 
            array (
                'id' => '68',
                'user_id' => '3',
                'patient_id' => '112',
                'consommable' => 'seringue 5 cc',
                'jour' => NULL,
                'nuit' => '1',
                'date' => '2019-11-10',
            ),
            68 => 
            array (
                'id' => '69',
                'user_id' => '3',
                'patient_id' => '112',
                'consommable' => 'gants de soins',
                'jour' => NULL,
                'nuit' => '2',
                'date' => '2019-11-10',
            ),
            69 => 
            array (
                'id' => '70',
                'user_id' => '3',
                'patient_id' => '198',
                'consommable' => 'bandelettze a gly',
                'jour' => NULL,
                'nuit' => '1',
                'date' => '2019-11-10',
            ),
            70 => 
            array (
                'id' => '71',
                'user_id' => '3',
                'patient_id' => '198',
                'consommable' => 'gants de soins',
                'jour' => NULL,
                'nuit' => '2',
                'date' => '2019-11-10',
            ),
            71 => 
            array (
                'id' => '72',
                'user_id' => '3',
                'patient_id' => '198',
                'consommable' => 'seringue 5 cc',
                'jour' => NULL,
                'nuit' => '1',
                'date' => '2019-11-10',
            ),
            72 => 
            array (
                'id' => '73',
                'user_id' => '3',
                'patient_id' => '198',
                'consommable' => 'DITROPAN 5MG CP',
                'jour' => NULL,
                'nuit' => '2',
                'date' => '2019-11-10',
            ),
            73 => 
            array (
                'id' => '74',
                'user_id' => '6',
                'patient_id' => '112',
                'consommable' => 'MACROGOL 4000',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-10',
            ),
            74 => 
            array (
                'id' => '75',
                'user_id' => '6',
                'patient_id' => '112',
                'consommable' => 'GANTS DE SOINS',
                'jour' => '3',
                'nuit' => NULL,
                'date' => '2019-11-10',
            ),
            75 => 
            array (
                'id' => '76',
                'user_id' => '6',
                'patient_id' => '198',
                'consommable' => 'SERINGUE 60ML',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-10',
            ),
            76 => 
            array (
                'id' => '77',
                'user_id' => '6',
                'patient_id' => '198',
                'consommable' => 'Gants de soins',
                'jour' => '3',
                'nuit' => NULL,
                'date' => '2019-11-10',
            ),
            77 => 
            array (
                'id' => '78',
                'user_id' => '6',
                'patient_id' => '104',
                'consommable' => 'NaCl 0.9% 250ml',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-10',
            ),
            78 => 
            array (
                'id' => '79',
                'user_id' => '6',
                'patient_id' => '104',
                'consommable' => 'gant de soins',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-10',
            ),
            79 => 
            array (
                'id' => '80',
                'user_id' => '6',
                'patient_id' => '104',
                'consommable' => 'ceftriaxone 1g',
                'jour' => '2',
                'nuit' => NULL,
                'date' => '2019-11-10',
            ),
            80 => 
            array (
                'id' => '81',
                'user_id' => '6',
                'patient_id' => '104',
                'consommable' => 'Gentamycine 80mg',
                'jour' => '2',
                'nuit' => NULL,
                'date' => '2019-11-10',
            ),
            81 => 
            array (
                'id' => '82',
                'user_id' => '6',
                'patient_id' => '104',
                'consommable' => 'paracetamol 500mg comprimés',
                'jour' => '2',
                'nuit' => NULL,
                'date' => '2019-11-10',
            ),
            82 => 
            array (
                'id' => '83',
                'user_id' => '6',
                'patient_id' => '204',
                'consommable' => 'Gants de soins',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-10',
            ),
            83 => 
            array (
                'id' => '84',
                'user_id' => '6',
                'patient_id' => '112',
                'consommable' => 'lovenox 0.4',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-10',
            ),
            84 => 
            array (
                'id' => '85',
                'user_id' => '6',
                'patient_id' => '112',
                'consommable' => 'lyrica 25mg',
                'jour' => '2',
                'nuit' => NULL,
                'date' => '2019-11-10',
            ),
            85 => 
            array (
                'id' => '86',
                'user_id' => '6',
                'patient_id' => '198',
                'consommable' => 'LOVENOX 0.4 ui',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-10',
            ),
            86 => 
            array (
                'id' => '87',
                'user_id' => '6',
                'patient_id' => '204',
                'consommable' => 'macrogol 10g',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-10',
            ),
            87 => 
            array (
                'id' => '88',
                'user_id' => '6',
                'patient_id' => '112',
                'consommable' => 'Lyrica 25mg',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-10',
            ),
            88 => 
            array (
                'id' => '89',
                'user_id' => '6',
                'patient_id' => '104',
                'consommable' => 'paracetamol inj',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-10',
            ),
            89 => 
            array (
                'id' => '90',
                'user_id' => '6',
                'patient_id' => '198',
                'consommable' => 'GANT DE SOINS',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-10',
            ),
            90 => 
            array (
                'id' => '91',
                'user_id' => '8',
                'patient_id' => '204',
                'consommable' => 'ketoprofene 100mg cp',
                'jour' => NULL,
                'nuit' => '02',
                'date' => '2019-11-10',
            ),
            91 => 
            array (
                'id' => '92',
                'user_id' => '8',
                'patient_id' => '204',
                'consommable' => 'para 500 mg cp',
                'jour' => NULL,
                'nuit' => '04',
                'date' => '2019-11-10',
            ),
            92 => 
            array (
                'id' => '93',
                'user_id' => '8',
                'patient_id' => '204',
                'consommable' => 'gants de soins',
                'jour' => NULL,
                'nuit' => '02',
                'date' => '2019-11-10',
            ),
            93 => 
            array (
                'id' => '94',
                'user_id' => '8',
                'patient_id' => '204',
                'consommable' => 'macrogol 10g',
                'jour' => NULL,
                'nuit' => '01',
                'date' => '2019-11-11',
            ),
            94 => 
            array (
                'id' => '95',
                'user_id' => '8',
                'patient_id' => '112',
                'consommable' => 'bandelette a gly',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-11',
            ),
            95 => 
            array (
                'id' => '96',
                'user_id' => '8',
                'patient_id' => '112',
                'consommable' => 'ditropan 5mg cp',
                'jour' => '2',
                'nuit' => NULL,
                'date' => '2019-11-11',
            ),
            96 => 
            array (
                'id' => '97',
                'user_id' => '8',
                'patient_id' => '112',
                'consommable' => 'gants de soins',
                'jour' => '2',
                'nuit' => NULL,
                'date' => '2019-11-11',
            ),
            97 => 
            array (
                'id' => '98',
                'user_id' => '8',
                'patient_id' => '198',
                'consommable' => 'DITROPAN 5MG CP',
                'jour' => '02',
                'nuit' => NULL,
                'date' => '2019-11-11',
            ),
            98 => 
            array (
                'id' => '99',
                'user_id' => '8',
                'patient_id' => '198',
                'consommable' => 'gants de soins',
                'jour' => '02',
                'nuit' => NULL,
                'date' => '2019-11-11',
            ),
            99 => 
            array (
                'id' => '100',
                'user_id' => '8',
                'patient_id' => '104',
                'consommable' => 'ceftriaxone 1g',
                'jour' => '2',
                'nuit' => NULL,
                'date' => '2019-11-11',
            ),
            100 => 
            array (
                'id' => '101',
                'user_id' => '8',
                'patient_id' => '104',
                'consommable' => 'NaCl 0.9% 250ml',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-11',
            ),
            101 => 
            array (
                'id' => '102',
                'user_id' => '5',
                'patient_id' => '79',
                'consommable' => 'catheter 20 g',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-11',
            ),
            102 => 
            array (
                'id' => '103',
                'user_id' => '5',
                'patient_id' => '79',
                'consommable' => 'gants de soins',
                'jour' => '2',
                'nuit' => NULL,
                'date' => '2019-11-11',
            ),
            103 => 
            array (
                'id' => '104',
                'user_id' => '5',
                'patient_id' => '104',
                'consommable' => 'ceftriaxone 2g',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-11',
            ),
            104 => 
            array (
                'id' => '105',
                'user_id' => '5',
                'patient_id' => '104',
                'consommable' => 'gentamycine 80 mg',
                'jour' => '2',
                'nuit' => NULL,
                'date' => '2019-11-11',
            ),
            105 => 
            array (
                'id' => '106',
                'user_id' => '5',
                'patient_id' => '104',
                'consommable' => 'NaCl 0.9% 250ml',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-11',
            ),
            106 => 
            array (
                'id' => '107',
                'user_id' => '5',
                'patient_id' => '104',
                'consommable' => 'seringue 10cc',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-11',
            ),
            107 => 
            array (
                'id' => '108',
                'user_id' => '5',
                'patient_id' => '104',
                'consommable' => 'Paracetamol 1000mg/100ml inj',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-11',
            ),
            108 => 
            array (
                'id' => '109',
                'user_id' => '5',
                'patient_id' => '104',
                'consommable' => 'gants de soins',
                'jour' => '2',
                'nuit' => NULL,
                'date' => '2019-11-11',
            ),
            109 => 
            array (
                'id' => '110',
                'user_id' => '5',
                'patient_id' => '104',
                'consommable' => 'arthéméter 80 inj',
                'jour' => '3',
                'nuit' => NULL,
                'date' => '2019-11-11',
            ),
            110 => 
            array (
                'id' => '111',
                'user_id' => '5',
                'patient_id' => '104',
                'consommable' => 'perfuseur',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-11',
            ),
            111 => 
            array (
                'id' => '112',
                'user_id' => '5',
                'patient_id' => '112',
                'consommable' => 'poche à urine 2l',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-11',
            ),
            112 => 
            array (
                'id' => '113',
                'user_id' => '5',
                'patient_id' => '112',
                'consommable' => 'gants de soins',
                'jour' => '4',
                'nuit' => NULL,
                'date' => '2019-11-11',
            ),
            113 => 
            array (
                'id' => '114',
                'user_id' => '5',
                'patient_id' => '112',
                'consommable' => 'lame de bistouri N° 15',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-11',
            ),
            114 => 
            array (
                'id' => '115',
                'user_id' => '4',
                'patient_id' => '140',
                'consommable' => 'cather18g',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-14',
            ),
            115 => 
            array (
                'id' => '116',
                'user_id' => '4',
                'patient_id' => '140',
                'consommable' => 'gants de soin',
                'jour' => '2',
                'nuit' => NULL,
                'date' => '2019-11-14',
            ),
            116 => 
            array (
                'id' => '117',
                'user_id' => '4',
                'patient_id' => '140',
                'consommable' => 'perfuseur',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-14',
            ),
            117 => 
            array (
                'id' => '118',
                'user_id' => '4',
                'patient_id' => '140',
                'consommable' => 'sale 250cc',
                'jour' => '01',
                'nuit' => NULL,
                'date' => '2019-11-14',
            ),
            118 => 
            array (
                'id' => '119',
                'user_id' => '4',
                'patient_id' => '247',
                'consommable' => 'catheter 18g',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-14',
            ),
            119 => 
            array (
                'id' => '120',
                'user_id' => '4',
                'patient_id' => '247',
                'consommable' => 'gants de soins',
                'jour' => '2',
                'nuit' => NULL,
                'date' => '2019-11-14',
            ),
            120 => 
            array (
                'id' => '121',
                'user_id' => '4',
                'patient_id' => '247',
                'consommable' => 'serum salé 500cc',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-14',
            ),
            121 => 
            array (
                'id' => '122',
                'user_id' => '4',
                'patient_id' => '247',
                'consommable' => 'perfuseur',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-14',
            ),
            122 => 
            array (
                'id' => '123',
                'user_id' => '4',
                'patient_id' => '247',
                'consommable' => 'bandelette à glycémie',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-14',
            ),
            123 => 
            array (
                'id' => '124',
                'user_id' => '4',
                'patient_id' => '247',
                'consommable' => 'séringue 10cc',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-14',
            ),
            124 => 
            array (
                'id' => '125',
                'user_id' => '5',
                'patient_id' => '247',
                'consommable' => 'exacyl 500 inj',
                'jour' => '2',
                'nuit' => NULL,
                'date' => '2019-11-14',
            ),
            125 => 
            array (
                'id' => '126',
                'user_id' => '3',
                'patient_id' => '140',
                'consommable' => 'gants de soins',
                'jour' => NULL,
                'nuit' => '1',
                'date' => '2019-11-14',
            ),
            126 => 
            array (
                'id' => '127',
                'user_id' => '5',
                'patient_id' => '247',
                'consommable' => 'serum salé 250cc',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-15',
            ),
            127 => 
            array (
                'id' => '128',
                'user_id' => '5',
                'patient_id' => '247',
                'consommable' => 'gentamycine 80mg',
                'jour' => '6',
                'nuit' => NULL,
                'date' => '2019-11-15',
            ),
            128 => 
            array (
                'id' => '129',
                'user_id' => '5',
                'patient_id' => '247',
                'consommable' => 'gants de soins',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-15',
            ),
            129 => 
            array (
                'id' => '130',
                'user_id' => '12',
                'patient_id' => '247',
                'consommable' => 'gant de soins',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-15',
            ),
            130 => 
            array (
                'id' => '131',
                'user_id' => '12',
                'patient_id' => '247',
                'consommable' => 'seringue 5cc',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-15',
            ),
            131 => 
            array (
                'id' => '132',
                'user_id' => '12',
                'patient_id' => '247',
                'consommable' => 'tube rouge',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-15',
            ),
            132 => 
            array (
                'id' => '133',
                'user_id' => '12',
                'patient_id' => '247',
                'consommable' => 'SERINGUE 10CC',
                'jour' => NULL,
                'nuit' => '1',
                'date' => '2019-11-15',
            ),
            133 => 
            array (
                'id' => '134',
                'user_id' => '12',
                'patient_id' => '247',
                'consommable' => 'GANTS DE SOINS',
                'jour' => NULL,
                'nuit' => '2',
                'date' => '2019-11-15',
            ),
            134 => 
            array (
                'id' => '135',
                'user_id' => '5',
                'patient_id' => '225',
                'consommable' => 'kt 20g',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-18',
            ),
            135 => 
            array (
                'id' => '136',
                'user_id' => '5',
                'patient_id' => '225',
                'consommable' => 'Gants de soins',
                'jour' => '3',
                'nuit' => NULL,
                'date' => '2019-11-18',
            ),
            136 => 
            array (
                'id' => '137',
                'user_id' => '5',
                'patient_id' => '225',
                'consommable' => 'Genta 80 inj',
                'jour' => '3',
                'nuit' => NULL,
                'date' => '2019-11-18',
            ),
            137 => 
            array (
                'id' => '138',
                'user_id' => '5',
                'patient_id' => '225',
                'consommable' => 'ceftriaxone 1g',
                'jour' => '2',
                'nuit' => NULL,
                'date' => '2019-11-18',
            ),
            138 => 
            array (
                'id' => '139',
                'user_id' => '5',
                'patient_id' => '225',
                'consommable' => 's. salé 250cc',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-18',
            ),
            139 => 
            array (
                'id' => '140',
                'user_id' => '5',
                'patient_id' => '225',
                'consommable' => 'pot à urine',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-18',
            ),
            140 => 
            array (
                'id' => '141',
                'user_id' => '5',
                'patient_id' => '225',
                'consommable' => 'tube violet',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-18',
            ),
            141 => 
            array (
                'id' => '142',
                'user_id' => '5',
                'patient_id' => '225',
                'consommable' => 'tube rouge',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-18',
            ),
            142 => 
            array (
                'id' => '143',
                'user_id' => '5',
                'patient_id' => '225',
                'consommable' => 'perfuseur',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-18',
            ),
            143 => 
            array (
                'id' => '144',
                'user_id' => '5',
                'patient_id' => '225',
                'consommable' => 'seringue 10cc',
                'jour' => '2',
                'nuit' => NULL,
                'date' => '2019-11-18',
            ),
            144 => 
            array (
                'id' => '145',
                'user_id' => '5',
                'patient_id' => '225',
                'consommable' => 'sonde siliconnée ch18 2v',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-18',
            ),
            145 => 
            array (
                'id' => '146',
                'user_id' => '5',
                'patient_id' => '225',
                'consommable' => 'poche à urine 2l',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-18',
            ),
            146 => 
            array (
                'id' => '147',
                'user_id' => '5',
                'patient_id' => '225',
                'consommable' => 'para 500cp',
                'jour' => '2',
                'nuit' => NULL,
                'date' => '2019-11-18',
            ),
            147 => 
            array (
                'id' => '148',
                'user_id' => '4',
                'patient_id' => '225',
                'consommable' => 'Paracetamol 1g',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-18',
            ),
            148 => 
            array (
                'id' => '149',
                'user_id' => '4',
                'patient_id' => '225',
                'consommable' => 'gants soins',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-18',
            ),
            149 => 
            array (
                'id' => '150',
                'user_id' => '5',
                'patient_id' => '249',
                'consommable' => 'kt 18g',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-22',
            ),
            150 => 
            array (
                'id' => '151',
                'user_id' => '5',
                'patient_id' => '249',
                'consommable' => 'gants de soins',
                'jour' => '9',
                'nuit' => NULL,
                'date' => '2019-11-22',
            ),
            151 => 
            array (
                'id' => '152',
                'user_id' => '5',
                'patient_id' => '249',
                'consommable' => 'perfuseur',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-22',
            ),
            152 => 
            array (
                'id' => '153',
                'user_id' => '5',
                'patient_id' => '249',
                'consommable' => 'serum salé 250cc',
                'jour' => '5',
                'nuit' => NULL,
                'date' => '2019-11-22',
            ),
            153 => 
            array (
                'id' => '154',
                'user_id' => '5',
                'patient_id' => '249',
                'consommable' => 'seringue 10cc',
                'jour' => '5',
                'nuit' => NULL,
                'date' => '2019-11-22',
            ),
            154 => 
            array (
                'id' => '155',
                'user_id' => '5',
                'patient_id' => '249',
                'consommable' => 'transfuseur',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-22',
            ),
            155 => 
            array (
                'id' => '156',
                'user_id' => '5',
                'patient_id' => '249',
                'consommable' => 's. salé 500cc',
                'jour' => '2',
                'nuit' => NULL,
                'date' => '2019-11-22',
            ),
            156 => 
            array (
                'id' => '157',
                'user_id' => '5',
                'patient_id' => '249',
                'consommable' => 'tube rouge',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-22',
            ),
            157 => 
            array (
                'id' => '158',
                'user_id' => '5',
                'patient_id' => '249',
                'consommable' => 'tube violoet',
                'jour' => '3',
                'nuit' => NULL,
                'date' => '2019-11-22',
            ),
            158 => 
            array (
                'id' => '159',
                'user_id' => '5',
                'patient_id' => '249',
                'consommable' => 'para 1g inj',
                'jour' => '2',
                'nuit' => NULL,
                'date' => '2019-11-22',
            ),
            159 => 
            array (
                'id' => '160',
                'user_id' => '5',
                'patient_id' => '249',
                'consommable' => 'kéto 100mg inj',
                'jour' => '2',
                'nuit' => NULL,
                'date' => '2019-11-22',
            ),
            160 => 
            array (
                'id' => '161',
                'user_id' => '5',
                'patient_id' => '249',
                'consommable' => 'imipenèm 1g',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-22',
            ),
            161 => 
            array (
                'id' => '162',
                'user_id' => '5',
                'patient_id' => '249',
                'consommable' => 'para 500mg cp',
                'jour' => '2',
                'nuit' => NULL,
                'date' => '2019-11-22',
            ),
            162 => 
            array (
                'id' => '163',
                'user_id' => '5',
                'patient_id' => '249',
                'consommable' => 'keto 100mg cp',
                'jour' => '3',
                'nuit' => NULL,
                'date' => '2019-11-22',
            ),
            163 => 
            array (
                'id' => '164',
                'user_id' => '5',
                'patient_id' => '249',
                'consommable' => 'imipénem 500mg',
                'jour' => '2',
                'nuit' => NULL,
                'date' => '2019-11-22',
            ),
            164 => 
            array (
                'id' => '165',
                'user_id' => '5',
                'patient_id' => '249',
                'consommable' => 'kt 20g',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-22',
            ),
            165 => 
            array (
                'id' => '166',
                'user_id' => '3',
                'patient_id' => '112',
                'consommable' => 'seringue 10cc',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-25',
            ),
            166 => 
            array (
                'id' => '167',
                'user_id' => '3',
                'patient_id' => '112',
                'consommable' => 'gants de soins',
                'jour' => '2',
                'nuit' => NULL,
                'date' => '2019-11-25',
            ),
            167 => 
            array (
                'id' => '168',
                'user_id' => '3',
                'patient_id' => '225',
                'consommable' => 'seringue 10cc',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-25',
            ),
            168 => 
            array (
                'id' => '169',
                'user_id' => '3',
                'patient_id' => '225',
                'consommable' => 'gants soins',
                'jour' => '2',
                'nuit' => NULL,
                'date' => '2019-11-25',
            ),
            169 => 
            array (
                'id' => '170',
                'user_id' => '6',
                'patient_id' => '112',
                'consommable' => 'gant de soins',
                'jour' => NULL,
                'nuit' => '1',
                'date' => '2019-11-25',
            ),
            170 => 
            array (
                'id' => '171',
                'user_id' => '6',
                'patient_id' => '112',
                'consommable' => 'paracetamol 1g inj',
                'jour' => NULL,
                'nuit' => '1',
                'date' => '2019-11-25',
            ),
            171 => 
            array (
                'id' => '172',
                'user_id' => '6',
                'patient_id' => '112',
                'consommable' => 'seringue 10ml',
                'jour' => NULL,
                'nuit' => '1',
                'date' => '2019-11-25',
            ),
            172 => 
            array (
                'id' => '173',
                'user_id' => '6',
                'patient_id' => '158',
                'consommable' => 'gants de soins',
                'jour' => NULL,
                'nuit' => '3',
                'date' => '2019-11-26',
            ),
            173 => 
            array (
                'id' => '174',
                'user_id' => '6',
                'patient_id' => '158',
                'consommable' => 'seringue à insuline',
                'jour' => NULL,
                'nuit' => '1',
                'date' => '2019-11-26',
            ),
            174 => 
            array (
                'id' => '175',
                'user_id' => '6',
                'patient_id' => '158',
                'consommable' => 'bandelette à glycémie',
                'jour' => NULL,
                'nuit' => '1',
                'date' => '2019-11-26',
            ),
            175 => 
            array (
                'id' => '176',
                'user_id' => '3',
                'patient_id' => '112',
                'consommable' => 'gentamycine 1g',
                'jour' => '0',
                'nuit' => '1',
                'date' => '2019-11-26',
            ),
            176 => 
            array (
                'id' => '177',
                'user_id' => '3',
                'patient_id' => '112',
                'consommable' => 'gentamycine 80mg',
                'jour' => NULL,
                'nuit' => '2',
                'date' => '2019-11-26',
            ),
            177 => 
            array (
                'id' => '178',
                'user_id' => '3',
                'patient_id' => '112',
                'consommable' => 'gants de soins',
                'jour' => NULL,
                'nuit' => '2',
                'date' => '2019-11-26',
            ),
            178 => 
            array (
                'id' => '179',
                'user_id' => '3',
                'patient_id' => '112',
                'consommable' => 's salee 0.9% 250cc',
                'jour' => NULL,
                'nuit' => '1',
                'date' => '2019-11-26',
            ),
            179 => 
            array (
                'id' => '180',
                'user_id' => '3',
                'patient_id' => '112',
                'consommable' => 'cefotaxime 1g',
                'jour' => NULL,
                'nuit' => '1',
                'date' => '2019-11-26',
            ),
            180 => 
            array (
                'id' => '181',
                'user_id' => '3',
                'patient_id' => '112',
                'consommable' => 'paracetamol 500mg cp',
                'jour' => NULL,
                'nuit' => '2',
                'date' => '2019-11-27',
            ),
            181 => 
            array (
                'id' => '182',
                'user_id' => '12',
                'patient_id' => '112',
                'consommable' => 'gentamicine 80mg',
                'jour' => '2',
                'nuit' => NULL,
                'date' => '2019-11-27',
            ),
            182 => 
            array (
                'id' => '183',
                'user_id' => '12',
                'patient_id' => '112',
                'consommable' => 'cefotaxine 1g',
                'jour' => '1',
                'nuit' => NULL,
                'date' => '2019-11-27',
            ),
            183 => 
            array (
                'id' => '184',
                'user_id' => '3',
                'patient_id' => '281',
                'consommable' => 'gants de soins',
                'jour' => NULL,
                'nuit' => '2',
                'date' => '2019-11-28',
            ),
            184 => 
            array (
                'id' => '185',
                'user_id' => '3',
                'patient_id' => '281',
                'consommable' => 'bandelette a glycemie',
                'jour' => NULL,
                'nuit' => '1',
                'date' => '2019-11-28',
            ),
            185 => 
            array (
                'id' => '186',
                'user_id' => '3',
                'patient_id' => '281',
                'consommable' => 'seingue 2cc',
                'jour' => NULL,
                'nuit' => '1',
                'date' => '2019-11-28',
            ),
            186 => 
            array (
                'id' => '187',
                'user_id' => '3',
                'patient_id' => '285',
                'consommable' => 'parastamol',
                'jour' => '1',
                'nuit' => '500',
                'date' => '2019-11-27',
            ),
            187 => 
            array (
                'id' => '188',
                'user_id' => '3',
                'patient_id' => '285',
                'consommable' => 'nivaquine',
                'jour' => '2',
                'nuit' => '500',
                'date' => '2019-11-25',
            ),
        ));
        
        
    }
}