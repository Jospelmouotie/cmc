<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Consultation
 *
 * @property int $id
 * @property int $patient_id
 * @property int $user_id
 * @property string $diagnostic
 * @property string $interrogatoire
 * @property string|null $antecedent_m
 * @property string|null $antecedent_c
 * @property string $medecin_r
 * @property string|null $allergie
 * @property string|null $groupe
 * @property string $proposition_therapeutique
 * @property string $proposition
 * @property string|null $examen_p
 * @property string|null $examen_c
 * @property string|null $motif_c
 * @property string|null $date_intervention
 * @property string|null $date_consultation
 * @property string|null $date_consultation_anesthesiste
 * @property string|null $acte
 * @property string|null $type_intervention
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Chambre $chambres
 * @property-read \App\Models\Patient $patient
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Consultation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Consultation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Consultation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Consultation whereActe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Consultation whereAllergie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Consultation whereAntecedentC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Consultation whereAntecedentM($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Consultation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Consultation whereDateConsultation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Consultation whereDateConsultationAnesthesiste($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Consultation whereDateIntervention($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Consultation whereDiagnostic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Consultation whereExamenC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Consultation whereExamenP($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Consultation whereGroupe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Consultation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Consultation whereInterrogatoire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Consultation whereMedecinR($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Consultation whereMotifC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Consultation wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Consultation whereProposition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Consultation wherePropositionTherapeutique($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Consultation whereTypeIntervention($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Consultation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Consultation whereUserId($value)
 * @mixin \Eloquent
 */
class Consultation extends Model
{

	protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function patient()
    {
        return $this->belongsTo(\App\Models\Patient::class);
    }

    public function chambres()
    {
        return $this->belongsTo(\App\Models\Chambre::class);
    }

    // public function devis()
    // {
    //     return $this->belongsTo(\App\Models\Devis::class);
    // }

}

