<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Premedication
 *
 * @property int $id
 * @property int $user_id
 * @property int $patient_id
 * @property string $consigne_ide
 * @property string $preparation
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Patient $patient
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Premedication newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Premedication newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Premedication query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Premedication whereConsigneIde($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Premedication whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Premedication whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Premedication wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Premedication wherePreparation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Premedication whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Premedication whereUserId($value)
 * @mixin \Eloquent
 */
class Premedication extends Model
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
