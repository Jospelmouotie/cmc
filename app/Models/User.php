<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * Les attributs qui peuvent être assignés en masse.
     * Ajout de role_id pour permettre l'enregistrement via les contrôleurs.
     */
    protected $fillable = [
        'name',
        'prenom',
        'login',
        'telephone',
        'sexe',
        'lieu_naissance',
        'date_naissance',
        'password',
        'specialite',
        'onmc',
        'role_id'
    ];

    /**
     * Les attributs cachés pour les tableaux.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Le cast des attributs.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $table = 'users';

    // --- RELATIONS ---

    public function role()
    {
        return $this->belongsTo(\App\Models\Role::class, 'role_id');
    }

    public function events()
    {
        return $this->hasMany(\App\Models\Event::class);
    }

    public function patients()
    {
        return $this->hasMany(\App\Models\Patient::class);
    }

    public function consultations()
    {
        return $this->hasMany(\App\Models\Consultation::class);
    }

    public function ordonances()
    {
        return $this->hasMany(\App\Models\Ordonance::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(\App\Models\Prescription::class);
    }

    public function facture_consultations()
    {
        return $this->hasMany(\App\Models\FactureConsultation::class);
    }

    // --- LOGIQUE MÉTIER / RÔLES ---

    /**
     * Vérifie si l'utilisateur est un Médecin (Role ID 2)
     */
    public function isMedecin()
    {
        return $this->role_id === 2;
    }

    /**
     * Vérifie si l'utilisateur est un Administrateur (Role ID 1)
     */
    public function isAdmin()
    {
        return $this->role_id === 1;
    }

    public function isPharmacien()
    {
        return $this->role_id === 7;
    }

    public function isGestionnaire()
    {
        return $this->role_id === 3;
    }

    public function isCaisse()
    {
        return $this->role_id === 9;
    }

    public function isLogistique()
    {
        return $this->role_id === 5;
    }

    /**
     * Vérifications de spécialités médicales
     */
    public function isAnesthesiste()
    {
        return $this->isMedecin() && stripos($this->specialite, 'anesthé') !== false;
    }

    public function isChirurgien()
    {
        return $this->isMedecin() && (stripos($this->specialite, 'chirurg') !== false || stripos($this->specialite, 'urolog') !== false);
    }

    /**
     * Liste des spécialités disponibles (Statique)
     */
    public static function getSpecialites()
    {
        return [
            'Anesthésiste' => 'Anesthésiste',
            'Chirurgien urologue' => 'Chirurgien urologue',
            'Chirurgien général' => 'Chirurgien général',
            'Médecin généraliste' => 'Médecin généraliste',
            'Pédiatre' => 'Pédiatre',
            'Cardiologue' => 'Cardiologue',
            'Gynécologue' => 'Gynécologue',
            'Autre' => 'Autre',
        ];
    }
}
