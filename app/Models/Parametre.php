<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Parametre
 *
 * @property int $id
 * @property int $user_id
 * @property int $patient_id
 * @property float $poids
 * @property float $taille
 * @property string $bras_gauche
 * @property string $bras_droit
 * @property string $inc_bmi
 * @property string $date_naissance
 * @property int $age
 * @property string $temperature
 * @property string|null $fr
 * @property string|null $fc
 * @property string|null $spo2
 * @property string|null $glycemie
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Patient $patient
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parametre newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parametre newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parametre query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parametre whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parametre whereBrasDroit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parametre whereBrasGauche($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parametre whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parametre whereDateNaissance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parametre whereFc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parametre whereFr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parametre whereGlycemie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parametre whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parametre whereIncBmi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parametre wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parametre wherePoids($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parametre whereSpo2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parametre whereTaille($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parametre whereTemperature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parametre whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parametre whereUserId($value)
 * @mixin \Eloquent
 */
class Parametre extends Model
{
    protected $fillable = [
        'user_id', 'patient_id', 'poids', 'temperature', 'fc', 'fr', 'spo2', 'glycemie', 'bras_gauche', 'bras_droit', 'date_naissance', 'age', 'inc_bmi', 'taille'
    ];

    public function patient()
    {
        return $this->belongsTo(\App\Models\Patient::class);
    }
}
