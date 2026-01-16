<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ConsultationAnesthesiste
 *
 * @property int $id
 * @property int $user_id
 * @property int $patient_id
 * @property string $specialite
 * @property string $medecin_traitant
 * @property string $operateur
 * @property string $date_intervention
 * @property string $motif_admission
 * @property string|null $memo
 * @property string $anesthesi_salle
 * @property string $risque
 * @property string|null $solide
 * @property string|null $liquide
 * @property string $benefice_risque
 * @property string|null $adaptation_traitement
 * @property string $technique_anesthesie
 * @property string $technique_anesthesie1
 * @property string $synthese_preop
 * @property string|null $date_hospitalisation
 * @property string|null $service
 * @property string|null $classe_asa
 * @property string $antecedent_traitement
 * @property string $examen_clinique
 * @property string|null $allergie
 * @property string $traitement_en_cours
 * @property string|null $antibiotique
 * @property string|null $jeune_preop
 * @property string|null $autre1
 * @property string|null $examen_paraclinique
 * @property string|null $intubation
 * @property string|null $mallampati
 * @property string|null $distance_interincisive
 * @property string|null $distance_thyromentoniere
 * @property string|null $mobilite_servicale
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Patient $patient
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConsultationAnesthesiste newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConsultationAnesthesiste newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConsultationAnesthesiste query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConsultationAnesthesiste whereAdaptationTraitement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConsultationAnesthesiste whereAllergie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConsultationAnesthesiste whereAnesthesiSalle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConsultationAnesthesiste whereAntecedentTraitement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConsultationAnesthesiste whereAntibiotique($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConsultationAnesthesiste whereAutre1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConsultationAnesthesiste whereBeneficeRisque($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConsultationAnesthesiste whereClasseAsa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConsultationAnesthesiste whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConsultationAnesthesiste whereDateHospitalisation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConsultationAnesthesiste whereDateIntervention($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConsultationAnesthesiste whereDistanceInterincisive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConsultationAnesthesiste whereDistanceThyromentoniere($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConsultationAnesthesiste whereExamenClinique($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConsultationAnesthesiste whereExamenParaclinique($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConsultationAnesthesiste whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConsultationAnesthesiste whereIntubation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConsultationAnesthesiste whereJeunePreop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConsultationAnesthesiste whereLiquide($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConsultationAnesthesiste whereMallampati($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConsultationAnesthesiste whereMedecinTraitant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConsultationAnesthesiste whereMemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConsultationAnesthesiste whereMobiliteServicale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConsultationAnesthesiste whereMotifAdmission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConsultationAnesthesiste whereOperateur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConsultationAnesthesiste wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConsultationAnesthesiste whereRisque($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConsultationAnesthesiste whereService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConsultationAnesthesiste whereSolide($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConsultationAnesthesiste whereSpecialite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConsultationAnesthesiste whereSynthesePreop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConsultationAnesthesiste whereTechniqueAnesthesie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConsultationAnesthesiste whereTechniqueAnesthesie1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConsultationAnesthesiste whereTraitementEnCours($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConsultationAnesthesiste whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConsultationAnesthesiste whereUserId($value)
 * @mixin \Eloquent
 */
class ConsultationAnesthesiste extends Model
{
    protected $guarded =[];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function patient()
    {
        return $this->belongsTo(\App\Models\Patient::class);
    }
}
