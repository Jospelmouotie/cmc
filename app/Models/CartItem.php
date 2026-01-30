<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    // On autorise le remplissage de ces colonnes
    protected $fillable = ['user_id', 'produit_id', 'quantite', 'prix_unitaire'];

    // Relation pour récupérer les infos du produit (nom, prix, etc.)
    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}
