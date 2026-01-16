<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FicheIntervention
 *
 * @property int $id
 * @property int $user_id
 * @property int $patient_id
 * @property string $nom_patient
 * @property string $prenom_patient
 * @property string $sexe_patient
 * @property string $date_naiss_patient
 * @property int $portable_patient
 * @property string $type_intervention
 * @property string $dure_intervention
 * @property string $position_patient
 * @property string|null $decubitus
 * @property string|null $laterale
 * @property string|null $lombotomie
 * @property string $date_intervention
 * @property string $medecin
 * @property string $aide_op
 * @property string|null $hospitalisation
 * @property string|null $ambulatoire
 * @property string $anesthesie
 * @property string|null $recommendation
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Patient $patient
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FicheIntervention newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FicheIntervention newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FicheIntervention query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FicheIntervention whereAideOp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FicheIntervention whereAmbulatoire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FicheIntervention whereAnesthesie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FicheIntervention whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FicheIntervention whereDateIntervention($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FicheIntervention whereDateNaissPatient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FicheIntervention whereDecubitus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FicheIntervention whereDureIntervention($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FicheIntervention whereHospitalisation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FicheIntervention whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FicheIntervention whereLaterale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FicheIntervention whereLombotomie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FicheIntervention whereMedecin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FicheIntervention whereNomPatient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FicheIntervention wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FicheIntervention wherePortablePatient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FicheIntervention wherePositionPatient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FicheIntervention wherePrenomPatient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FicheIntervention whereRecommendation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FicheIntervention whereSexePatient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FicheIntervention whereTypeIntervention($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FicheIntervention whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FicheIntervention whereUserId($value)
 * @mixin \Eloquent
 */
class FicheIntervention extends Model
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
