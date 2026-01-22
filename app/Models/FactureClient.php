<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FactureClient
 *
 * @property int $id
 * @property int $user_id
 * @property int $client_id
 * @property string $nom
 * @property string|null $prenom
 * @property string $montant
 * @property string|null $avance
 * @property string|null $reste
 * @property string|null $motif
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Client $client
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureClient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureClient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureClient query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureClient whereAvance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureClient whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureClient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureClient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureClient whereMontant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureClient whereMotif($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureClient whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureClient wherePrenom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureClient whereReste($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureClient whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureClient whereUserId($value)
 * @mixin \Eloquent
 */
class FactureClient extends Model
{
    protected $guarded = [];
  
    public function client()
    {
        return $this->belongsTo(\App\Models\Client::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

   
}
