<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TraitementHospitalisation
 *
 * @property int $id
 * @property int $user_id
 * @property int $patient_id
 * @property string $medicament_posologie_dosage
 * @property int|null $duree
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TraitementHospitalisation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TraitementHospitalisation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TraitementHospitalisation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TraitementHospitalisation whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TraitementHospitalisation whereDuree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TraitementHospitalisation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TraitementHospitalisation whereJ($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TraitementHospitalisation whereJ0($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TraitementHospitalisation whereJ1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TraitementHospitalisation whereJ2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TraitementHospitalisation whereM($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TraitementHospitalisation whereM1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TraitementHospitalisation whereMedicamentPosologieDosage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TraitementHospitalisation whereMi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TraitementHospitalisation whereMi1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TraitementHospitalisation whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TraitementHospitalisation whereN1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TraitementHospitalisation wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TraitementHospitalisation whereS($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TraitementHospitalisation whereS1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TraitementHospitalisation whereUserId($value)
 * @mixin \Eloquent
 */
class TraitementHospitalisation extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    public function patient()
    {
        return $this->belongsTo(\App\Models\Patient::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
