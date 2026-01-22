<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Event
 *
 * @property int $id
 * @property string $title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id
 * @property int|null $patient_id
 * @property-read \App\Models\Patient|null $patients
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereUserId($value)
 * @mixin \Eloquent
 */
class Event extends Model
{

    protected $fillable = [
    'title',
    'start',
    'end',
    'user_id',
    'patient_id',
    'description',
    'objet',
    'statut',
    'state',
];

    protected $guarded = ['updated_at', 'created_at'];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function patients()
    {
        return $this->belongsTo(\App\Models\Patient::class, 'patient_id');
    }
}














