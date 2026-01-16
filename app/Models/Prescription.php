<?php

namespace App\Models;

use Illuminate\Database\eloquent\model;

/**
 * App\Models\Prescription
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $patient_id
 * @property string|null $hematologie
 * @property string|null $hemostase
 * @property string|null $biochimie
 * @property string|null $hormonologie
 * @property string|null $marqueurs
 * @property string|null $bacteriologie
 * @property string|null $spermiologie
 * @property string|null $urines
 * @property string|null $serologie
 * @property string|null $examen
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Patient|null $patient
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Prescription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Prescription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Prescription query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Prescription whereBacteriologie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Prescription whereBiochimie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Prescription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Prescription whereExamen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Prescription whereHematologie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Prescription whereHemostase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Prescription whereHormonologie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Prescription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Prescription whereMarqueurs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Prescription wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Prescription whereSerologie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Prescription whereSpermiologie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Prescription whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Prescription whereUrines($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Prescription whereUserId($value)
 * @mixin \Eloquent
 */
class Prescription extends model
{
    protected $fillable = [
        'patient_id',
        'user_id',
        'hematologie' ,
        'hemostase',
        'biochimie',
        'hormonologie',
        'marqueurs',
        'bacteriologie',
        'spermiologie',
        'urines',
        'serologie',
        'examen',
       
    ] ;

   
    public function patient()
    {
        return $this->belongsTo(\App\Models\Patient::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
