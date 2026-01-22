<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Examen
 *
 * @property int $id
 * @property int $patient_id
 * @property string $type
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Patient $patient
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Examen newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Examen newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Examen query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Examen whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Examen whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Examen whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Examen wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Examen whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Examen whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Examen extends Model
{
    protected $fillable = [
        
        'image',
        'nom',
        'description',
    ];


    public function patient()
    {
        return $this->belongsTo(\App\Models\Patient::class);
    }
}
