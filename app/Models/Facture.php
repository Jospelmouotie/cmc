<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Facture
 *
 * @property int $id
 * @property string|null $patient
 * @property int $user_id
 * @property int $numero
 * @property int $quantite_total
 * @property int $prix_total
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Produit[] $produits
 * @property-read int|null $produits_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Facture newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Facture newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Facture query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Facture whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Facture whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Facture whereNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Facture wherePatient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Facture wherePrixTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Facture whereQuantiteTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Facture whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Facture whereUserId($value)
 * @mixin \Eloquent
 */
class Facture extends Model
{
    protected $guarded = ['id'];

    protected $fillable = ['numero', 'prix_total', 'quantite_total', 'patient', 'user_id'];

    public function produits()
    {
        return $this->belongsToMany(\App\Models\Produit::class, 'facture_produit', 'facture_id','produit_id')
            ->withPivot('item', 'prix_total')
            ->withTimestamps();
    }

}
