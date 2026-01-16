<?php

use Illuminate\Database\Seeder;

class OrdonancesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('ordonances')->delete();
        
        \DB::table('ordonances')->insert(array (
            0 => 
            array (
                'id' => '1',
                'user_id' => '16',
                'patient_id' => '22',
                'description' => 'un comprimé matin et soir pendant 3 semaines,une application matin et soir après la douche et pendant 3 semaines',
                'medicament' => 'GRISEOFULINE,PEVARYL crème',
                'quantite' => '1 boite,1 boite',
                'created_at' => '2019-09-27 12:13:01',
                'updated_at' => '2019-09-27 12:13:01',
            ),
            1 => 
            array (
                'id' => '2',
                'user_id' => '14',
                'patient_id' => '60',
                'description' => 'gbb',
                'medicament' => 'dfdsnwtewz',
                'quantite' => '20',
                'created_at' => '2019-10-02 09:37:47',
                'updated_at' => '2019-10-02 09:37:47',
            ),
            2 => 
            array (
                'id' => '3',
                'user_id' => '16',
                'patient_id' => '23',
                'description' => '1 comprimé matin et soir',
                'medicament' => 'tritazide',
                'quantite' => '1 boite',
                'created_at' => '2019-10-09 12:27:59',
                'updated_at' => '2019-10-09 12:27:59',
            ),
            3 => 
            array (
                'id' => '4',
                'user_id' => '13',
                'patient_id' => '104',
                'description' => '',
                'medicament' => 'Biopsies de prostate sous sedation',
                'quantite' => '',
                'created_at' => '2019-10-12 20:27:23',
                'updated_at' => '2019-10-12 20:27:23',
            ),
            4 => 
            array (
                'id' => '5',
                'user_id' => '13',
                'patient_id' => '190',
                'description' => '1 cp par jour,1 cp par jour,1 cp par jour',
                'medicament' => 'BICALUTAMIDE 50 mg,FINASTERIDE 5 Mg,PREDNISOLONE 5 mg',
                'quantite' => '3 btes,3 btes,2 btes',
                'created_at' => '2019-11-06 19:11:20',
                'updated_at' => '2019-11-06 19:11:20',
            ),
            5 => 
            array (
                'id' => '6',
                'user_id' => '13',
                'patient_id' => '190',
                'description' => '1 cp par jour',
                'medicament' => 'PREDNISOLONE 5 mg',
                'quantite' => '2 btes',
                'created_at' => '2019-11-06 19:12:39',
                'updated_at' => '2019-11-06 19:12:39',
            ),
            6 => 
            array (
                'id' => '7',
                'user_id' => '13',
                'patient_id' => '190',
                'description' => '1 cp par jour pendant 2 mois,',
                'medicament' => 'PREDNISOLONE 5 mg,',
                'quantite' => ',',
                'created_at' => '2019-11-06 19:15:12',
                'updated_at' => '2019-11-06 19:15:12',
            ),
            7 => 
            array (
                'id' => '8',
                'user_id' => '13',
                'patient_id' => '11',
                'description' => '1 cp le soir pendant 2 mois',
                'medicament' => 'DULOXETINE 60 mg',
                'quantite' => '',
                'created_at' => '2019-11-06 19:27:52',
                'updated_at' => '2019-11-06 19:27:52',
            ),
            8 => 
            array (
                'id' => '9',
                'user_id' => '13',
                'patient_id' => '11',
                'description' => '3 seances par semaine pendant 3 mois',
                'medicament' => 'Reeducation perineale',
                'quantite' => '',
                'created_at' => '2019-11-06 19:28:20',
                'updated_at' => '2019-11-06 19:28:20',
            ),
            9 => 
            array (
                'id' => '10',
                'user_id' => '13',
                'patient_id' => '194',
                'description' => '1 cp le soir apres le repas pendant 2 mois',
                'medicament' => 'XATRAL LP 10 mg',
                'quantite' => '',
                'created_at' => '2019-11-06 20:04:16',
                'updated_at' => '2019-11-06 20:04:16',
            ),
            10 => 
            array (
                'id' => '11',
                'user_id' => '13',
                'patient_id' => '195',
                'description' => '3-3-6 par jour pendant 2 mois',
                'medicament' => 'LAROXYL GOUTTES',
                'quantite' => '',
                'created_at' => '2019-11-06 20:15:02',
                'updated_at' => '2019-11-06 20:15:02',
            ),
            11 => 
            array (
                'id' => '12',
                'user_id' => '13',
                'patient_id' => '208',
                'description' => 'Bilan douleures pelvi-périneales
Antécédents de néoplasie prostatique, Exclure lésions secondaires osseuse',
                'medicament' => 'SCANNER ABDOMINO-PELVIEN',
                'quantite' => '',
                'created_at' => '2019-11-07 16:36:34',
                'updated_at' => '2019-11-07 16:36:34',
            ),
            12 => 
            array (
                'id' => '13',
                'user_id' => '13',
                'patient_id' => '208',
                'description' => '1 cp par jour pendant 10 jours',
                'medicament' => 'LEVOFLOXACINE 500 mg',
                'quantite' => '',
                'created_at' => '2019-11-07 16:44:48',
                'updated_at' => '2019-11-07 16:44:48',
            ),
            13 => 
            array (
                'id' => '14',
                'user_id' => '13',
                'patient_id' => '202',
                'description' => 'Calcul appareil urinaire gauche',
                'medicament' => 'SCZNNZR ZBDOMINO-PELVIEN',
                'quantite' => '',
                'created_at' => '2019-11-07 17:10:08',
                'updated_at' => '2019-11-07 17:10:08',
            ),
        ));
        
        
    }
}