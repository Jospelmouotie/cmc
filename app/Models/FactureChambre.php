<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FactureChambre
 *
 * @property int $id
 * @property int $user_id
 * @property int $patient_id
 * @property int $numero
 * @property string $date_entre
 * @property string $date_sortie
 * @property int $jour
 * @property int $tarif
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Patient $patient
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureChambre newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureChambre newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureChambre query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureChambre whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureChambre whereDateEntre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureChambre whereDateSortie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureChambre whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureChambre whereJour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureChambre whereNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureChambre wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureChambre whereTarif($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureChambre whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureChambre whereUserId($value)
 * @mixin \Eloquent
 */
class FactureChambre extends Model
{
    protected $guarded = [];

    public function patient()
    {
        return $this->belongsTo(\App\Models\Patient::class);
    }
}
