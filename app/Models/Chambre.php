<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

/**
 * App\Models\Chambre
 *
 * @property int $id
 * @property int $user_id
 * @property string $numero
 * @property string $categorie
 * @property string|null $patient
 * @property int|null $prix
 * @property int|null $jour
 * @property string $statut
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Consultation $consultations
 * @property-read \App\Models\User $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chambre newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chambre newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chambre query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chambre whereCategorie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chambre whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chambre whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chambre whereJour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chambre whereNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chambre wherePatient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chambre wherePrix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chambre whereStatut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chambre whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chambre whereUserId($value)
 * @mixin \Eloquent
 */
class Chambre extends Model
{

    protected $fillable = [

        'numero',
        'categorie',
        'prix',
        'statut',
        'patient',
        'jour'
    ];

    public function users()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function consultations()
    {
        return $this->belongsTo(\App\Models\Consultation::class);
    }
}
