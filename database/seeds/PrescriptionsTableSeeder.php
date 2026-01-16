<?php

use Illuminate\Database\Seeder;

class PrescriptionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('prescriptions')->delete();
        
        \DB::table('prescriptions')->insert(array (
            0 => 
            array (
                'id' => '1',
                'user_id' => '16',
                'patient_id' => '23',
                'hematologie' => '',
                'hemostase' => '',
            'biochimie' => 'glycemie,cholesterol (hdl-ldl),',
                'hormonologie' => '',
                'marqueurs' => 'psa total,',
                'bacteriologie' => '',
                'spermiologie' => '',
                'urines' => '',
                'serologie' => '',
                'examen' => '',
                'created_at' => '2019-09-27 12:37:03',
                'updated_at' => '2019-09-27 12:37:03',
            ),
            1 => 
            array (
                'id' => '2',
                'user_id' => '13',
                'patient_id' => '111',
                'hematologie' => 'NFS,',
                'hemostase' => '',
                'biochimie' => 'Créatinine,Clairance de la créatine,',
                'hormonologie' => '',
                'marqueurs' => '',
                'bacteriologie' => '',
                'spermiologie' => '',
                'urines' => '',
                'serologie' => '',
                'examen' => '',
                'created_at' => '2019-10-12 17:35:52',
                'updated_at' => '2019-10-12 17:35:52',
            ),
            2 => 
            array (
                'id' => '3',
                'user_id' => '13',
                'patient_id' => '211',
                'hematologie' => 'NFS,',
                'hemostase' => '',
                'biochimie' => 'Créatinine,Clairance de la créatine,',
                'hormonologie' => '',
                'marqueurs' => '',
                'bacteriologie' => '',
                'spermiologie' => '',
                'urines' => '',
                'serologie' => '',
                'examen' => '',
                'created_at' => '2019-11-08 14:45:00',
                'updated_at' => '2019-11-08 14:45:00',
            ),
            3 => 
            array (
                'id' => '4',
                'user_id' => '16',
                'patient_id' => '253',
                'hematologie' => '',
                'hemostase' => '',
                'biochimie' => 'Glycémie,',
                'hormonologie' => 'PCR chlamydia / gonococcie',
                'marqueurs' => '',
                'bacteriologie' => '',
                'spermiologie' => '',
                'urines' => 'Examen Cytobactérioloque,',
                'serologie' => '',
                'examen' => '',
                'created_at' => '2019-11-18 08:45:08',
                'updated_at' => '2019-11-18 08:45:08',
            ),
            4 => 
            array (
                'id' => '5',
                'user_id' => '16',
                'patient_id' => '255',
                'hematologie' => '',
                'hemostase' => '',
                'biochimie' => '',
                'hormonologie' => '',
                'marqueurs' => '',
                'bacteriologie' => '',
                'spermiologie' => '',
                'urines' => 'Examen Cytobactérioloque,',
                'serologie' => '',
                'examen' => '',
                'created_at' => '2019-11-18 09:17:03',
                'updated_at' => '2019-11-18 09:17:03',
            ),
            5 => 
            array (
                'id' => '6',
                'user_id' => '16',
                'patient_id' => '256',
                'hematologie' => '',
                'hemostase' => '',
                'biochimie' => '',
                'hormonologie' => 'PCR chlamydia / gonococcie;',
                'marqueurs' => '',
                'bacteriologie' => '',
                'spermiologie' => '',
                'urines' => '',
                'serologie' => '',
                'examen' => '',
                'created_at' => '2019-11-18 09:52:39',
                'updated_at' => '2019-11-18 09:52:39',
            ),
            6 => 
            array (
                'id' => '7',
                'user_id' => '16',
                'patient_id' => '256',
                'hematologie' => 'NFS,',
                'hemostase' => '',
                'biochimie' => '',
                'hormonologie' => 'sérologie herpétique; PCR chlamydia',
                'marqueurs' => '',
                'bacteriologie' => '',
                'spermiologie' => '',
                'urines' => 'Examen Cytobactérioloque,',
                'serologie' => '',
                'examen' => '',
                'created_at' => '2019-11-18 09:53:34',
                'updated_at' => '2019-11-18 09:53:34',
            ),
            7 => 
            array (
                'id' => '8',
                'user_id' => '16',
                'patient_id' => '259',
                'hematologie' => 'NFS,',
                'hemostase' => '',
            'biochimie' => 'Glycémie,Créatinine,Cholesterol (HDL-LDL)),',
                'hormonologie' => '',
                'marqueurs' => 'PSA Total,',
                'bacteriologie' => '',
                'spermiologie' => '',
                'urines' => 'Examen Cytobactérioloque,',
                'serologie' => '',
                'examen' => '',
                'created_at' => '2019-11-22 09:19:04',
                'updated_at' => '2019-11-22 09:19:04',
            ),
            8 => 
            array (
                'id' => '9',
                'user_id' => '16',
                'patient_id' => '262',
                'hematologie' => '',
                'hemostase' => '',
            'biochimie' => 'Cholesterol (HDL-LDL)),hémoglobine glyquée',
                'hormonologie' => '',
                'marqueurs' => 'PSA Total,',
                'bacteriologie' => '',
                'spermiologie' => '',
                'urines' => 'Examen Cytobactérioloque,',
                'serologie' => '',
                'examen' => '',
                'created_at' => '2019-11-22 15:48:45',
                'updated_at' => '2019-11-22 15:48:45',
            ),
        ));
        
        
    }
}