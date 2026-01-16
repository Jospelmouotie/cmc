<?php

use Illuminate\Database\Seeder;

class FactureProduitTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('facture_produit')->delete();
        
        
        
    }
}