<?php

use Illuminate\Database\Seeder;

class SoinsInfirmiersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('soins_infirmiers')->delete();
        
        \DB::table('soins_infirmiers')->insert(array (
            0 => 
            array (
                'id' => '1',
                'user_id' => '6',
                'patient_id' => '112',
                'observation' => '18h55: 1 cp de janumet 50mg/1000mg donné au patient',
                'patient_externe' => 'TIYOU Joseph',
                'date' => '2019-11-07',
            ),
            1 => 
            array (
                'id' => '2',
                'user_id' => '6',
                'patient_id' => '112',
                'observation' => 'ceftriaxone 1g fait ivdl',
                'patient_externe' => 'TIYOU Joseph',
                'date' => '2019-11-08',
            ),
            2 => 
            array (
                'id' => '3',
                'user_id' => '12',
                'patient_id' => '112',
                'observation' => 'lovenox 4000 IE-IU fait a 14h et le pansement a été refait',
                'patient_externe' => 'TIYOU Joseph',
                'date' => '2019-11-09',
            ),
            3 => 
            array (
                'id' => '4',
                'user_id' => '12',
                'patient_id' => '198',
                'observation' => 'lovenox 4000 IE-IU fait par ordre de dr djoufang',
                'patient_externe' => 'SIPEWA JEAN MARIE',
                'date' => '2019-11-09',
            ),
            4 => 
            array (
                'id' => '5',
                'user_id' => '12',
                'patient_id' => '198',
                'observation' => 'bicalutamide 50mg 1cp/jr par ordre de Dr njinou',
                'patient_externe' => 'SIPEWA JEAN MARIE',
                'date' => '2019-11-09',
            ),
            5 => 
            array (
                'id' => '6',
                'user_id' => '12',
                'patient_id' => '198',
                'observation' => 'injection du zoladex 10.8 S/C par Dr njinou a 17h10',
                'patient_externe' => 'SIPEWA JEAN MARIE',
                'date' => '2019-11-09',
            ),
            6 => 
            array (
                'id' => '7',
                'user_id' => '6',
                'patient_id' => '112',
                'observation' => '9h30: paintes: difficultés à la defecation
CAT: prise du macrogol 4000 un sachet PO Dr NJINOU',
                'patient_externe' => 'TIYOU Joseph',
                'date' => '2019-11-10',
            ),
            7 => 
            array (
                'id' => '8',
                'user_id' => '6',
                'patient_id' => '112',
                'observation' => '16h20: t°: 38.4°C',
                'patient_externe' => 'CHATUE',
                'date' => '2019-11-10',
            ),
            8 => 
            array (
                'id' => '9',
                'user_id' => '6',
                'patient_id' => '112',
                'observation' => '16h30/ PLAINTES : spasmes ++ LYRICA 25mg pris PO',
                'patient_externe' => 'TIYOU Joseph',
                'date' => '2019-11-10',
            ),
            9 => 
            array (
                'id' => '10',
                'user_id' => '6',
                'patient_id' => '112',
                'observation' => '17h30 plaintes: persistance des spasmes vesicaux: gel de xylocaine inject" dans le canal uretral puis prise de 50mg de lyrica de plus. 
sonde vésicale vidéee à 2000ml d\'urines rosées',
                'patient_externe' => 'TIYOU Joseph',
                'date' => '2019-11-10',
            ),
            10 => 
            array (
                'id' => '11',
                'user_id' => '6',
                'patient_id' => '104',
                'observation' => '13h30: T°: 37.9°C',
                'patient_externe' => 'CHATUE',
                'date' => '2019-11-10',
            ),
            11 => 
            array (
                'id' => '12',
                'user_id' => '6',
                'patient_id' => '104',
                'observation' => '15H20:  T° : 38.4°C',
                'patient_externe' => NULL,
                'date' => '2019-11-10',
            ),
            12 => 
            array (
                'id' => '13',
                'user_id' => '6',
                'patient_id' => '112',
                'observation' => '18h30: gel de xylocaine injecté dans le canal',
                'patient_externe' => 'TIYOU Joseph',
                'date' => '2019-11-10',
            ),
            13 => 
            array (
                'id' => '14',
                'user_id' => '8',
                'patient_id' => '112',
                'observation' => 'soins à domicile à programmer:voir mme TITI',
                'patient_externe' => 'TIYOU Joseph',
                'date' => '2019-11-11',
            ),
        ));
        
        
    }
}