<?php

use Illuminate\Database\Seeder;

class MigrationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('migrations')->delete();
        
        \DB::table('migrations')->insert(array (
            0 => 
            array (
                'id' => '1',
                'migration' => '2014_10_12_000000_create_users_table',
                'batch' => '1',
            ),
            1 => 
            array (
                'id' => '2',
                'migration' => '2014_10_12_100000_create_password_resets_table',
                'batch' => '1',
            ),
            2 => 
            array (
                'id' => '3',
                'migration' => '2019_04_15_140111_create_produits_table',
                'batch' => '1',
            ),
            3 => 
            array (
                'id' => '4',
                'migration' => '2019_04_16_102214_create_events_table',
                'batch' => '1',
            ),
            4 => 
            array (
                'id' => '5',
                'migration' => '2019_04_16_161233_create_roles_table',
                'batch' => '1',
            ),
            5 => 
            array (
                'id' => '6',
                'migration' => '2019_04_17_114907_add_role_id_field_to_users_table',
                'batch' => '1',
            ),
            6 => 
            array (
                'id' => '7',
                'migration' => '2019_04_17_122731_add_user_id_field_to_events_table',
                'batch' => '1',
            ),
            7 => 
            array (
                'id' => '8',
                'migration' => '2019_04_17_142731_add_user_id_field_to_produits_table',
                'batch' => '1',
            ),
            8 => 
            array (
                'id' => '9',
                'migration' => '2019_04_17_164354_create_user_role_table',
                'batch' => '1',
            ),
            9 => 
            array (
                'id' => '10',
                'migration' => '2019_04_18_144729_create_chambres_table',
                'batch' => '1',
            ),
            10 => 
            array (
                'id' => '11',
                'migration' => '2019_04_18_154819_create_patients_table',
                'batch' => '1',
            ),
            11 => 
            array (
                'id' => '12',
                'migration' => '2019_04_19_085025_create_consultations_table',
                'batch' => '1',
            ),
            12 => 
            array (
                'id' => '13',
                'migration' => '2019_04_24_104042_create_dossiers_table',
                'batch' => '1',
            ),
            13 => 
            array (
                'id' => '14',
                'migration' => '2019_04_24_110024_create_fiches_table',
                'batch' => '1',
            ),
            14 => 
            array (
                'id' => '15',
                'migration' => '2019_04_25_093907_create_parametres_table',
                'batch' => '1',
            ),
            15 => 
            array (
                'id' => '16',
                'migration' => '2019_04_25_101248_add_user_id_field_to_fiches_tables',
                'batch' => '1',
            ),
            16 => 
            array (
                'id' => '17',
                'migration' => '2019_04_29_084019_create_ordonances_table',
                'batch' => '1',
            ),
            17 => 
            array (
                'id' => '18',
                'migration' => '2019_04_30_154515_create_soins_table',
                'batch' => '1',
            ),
            18 => 
            array (
                'id' => '19',
                'migration' => '2019_05_29_180611_create_factures_table',
                'batch' => '1',
            ),
            19 => 
            array (
                'id' => '20',
                'migration' => '2019_06_03_140943_create_facture_produit_table',
                'batch' => '1',
            ),
            20 => 
            array (
                'id' => '21',
                'migration' => '2019_06_28_143818_create_compte_rendu_bloc_operatoires_table',
                'batch' => '1',
            ),
            21 => 
            array (
                'id' => '22',
                'migration' => '2019_07_08_112841_create_examens_table',
                'batch' => '1',
            ),
            22 => 
            array (
                'id' => '23',
                'migration' => '2019_07_17_122630_create_interventions_table',
                'batch' => '1',
            ),
            23 => 
            array (
                'id' => '24',
                'migration' => '2019_07_18_115330_create_prescriptions_table',
                'batch' => '1',
            ),
            24 => 
            array (
                'id' => '25',
                'migration' => '2019_08_30_134304_create_devis_table',
                'batch' => '1',
            ),
            25 => 
            array (
                'id' => '26',
                'migration' => '2019_08_31_123404_create_facture_consultations_table',
                'batch' => '1',
            ),
            26 => 
            array (
                'id' => '27',
                'migration' => '2019_09_01_103813_create_facture_chambres_table',
                'batch' => '1',
            ),
            27 => 
            array (
                'id' => '28',
                'migration' => '2019_09_04_175235_create_consultation_anesthesistes_table',
                'batch' => '1',
            ),
            28 => 
            array (
                'id' => '29',
                'migration' => '2019_09_08_153217_create_devis_images_table',
                'batch' => '1',
            ),
            29 => 
            array (
                'id' => '30',
                'migration' => '2019_09_14_122241_create_facture_clients_table',
                'batch' => '1',
            ),
            30 => 
            array (
                'id' => '31',
                'migration' => '2019_09_14_135844_create_fiche_interventions_table',
                'batch' => '1',
            ),
            31 => 
            array (
                'id' => '32',
                'migration' => '2019_09_14_140707_create_clients_table',
                'batch' => '1',
            ),
            32 => 
            array (
                'id' => '33',
                'migration' => '2019_09_18_131007_add_fields_on_patients_table',
                'batch' => '1',
            ),
            33 => 
            array (
                'id' => '34',
                'migration' => '2019_09_19_181428_add_fields_on_facture_consultations_table',
                'batch' => '1',
            ),
            34 => 
            array (
                'id' => '35',
                'migration' => '2019_09_23_121205_create_visite_preanesthesiques_table',
                'batch' => '1',
            ),
            35 => 
            array (
                'id' => '36',
                'migration' => '2019_09_23_130306_create_premedications_table',
                'batch' => '1',
            ),
            36 => 
            array (
                'id' => '37',
                'migration' => '2019_09_23_142323_create_traitement_hospitalisations_table',
                'batch' => '1',
            ),
            37 => 
            array (
                'id' => '38',
                'migration' => '2019_09_23_163906_create_adaptation_traitements_table',
                'batch' => '1',
            ),
            38 => 
            array (
                'id' => '40',
                'migration' => '2019_09_27_122741_add_fields_on_clients_table',
                'batch' => '2',
            ),
            39 => 
            array (
                'id' => '41',
                'migration' => '2019_09_27_123214_add_fields_on_facture_clients_table',
                'batch' => '2',
            ),
            40 => 
            array (
                'id' => '42',
                'migration' => '2019_09_30_101636_add_fields_on_patients_table',
                'batch' => '2',
            ),
            41 => 
            array (
                'id' => '43',
                'migration' => '2019_09_30_103613_add_fields_medecin_r_on_client_table',
                'batch' => '2',
            ),
            42 => 
            array (
                'id' => '44',
                'migration' => '2019_09_30_103715_add_fields_medecin_r_on_facture_clients_table',
                'batch' => '2',
            ),
            43 => 
            array (
                'id' => '45',
                'migration' => '2019_09_30_104141_add_fields_medecin_r_on_facture_consultations_table',
                'batch' => '2',
            ),
            44 => 
            array (
                'id' => '46',
                'migration' => '2019_10_01_173328_add_fields_on_devis_table',
                'batch' => '3',
            ),
            45 => 
            array (
                'id' => '47',
                'migration' => '2019_10_02_170055_drop_column_jeune_preop_on_consultation_anesthesistes_table',
                'batch' => '3',
            ),
            46 => 
            array (
                'id' => '48',
                'migration' => '2019_10_03_115608_create_fiche_consommables_table',
                'batch' => '3',
            ),
            47 => 
            array (
                'id' => '49',
                'migration' => '2019_10_03_122506_drop_column_devis_p_on_consultations_table',
                'batch' => '3',
            ),
            48 => 
            array (
                'id' => '50',
                'migration' => '2019_10_03_125643_add_fields_on_consultations_table',
                'batch' => '3',
            ),
            49 => 
            array (
                'id' => '51',
                'migration' => '2019_10_04_105651_create_observation_medicales_table',
                'batch' => '3',
            ),
            50 => 
            array (
                'id' => '52',
                'migration' => '2019_10_04_142700_create_soins_infirmiers_table',
                'batch' => '3',
            ),
            51 => 
            array (
                'id' => '53',
                'migration' => '2019_10_04_155407_create_surveillance_post_anesthesiques_table',
                'batch' => '3',
            ),
            52 => 
            array (
                'id' => '54',
                'migration' => '2019_10_07_162123_add_medicament_field_on_premedications_table',
                'batch' => '3',
            ),
            53 => 
            array (
                'id' => '55',
                'migration' => '2019_10_08_113240_create_imageries_table',
                'batch' => '3',
            ),
            54 => 
            array (
                'id' => '57',
                'migration' => '2019_10_08_185640_create_surveillance_rapproche_parametres_table',
                'batch' => '4',
            ),
            55 => 
            array (
                'id' => '58',
                'migration' => '2019_10_10_151728_create_surveillance_scores_table',
                'batch' => '4',
            ),
            56 => 
            array (
                'id' => '59',
                'migration' => '2019_10_15_112525_create_facture_devis_table',
                'batch' => '5',
            ),
            57 => 
            array (
                'id' => '60',
                'migration' => '2019_10_16_162331_create_prescription_medicales_table',
                'batch' => '5',
            ),
            58 => 
            array (
                'id' => '61',
                'migration' => '2019_10_16_172425_create_licences_table',
                'batch' => '5',
            ),
            59 => 
            array (
                'id' => '62',
                'migration' => '2019_10_18_112405_create_cle_activations_table',
                'batch' => '5',
            ),
            60 => 
            array (
                'id' => '63',
                'migration' => '2019_10_22_103811_drop_column_produit_id_on_fiche_consommables_table',
                'batch' => '6',
            ),
            61 => 
            array (
                'id' => '64',
                'migration' => '2019_10_28_153303_create_consultation_suivis_table',
                'batch' => '7',
            ),
            62 => 
            array (
                'id' => '65',
                'migration' => '2019_10_29_095247_create_devisds_table',
                'batch' => '8',
            ),
            63 => 
            array (
                'id' => '66',
                'migration' => '2019_11_07_144657_add_fields_on_compte_rendu_bloc_operatoires_table',
                'batch' => '8',
            ),
            64 => 
            array (
                'id' => '67',
                'migration' => '2019_11_08_101751_add_fields_on_prescription_medicales_table',
                'batch' => '9',
            ),
            65 => 
            array (
                'id' => '68',
                'migration' => '2019_12_17_141527_add_soft_deletes_to_facture_consultations_table',
                'batch' => '10',
            ),
        ));
        
        
    }
}