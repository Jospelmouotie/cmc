<?php

use Illuminate\Database\Seeder;

class PrescriptionMedicalesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('prescription_medicales')->delete();
        
        \DB::table('prescription_medicales')->insert(array (
            0 => 
            array (
                'id' => '1',
                'user_id' => '8',
                'patient_id' => '21',
                'allergie' => NULL,
                'date' => '2019-10-30',
                'medicament' => 'para inj',
                'posologie' => '1g/8h',
                'voie' => 'iv',
                'heure' => '8',
                'matin' => 'on',
                'apre_midi' => NULL,
                'soir' => NULL,
                'regime' => 'normal',
                'consultation_specialise' => 'n/a',
                'protocole' => 'traitement anti hta',
                'nuit' => NULL,
            ),
            1 => 
            array (
                'id' => '2',
                'user_id' => '8',
                'patient_id' => '21',
                'allergie' => NULL,
                'date' => '2019-10-30',
                'medicament' => 'para inj',
                'posologie' => '1g/8h',
                'voie' => 'iv',
                'heure' => '14',
                'matin' => NULL,
                'apre_midi' => 'on',
                'soir' => NULL,
                'regime' => NULL,
                'consultation_specialise' => NULL,
                'protocole' => NULL,
                'nuit' => NULL,
            ),
            2 => 
            array (
                'id' => '3',
                'user_id' => '6',
                'patient_id' => '112',
                'allergie' => 'N/C',
                'date' => '2019-11-07',
                'medicament' => 'acupan 20mg',
                'posologie' => '3x/jr',
                'voie' => 'IV',
                'heure' => '18',
                'matin' => NULL,
                'apre_midi' => NULL,
                'soir' => 'on',
                'regime' => 'hyposodé, hypoglycémiant',
                'consultation_specialise' => NULL,
            'protocole' => '- contrôler glycémie à jeune ( demain 08/11/2019)
- faire nicardipine 5mg si TAS>= 180mmhg
- contrôler diurèse /24h',
                'nuit' => NULL,
            ),
            3 => 
            array (
                'id' => '4',
                'user_id' => '6',
                'patient_id' => '112',
                'allergie' => 'N/C',
                'date' => '2019-11-07',
                'medicament' => 'ceftriaxone',
                'posologie' => '1g/12h',
                'voie' => 'IV',
                'heure' => '2',
                'matin' => 'on',
                'apre_midi' => 'on',
                'soir' => NULL,
                'regime' => NULL,
                'consultation_specialise' => NULL,
                'protocole' => NULL,
                'nuit' => NULL,
            ),
            4 => 
            array (
                'id' => '5',
                'user_id' => '12',
                'patient_id' => '112',
                'allergie' => NULL,
                'date' => '2019-11-08',
                'medicament' => 'paracetamol 1g',
                'posologie' => '3/jr',
                'voie' => 'IV',
                'heure' => '10',
                'matin' => 'on',
                'apre_midi' => NULL,
                'soir' => NULL,
                'regime' => NULL,
                'consultation_specialise' => NULL,
                'protocole' => NULL,
                'nuit' => NULL,
            ),
            5 => 
            array (
                'id' => '6',
                'user_id' => '12',
                'patient_id' => '112',
                'allergie' => NULL,
                'date' => '2019-11-08',
                'medicament' => 'lovenox 4000 IE-UI',
                'posologie' => '1/jr',
                'voie' => 'SC',
                'heure' => '14',
                'matin' => NULL,
                'apre_midi' => 'on',
                'soir' => NULL,
                'regime' => NULL,
                'consultation_specialise' => NULL,
                'protocole' => NULL,
                'nuit' => NULL,
            ),
            6 => 
            array (
                'id' => '7',
                'user_id' => '12',
                'patient_id' => '112',
                'allergie' => NULL,
                'date' => '2019-11-09',
                'medicament' => 'lovenox 4000 IE-UI',
                'posologie' => '1/jr',
                'voie' => 'SC',
                'heure' => '14',
                'matin' => NULL,
                'apre_midi' => 'on',
                'soir' => NULL,
                'regime' => NULL,
                'consultation_specialise' => NULL,
                'protocole' => NULL,
                'nuit' => NULL,
            ),
            7 => 
            array (
                'id' => '8',
                'user_id' => '12',
                'patient_id' => '204',
                'allergie' => NULL,
                'date' => '2019-11-09',
                'medicament' => 'paracetamol 1g',
                'posologie' => '3/jr',
                'voie' => 'IV',
                'heure' => '15',
                'matin' => NULL,
                'apre_midi' => 'on',
                'soir' => NULL,
                'regime' => NULL,
                'consultation_specialise' => NULL,
                'protocole' => NULL,
                'nuit' => NULL,
            ),
            8 => 
            array (
                'id' => '9',
                'user_id' => '12',
                'patient_id' => '204',
                'allergie' => NULL,
                'date' => '2019-11-09',
                'medicament' => 'nefopam 20mg',
                'posologie' => 'si douleur',
                'voie' => 'IV',
                'heure' => '15',
                'matin' => NULL,
                'apre_midi' => 'on',
                'soir' => NULL,
                'regime' => NULL,
                'consultation_specialise' => NULL,
                'protocole' => NULL,
                'nuit' => NULL,
            ),
            9 => 
            array (
                'id' => '10',
                'user_id' => '12',
                'patient_id' => '198',
                'allergie' => NULL,
                'date' => '2019-11-09',
                'medicament' => 'lovenox 4000 IE-UI',
                'posologie' => '1/jr',
                'voie' => 'SC',
                'heure' => '15',
                'matin' => NULL,
                'apre_midi' => 'on',
                'soir' => NULL,
                'regime' => NULL,
                'consultation_specialise' => NULL,
                'protocole' => NULL,
                'nuit' => NULL,
            ),
            10 => 
            array (
                'id' => '11',
                'user_id' => '12',
                'patient_id' => '198',
                'allergie' => NULL,
                'date' => '2019-11-09',
                'medicament' => 'glycemie',
                'posologie' => 'toute les 8h',
                'voie' => 'doigt',
                'heure' => '14',
                'matin' => NULL,
                'apre_midi' => 'on',
                'soir' => NULL,
                'regime' => NULL,
                'consultation_specialise' => NULL,
                'protocole' => NULL,
                'nuit' => NULL,
            ),
            11 => 
            array (
                'id' => '12',
                'user_id' => '12',
                'patient_id' => '198',
                'allergie' => NULL,
                'date' => '2019-11-09',
                'medicament' => 'BICALUTAMIDE 50mg',
                'posologie' => '1/jr',
                'voie' => 'orale',
                'heure' => '17',
                'matin' => NULL,
                'apre_midi' => 'on',
                'soir' => NULL,
                'regime' => NULL,
                'consultation_specialise' => NULL,
                'protocole' => NULL,
                'nuit' => NULL,
            ),
        ));
        
        
    }
}