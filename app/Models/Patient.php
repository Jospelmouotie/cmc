<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Patient extends Model
{
    protected $fillable = [
        'numero_dossier',
        'name',
        'prenom',
        'mode_paiement',
        'mode_paiement_info_sup',
        'assurance',
        'assurancec',
        'assurec',
        'numero_assurance',
        'prise_en_charge',
        'user_id',
        'telephone',
        'motif',
        'details_motif',
        'montant',
        'avance',
        'reste',
        'reste1',
        'demarcheur',
        'date_insertion',
        'medecin_r',
        'image',
    ];

    // public function devisimage()
    // {
    //     return $this->hasMany(\App\Models\DevisImage::class);
    // }
    public function facture_consultations()
    {
        return $this->hasMany(\App\Models\FactureConsultation::class);
    }

    public function facture_chambres()
    {
        return $this->hasMany(\App\Models\FactureConsultation::class);
    }

    // public function devis()
    // {
    //     return $this->hasMany(\App\Models\Devis::class);
    // }
    // public function devisd()
    // {
    //     return $this->hasMany(\App\Models\Devisd::class, 'patient_id');
    // }

    // public function soins()
    // {
    //     return $this->hasMany(\App\Models\Soin::class);
    // }

    public function examens()
    {
        return $this->hasMany(\App\Models\Examen::class);
    }

    public function consultations()
    {
        return $this->hasMany(\App\Models\Consultation::class);
    }

    public function consultation_anesthesistes()
    {
        return $this->hasMany(\App\Models\ConsultationAnesthesiste::class);
    }



    public function imageries()
    {
        return $this->hasMany(\App\Models\Imagerie::class);
    }
    public function isNew()
{
    // Si le patient a été créé il y a moins de 24 heures
    return $this->created_at >= now()->subDay();
}

    public function compte_rendu_bloc_operatoires()
    {
        return $this->hasMany(\App\Models\CompteRenduBlocOperatoire::class);
    }

    public function interventions()
    {
        return $this->hasMany(\App\Models\Intervention::class);
    }

    public function ordonances()
    {
        return $this->hasMany(\App\Models\Ordonance::class);
    }

    public function fiche_interventions()
    {
        return $this->hasMany(\App\Models\FicheIntervention::class);
    }

    // public function facture_devis()
    // {
    //     return $this->hasMany(\App\Models\FactureDevi::class);
    // }

    public function fiche_prescription_medicale()
    {
        return $this->hasOne(FichePrescriptionMedicale::class);
    }

    public function visite_preanesthesiques()
    {
        return $this->hasMany(\App\Models\VisitePreanesthesique::class);
    }

    public function premedications()
    {
        return $this->hasMany(\App\Models\Premedication::class);
    }

    public function traitement_hospitalisations()
    {
        return $this->hasMany(\App\Models\TraitementHospitalisation::class);
    }
    public function adaptation_traitements()
    {
        return $this->hasMany(\App\Models\AdaptationTraitement::class);
    }

    public function parametres()
    {
        return $this->hasMany(\App\Models\Parametre::class);
    }

    public function dossiers()
    {
        return $this->hasMany(\App\Models\Dossier::class);
    }

    public function fiche_consommables()
    {
        return $this->hasMany(\App\Models\FicheConsommable::class);
    }

    public function observation_medicales()
    {
        return $this->hasMany(\App\Models\ObservationMedicale::class);
    }

    public function soins_infirmiers()
    {
        return $this->hasMany(\App\Models\SoinsInfirmier::class);
    }

    public function surveillance_post_anesthesiques()
    {
        return $this->hasMany(\App\Models\SurveillancePostAnesthesique::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }


    public function consultationdesuivi()
    {
        return $this->hasMany(\App\Models\ConsultationSuivi::class);
    }

    public function event()
    {
        return $this->hasMany(\App\Models\Event::class);
    }

    public function surveillance_rapproche_parametres()
    {
        return $this->hasMany(\App\Models\SurveillanceRapprocheParametre::class);
    }

    public function surveillance_scores()
    {
        return $this->hasMany(\App\Models\SurveillanceScore::class);
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans;
    }
    public function isMedecin()
    {
        return Auth::user()->role_id === 2;

    }
// Un patient appartient à un créateur (User)


// Dans App\Models\Patient.php
// Remplace 'public function prescriptions()' par :
public function prescriptions()
{
    return $this->prescription_medicales();
}

public function prescription_medicales()
{
    return $this->hasManyThrough(
        \App\Models\PrescriptionMedicale::class,
        \App\Models\FichePrescriptionMedicale::class,
        'patient_id',
        'fiche_prescription_medicale_id',
        'id',
        'id'
    );
}
}
