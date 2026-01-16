<?php

use Illuminate\Database\Seeder;

class ConsultationAnesthesistesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('consultation_anesthesistes')->delete();
        
        \DB::table('consultation_anesthesistes')->insert(array (
            0 => 
            array (
                'id' => '1',
                'user_id' => '15',
                'patient_id' => '138',
                'specialite' => 'URO',
                'medecin_traitant' => 'Dr Kuitche',
                'operateur' => 'Dr Kuitche',
                'date_intervention' => '2019-10-22',
            'motif_admission' => 'USCO SOUPLE (G)',
                'memo' => NULL,
                'anesthesi_salle' => 'Hospit < 10 jours',
                'risque' => 'ASA 2
Sepsis Urinaire',
                'solide' => 'H-8',
                'liquide' => 'H-2',
                'benefice_risque' => 'Oui',
                'adaptation_traitement' => 'Selon prescription',
                'technique_anesthesie' => 'Anesthésie générale,',
                'technique_anesthesie1' => 'Oui',
                'synthese_preop' => 'Kit AG',
                'date_hospitalisation' => '2019-10-22',
                'service' => 'Hospitalisation',
                'classe_asa' => '2',
                'antecedent_traitement' => 'I.U Chronique à BMR / E. Coli
Chir: 2 USCO 
Anesth: 02 AG
Sonde JJ (G) en place
Tabac: non
Alcool:Non',
                'examen_clinique' => 'NFS; ECBU+ATB;',
                'allergie' => 'n/c',
                'traitement_en_cours' => 'Imipenem 1g/24h',
                'antibiotique' => 'Cefoxitine 2g',
                'autre1' => NULL,
                'examen_paraclinique' => 'N/A',
                'intubation' => 'LMA 4/5',
                'mallampati' => '1',
                'distance_interincisive' => '>35mm',
                'distance_thyromentoniere' => '>65mm',
                'mobilite_servicale' => 'N',
                'created_at' => '2019-10-21 15:44:16',
                'updated_at' => '2019-10-21 15:44:16',
            ),
        ));
        
        
    }
}