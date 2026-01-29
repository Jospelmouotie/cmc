<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChambresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Désactiver les contraintes de clés étrangères pour éviter les erreurs lors du truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('chambres')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('chambres')->insert([
            [
                'id' => 1,
                'user_id' => 5,
                'numero' => '101 Lit 1',
                'categorie' => 'CLASSIQUE',
                'patient' => null,
                'prix' => 50000,
                'jour' => null,
                'statut' => 'libre',
                'created_at' => '2019-09-26 16:48:47',
                'updated_at' => '2019-09-26 17:49:23',
            ],
            [
                'id' => 2,
                'user_id' => 5,
                'numero' => '101 Lit 2',
                'categorie' => 'CLASSIQUE',
                'patient' => null,
                'prix' => 50000,
                'jour' => null,
                'statut' => 'libre',
                'created_at' => '2019-09-26 16:48:48',
                'updated_at' => '2019-09-26 16:48:48',
            ],
            [
                'id' => 3,
                'user_id' => 5,
                'numero' => '102 Lit 1',
                'categorie' => 'CLASSIQUE',
                'patient' => null,
                'prix' => 50000,
                'jour' => null,
                'statut' => 'libre',
                'created_at' => '2019-09-26 16:48:48',
                'updated_at' => '2019-09-26 16:48:48',
            ],
            [
                'id' => 4,
                'user_id' => 5,
                'numero' => '102 Lit 2',
                'categorie' => 'CLASSIQUE',
                'patient' => null,
                'prix' => 50000,
                'jour' => null,
                'statut' => 'libre',
                'created_at' => '2019-09-26 16:48:48',
                'updated_at' => '2019-09-26 16:48:48',
            ],
            [
                'id' => 5,
                'user_id' => 5,
                'numero' => '103 Lit 1',
                'categorie' => 'CLASSIQUE',
                'patient' => null,
                'prix' => 50000,
                'jour' => null,
                'statut' => 'libre',
                'created_at' => '2019-09-26 16:48:48',
                'updated_at' => '2019-09-26 16:48:48',
            ],
            [
                'id' => 6,
                'user_id' => 5,
                'numero' => '103 Lit 2',
                'categorie' => 'CLASSIQUE',
                'patient' => null,
                'prix' => 50000,
                'jour' => null,
                'statut' => 'libre',
                'created_at' => '2019-09-26 16:48:48',
                'updated_at' => '2019-09-26 16:48:48',
            ],
            [
                'id' => 7,
                'user_id' => 5,
                'numero' => '104 Lit 1',
                'categorie' => 'CLASSIQUE',
                'patient' => null,
                'prix' => 50000,
                'jour' => null,
                'statut' => 'libre',
                'created_at' => '2019-09-26 16:48:49',
                'updated_at' => '2019-09-26 16:48:49',
            ],
            [
                'id' => 8,
                'user_id' => 5,
                'numero' => '104 Lit 2',
                'categorie' => 'CLASSIQUE',
                'patient' => null,
                'prix' => 50000,
                'jour' => null,
                'statut' => 'libre',
                'created_at' => '2019-09-26 16:48:49',
                'updated_at' => '2019-09-26 16:48:49',
            ],
            [
                'id' => 9,
                'user_id' => 5,
                'numero' => '105',
                'categorie' => 'VIP',
                'patient' => null,
                'prix' => 100000,
                'jour' => null,
                'statut' => 'libre',
                'created_at' => '2019-09-26 16:48:49',
                'updated_at' => '2019-09-26 16:48:49',
            ],
            [
                'id' => 10,
                'user_id' => 5,
                'numero' => 'BLOC 1',
                'categorie' => 'BLOC OPERATOIRE',
                'patient' => null,
                'prix' => null,
                'jour' => null,
                'statut' => 'libre',
                'created_at' => '2019-09-26 16:48:49',
                'updated_at' => '2019-09-26 16:48:49',
            ],
            [
                'id' => 11,
                'user_id' => 5,
                'numero' => 'BLOC 2',
                'categorie' => 'BLOC OPERATOIRE',
                'patient' => null,
                'prix' => null,
                'jour' => null,
                'statut' => 'libre',
                'created_at' => '2019-09-26 16:48:49',
                'updated_at' => '2019-09-26 16:48:49',
            ],
        ]);
    }
}
