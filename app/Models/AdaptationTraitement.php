<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AdaptationTraitement
 *
 * @property int $id
 * @property int $user_id
 * @property int $patient_id
 * @property string $medicament_posologie_dosage
 * @property string|null $arret
 * @property string|null $poursuivre
 * @property string|null $continuer
 * @property string|null $j
 * @property string|null $j0
 * @property string|null $j1
 * @property string|null $j2
 * @property string|null $m
 * @property string|null $mi
 * @property string|null $n
 * @property string|null $s
 * @property string|null $m1
 * @property string|null $mi1
 * @property string|null $s1
 * @property string|null $n1
 * @property string $date
 * @property-read \App\Models\Patient $patient
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement whereArret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement whereContinuer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement whereJ($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement whereJ0($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement whereJ1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement whereJ2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement whereM($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement whereM1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement whereMedicamentPosologieDosage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement whereMi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement whereMi1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement whereN1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement wherePoursuivre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement whereS($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement whereS1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement whereUserId($value)
 * @mixin \Eloquent
 */
class AdaptationTraitement extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
