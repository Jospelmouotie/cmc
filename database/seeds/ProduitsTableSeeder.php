<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produit;
use Illuminate\Support\Facades\DB;

class ProduitsTableSeeder extends Seeder
{
    public function run()
    {
        // On vide la table avant de commencer pour éviter les doublons sur 'designation'
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Produit::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $categories = [
            'pharmaceutique' => [
                'Paracétamol 500mg', 'Amoxicilline 1g', 'Ibuprofène 400mg', 'Spasfon Lyoc',
                'Doliprane 1000mg', 'Augmentin Adultes', 'Gaviscon Suspension', 'Mopral 20mg',
                'Voltarène 75mg', 'Ventoline 100µg', 'Zyrtec 10mg', 'Tramadol 50mg',
                'Inexium 40mg', 'Kardegic 75mg', 'Lévothyrox 50µg', 'Efferalgan 500mg',
                'Dafalgan Codeine', 'Clamoxyl 500mg', 'Ciprofloxacine 500mg', 'Flagyl 500mg'
            ],
            'materiel' => [
                'Gants d\'examen (Boîte 100)', 'Seringue 5ml (Boîte 50)', 'Cathéter 20G',
                'Compresses stériles 10x10', 'Sparadrap rouleau', 'Sonde Urinaire',
                'Masque chirurgical (Boîte 50)', 'Solution Hydroalcoolique 500ml',
                'Tensiomètre manuel', 'Stéthoscope standard', 'Thermomètre digital'
            ],
            'anesthesiste' => [
                'Propofol 1% Seringue', 'Sufentanil 5µg/ml', 'Cisatracurium 10mg',
                'Lidocaïne 2% inj', 'Bupivacaïne 0.5%', 'Éphédrine 30mg/ml',
                'Atropine 1mg', 'Rocuronium 50mg'
            ],
            'laboratoire' => [
                'Tube EDTA (Mauve)', 'Tube Sec (Rouge)', 'Tube Citrate (Bleu)',
                'Réactif Glucose', 'Kit de test Paludisme', 'Lames de microscope',
                'Embouts micropipette 200µl', 'Alcool dénaturé 90%'
            ]
        ];

        $count = 0;
        $allProducts = [];

        // On remplit jusqu'à atteindre 50 produits
        while ($count < 50) {
            foreach ($categories as $catName => $items) {
                if ($count >= 50) break;

                // On prend un item au hasard dans la liste ou on génère un nom si vide
                $designation = $items[array_rand($items)] . ($count > 35 ? " - Lot " . $count : "");

                // Pour éviter l'erreur Unique sur la désignation
                if (in_array($designation, $allProducts)) continue;
                $allProducts[] = $designation;

                Produit::create([
                    'designation'   => $designation,
                    'categorie'     => $catName,
                    'qte_stock'     => rand(10, 200),     // Stock aléatoire
                    'qte_alerte'    => rand(5, 15),       // Seuil d'alerte
                    'prix_unitaire' => $this->getRandomPrice($catName),
                    'user_id'       => 1                  // Assumé comme l'admin
                ]);

                $count++;
            }
        }
    }

    private function getRandomPrice($category) {
        return match($category) {
            'pharmaceutique' => rand(500, 5000),
            'materiel'       => rand(1000, 25000),
            'anesthesiste'   => rand(2000, 15000),
            default          => rand(500, 10000),
        };
    }
}
