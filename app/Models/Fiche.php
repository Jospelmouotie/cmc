<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Fiche
 *
 * @property int $id
 * @property string $nom
 * @property string $prenom
 * @property string $chambre_numero
 * @property int $age
 * @property string $service
 * @property string $infirmier_charge
 * @property string $accueil
 * @property string $restauration
 * @property string $chambre
 * @property string $soins
 * @property int $notes
 * @property string $quizz
 * @property string $remarque_suggestion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id
 * @property-read \App\Models\User $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fiche newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fiche newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fiche query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fiche whereAccueil($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fiche whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fiche whereChambre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fiche whereChambreNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fiche whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fiche whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fiche whereInfirmierCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fiche whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fiche whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fiche wherePrenom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fiche whereQuizz($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fiche whereRemarqueSuggestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fiche whereRestauration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fiche whereService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fiche whereSoins($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fiche whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fiche whereUserId($value)
 * @mixin \Eloquent
 */
class Fiche extends Model
{
    protected $fillable = [
        'nom',
        'prenom',
        'chambre_numero',
        'age',
        'service',
        'infirmier_charge',
        'accueil',
        'restauration',
        'chambre',
        'soins',
        'notes',
        'quizz',
        'remarque_suggestion'
    ];

    public function users()
    {
        return $this->belongsTo('App\Models\User');
    }
}
