<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\FactureConsultation
 *
 * @property int $id
 * @property int $user_id
 * @property int $patient_id
 * @property int $numero
 * @property string $motif
 * @property string $montant
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $avance
 * @property int|null $reste
 * @property string|null $assurance
 * @property int|null $assurancec
 * @property int|null $assurec
 * @property string|null $demarcheur
 * @property string|null $prenom
 * @property string|null $date_insertion
 * @property-read \App\Models\Patient $patient
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureConsultation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureConsultation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureConsultation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureConsultation whereAssurance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureConsultation whereAssurancec($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureConsultation whereAssurec($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureConsultation whereAvance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureConsultation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureConsultation whereDateInsertion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureConsultation whereDemarcheur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureConsultation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureConsultation whereMontant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureConsultation whereMotif($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureConsultation whereNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureConsultation wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureConsultation wherePrenom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureConsultation whereReste($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureConsultation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureConsultation whereUserId($value)
 * @mixin \Eloquent
 */
class FactureConsultation extends Model
{   

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $guarded = [];


    public function patient()
    {
        return $this->belongsTo(\App\Models\Patient::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function historiques()
    {
        return $this->hasMany(\App\Models\HistoriqueFacture::class);
    }

    public static function calculReste($assurec, $avance){
        return $assurec - $avance;
    }

    public static function calculAssurec( $montant, $prise_en_charge){
        // $prise_en_charge est le taux de prise en charge des soins par l'assurance
        return  ((float)$montant * ((100-(float)$prise_en_charge) / 100)); // assurec => part patient
    }

    public static function calculAssurancec($montant, $prise_en_charge){
        // $prise_en_charge est le taux de prise en charge des soins par l'assurance
        return ((float)$montant * (((float)$prise_en_charge) / 100));// assurancec => part assurance}
    }
}
