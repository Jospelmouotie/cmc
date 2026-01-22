<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Laravel\Scout\Searchable;


class User extends Authenticatable
{
    use Notifiable;
  
    protected $fillable = [
        'name', 'prenom', 'login', 'telephone', 'sexe', 'lieu_naissance', 'date_naissance', 'password', 'specialite', 'onmc'
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $table = 'users';


    public function roles()
    {
        return $this->belongsTo('App\Models\Role', 'role_id');
    }

    // public function devisimage()
    // {
    //     return $this->hasMany(\App\Models\DevisImage::class);
    // }
    public function events()
    {
        return $this->hasMany(\App\Models\Event::class);
    }

    public function produits()
    {
        return $this->belongsTo('App\Models\Produit');
    }

    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    public function fiches()
    {
        return $this->hasMany('App\Models\Fiche');
    }

    public function patients()
    {
        return $this->hasMany(\App\Models\Patient::class);
    }

    public function clients()
    {
        return $this->hasMany(\App\Models\Client::class);
    }

    public function fiche_interventions()
    {
        return $this->hasMany(\App\Models\FicheIntervention::class);
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

    // public function devis()
    // {
    //     return $this->hasMany(\App\Models\Devis::class);
    // }

    // public function devisd()
    // {
    //     return $this->hasMany(\App\Models\Devisd::class);
    // }

    public function consultations()
    {
        return $this->hasMany(\App\Models\Consultation::class);
    }

    public function consultation_anesthesistes()
    {
        return $this->hasMany(\App\Models\ConsultationAnesthesiste::class);
    }

    public function ordonances()
    { 
        return $this->hasMany(\App\Models\Ordonance::class);
    }

    public function compte_rendu_bloc_operatoires()
    {
        return $this->hasMany(\App\Models\CompteRenduBlocOperatoire::class);
    }
  
    public function fiche_consommables()
    {
        return $this->hasMany(\App\Models\FicheConsommable::class);
    }

    public function observation_medicales()
    {
        return $this->hasMany(\App\Models\ObservationMedicale::class);
    }

    public function surveillance_post_anesthesiques()
    {
        return $this->hasMany(\App\Models\SurveillancePostAnesthesique::class);
    }

    public function surveillance_rapproche_parametres()
    {
        return $this->hasMany(\App\Models\SurveillanceRapprocheParametre::class);
    }

    public function surveillance_scores()
    {
        return $this->hasMany(\App\Models\SurveillanceScore::class);
    }

    public function soins_infirmiers()
    {
        return $this->hasMany(\App\Models\SoinsInfirmier::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(\App\Models\Prescription::class);
    }

    // public function facture_devis()
    // {
    //     return $this->hasMany(\App\Models\FactureDevi::class);
    // }

    public function prescription_medicales()
    {
        return $this->hasMany(\App\Models\PrescriptionMedicale::class);
    }





    /**
     * Medical specialties constants
     */
    const SPECIALITE_ANESTHESISTE = 'Anesthésiste';
    const SPECIALITE_CHIRURGIEN_UROLOGUE = 'Chirurgien urologue';
    const SPECIALITE_CHIRURGIEN_GENERAL = 'Chirurgien général';
    const SPECIALITE_MEDECIN_GENERALISTE = 'Médecin généraliste';
    const SPECIALITE_PEDIATRE = 'Pédiatre';
    const SPECIALITE_CARDIOLOGUE = 'Cardiologue';
    const SPECIALITE_GYNECOLOGUE = 'Gynécologue';
    const SPECIALITE_AUTRE = 'Autre';

    /**
     * Get all available specialties
     */
    public static function getSpecialites()
    {
        return [
            self::SPECIALITE_ANESTHESISTE => 'Anesthésiste',
            self::SPECIALITE_CHIRURGIEN_UROLOGUE => 'Chirurgien urologue',
            self::SPECIALITE_CHIRURGIEN_GENERAL => 'Chirurgien général',
            self::SPECIALITE_MEDECIN_GENERALISTE => 'Médecin généraliste',
            self::SPECIALITE_PEDIATRE => 'Pédiatre',
            self::SPECIALITE_CARDIOLOGUE => 'Cardiologue',
            self::SPECIALITE_GYNECOLOGUE => 'Gynécologue',
            self::SPECIALITE_AUTRE => 'Autre',
        ];
    }



    /**
     * Check if user is an anesthésiste
     */
    public function isAnesthesiste()
    {
        return $this->role_id === 2 && 
            stripos($this->specialite, 'anesthé') !== false;
    }

    /**
     * Check if user is a chirurgien (any surgical specialty)
     */
    public function isChirurgien()
    {
        return $this->role_id === 2 && 
            (stripos($this->specialite, 'chirurg') !== false || 
                stripos($this->specialite, 'urolog') !== false);
    }

    /**
     * Check if user is a pédiatre
     */
    public function isPediatre()
    {
        return $this->role_id === 2 && 
            stripos($this->specialite, 'pédiatre') !== false;
    }

    /**
     * Check if user is a généraliste
     */
    public function isGeneraliste()
    {
        return $this->role_id === 2 && 
            stripos($this->specialite, 'généraliste') !== false;
    }

    /**
     * Check if user is any type of médecin
     */
    public function isMedecin()
    {
        return $this->role_id === 2;

        
    }


    public function isAdmin()
    {
        return Auth::user()->role_id === 1;

    }
    public function isPharmacien()
    {
        return Auth::user()->role_id === 7;

    }

    public function isGestionnaire()
    {
        return Auth::user()->role_id === 3;

    }

    public function isCaisse()
    {
        return Auth::user()->role_id === 9;

    }

    public function isLogistique()
    {
        return Auth::user()->role_id === 5;

    }

    public function facture_consultations()
    {
        return $this->hasMany(\App\Models\FactureConsultation::class);
    }

    public function facture_clients()
    {
        return $this->hasMany(\App\Models\FactureClient::class);
    }

    public function consultationdesuivi()
    {
        return $this->hasMany(\App\Models\ConsultationSuivi::class);
    }


}












