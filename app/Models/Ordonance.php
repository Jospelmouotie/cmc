<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Ordonance
 *
 * @property int $id
 * @property int $user_id
 * @property int $patient_id
 * @property string $description
 * @property string $medicament
 * @property string $quantite
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Patient $patient
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ordonance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ordonance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ordonance query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ordonance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ordonance whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ordonance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ordonance whereMedicament($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ordonance wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ordonance whereQuantite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ordonance whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ordonance whereUserId($value)
 * @mixin \Eloquent
 */
class Ordonance extends Model
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
