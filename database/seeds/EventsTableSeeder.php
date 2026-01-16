<?php

use Illuminate\Database\Seeder;

class EventsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('events')->delete();
        
        \DB::table('events')->insert(array (
            0 => 
            array (
                'id' => '2',
                'title' => 'Première consultation',
                'date' => '2019-11-06',
                'start_time' => '19:40',
                'end_time' => '19:55',
                'color' => '#80ff80',
                'created_at' => '2019-11-06 17:15:09',
                'updated_at' => '2019-11-06 17:15:09',
                'user_id' => '13',
                'patient_id' => '190',
            ),
            1 => 
            array (
                'id' => '3',
                'title' => 'Consultation de suivis',
                'date' => '2019-11-06',
                'start_time' => '19:55',
                'end_time' => '20:10',
                'color' => '#0080ff',
                'created_at' => '2019-11-06 17:17:09',
                'updated_at' => '2019-11-06 17:17:09',
                'user_id' => '13',
                'patient_id' => '194',
            ),
            2 => 
            array (
                'id' => '4',
                'title' => 'Consultation de suivis',
                'date' => '2019-11-06',
                'start_time' => '20:10',
                'end_time' => '20:25',
                'color' => '#0080ff',
                'created_at' => '2019-11-06 17:18:48',
                'updated_at' => '2019-11-06 17:18:48',
                'user_id' => '13',
                'patient_id' => '112',
            ),
            3 => 
            array (
                'id' => '5',
                'title' => 'Consultation de suivis',
                'date' => '2019-11-06',
                'start_time' => '20:10',
                'end_time' => '20:25',
                'color' => '#0080ff',
                'created_at' => '2019-11-06 17:36:29',
                'updated_at' => '2019-11-06 17:36:29',
                'user_id' => '13',
                'patient_id' => '104',
            ),
            4 => 
            array (
                'id' => '6',
                'title' => 'Consultation de suivis',
                'date' => '2019-11-06',
                'start_time' => '20:25',
                'end_time' => '20:35',
                'color' => '#0080ff',
                'created_at' => '2019-11-06 17:37:03',
                'updated_at' => '2019-11-06 17:37:03',
                'user_id' => '13',
                'patient_id' => '198',
            ),
            5 => 
            array (
                'id' => '7',
                'title' => 'Consultation de suivis',
                'date' => '2019-11-06',
                'start_time' => '20:35',
                'end_time' => '20:45',
                'color' => '#0080ff',
                'created_at' => '2019-11-06 17:38:30',
                'updated_at' => '2019-11-06 17:38:30',
                'user_id' => '13',
                'patient_id' => '199',
            ),
            6 => 
            array (
                'id' => '8',
                'title' => 'Consultation de suivis',
                'date' => '2019-12-07',
                'start_time' => '12:30',
                'end_time' => '13:30',
                'color' => '#800080',
                'created_at' => '2019-12-06 11:44:28',
                'updated_at' => '2019-12-06 11:44:28',
                'user_id' => '20',
                'patient_id' => '286',
            ),
            7 => 
            array (
                'id' => '9',
                'title' => 'Première consultation',
                'date' => '2019-12-06',
                'start_time' => '13:00',
                'end_time' => '14:00',
                'color' => '#8000ff',
                'created_at' => '2019-12-06 12:03:41',
                'updated_at' => '2019-12-06 12:03:41',
                'user_id' => '20',
                'patient_id' => '286',
            ),
            8 => 
            array (
                'id' => '10',
                'title' => 'Consultation post-opératoire',
                'date' => '2019-12-06',
                'start_time' => '13:15',
                'end_time' => '14:00',
                'color' => '#ff0080',
                'created_at' => '2019-12-06 12:09:09',
                'updated_at' => '2019-12-06 12:09:09',
                'user_id' => '20',
                'patient_id' => '286',
            ),
            9 => 
            array (
                'id' => '11',
                'title' => 'Première consultation',
                'date' => '2019-12-06',
                'start_time' => '13:00',
                'end_time' => '13:00',
                'color' => '#8080c0',
                'created_at' => '2019-12-06 12:11:39',
                'updated_at' => '2019-12-06 12:11:39',
                'user_id' => '20',
                'patient_id' => '285',
            ),
        ));
        
        
    }
}