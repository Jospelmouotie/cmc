<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\Produit
 *
 * @property int $id
 * @property string $designation
 * @property string $categorie
 * @property int $qte_stock
 * @property int $qte_alerte
 * @property int $prix_unitaire
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Facture[] $factures
 * @property-read int|null $factures_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Produit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Produit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Produit query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Produit whereCategorie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Produit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Produit whereDesignation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Produit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Produit wherePrixUnitaire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Produit whereQteAlerte($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Produit whereQteStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Produit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Produit whereUserId($value)
 * @mixin \Eloquent
 */
class Produit extends Model
{

    protected $fillable = [
        'designation',
        'categorie',
        'qte_stock',
        'qte_alerte',
        'prix_unitaire'

    ] ;


    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }

    public function factures()
    {
        return $this->belongsToMany(\App\Models\Facture::class)
            ->withPivot('item', 'prix_total')
            ->withTimestamps();
    }

    public function fiche_consommables()
    {
        return $this->hasMany(\App\Models\FicheConsommable::class);
    }
}


