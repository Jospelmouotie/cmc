<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Intervention
 *
 * @property int $id
 * @property int $patient_id
 * @property string $traitement_sortie
 * @property string $suite_operatoire
 * @property string $sortie
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Patient $patient
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Intervention newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Intervention newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Intervention query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Intervention whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Intervention whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Intervention wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Intervention whereSortie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Intervention whereSuiteOperatoire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Intervention whereTraitementSortie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Intervention whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Intervention extends Model
{
    protected $guarded = [];

    public function patient()
    {
        return $this->belongsTo(\App\Models\Patient::class);
    }
}
