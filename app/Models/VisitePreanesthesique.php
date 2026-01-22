<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\VisitePreanesthesique
 *
 * @property int $id
 * @property int $user_id
 * @property int $patient_id
 * @property string $date_visite
 * @property string $element_nouveaux
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Patient $patient
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VisitePreanesthesique newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VisitePreanesthesique newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VisitePreanesthesique query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VisitePreanesthesique whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VisitePreanesthesique whereDateVisite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VisitePreanesthesique whereElementNouveaux($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VisitePreanesthesique whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VisitePreanesthesique wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VisitePreanesthesique whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VisitePreanesthesique whereUserId($value)
 * @mixin \Eloquent
 */
class VisitePreanesthesique extends Model
{
    protected $guarded = [];

    public function patient()
    {
        return $this->belongsTo(\App\Models\Patient::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
