<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Devi extends Model
{
    protected $fillable = [
        'user_id',
        'patient_id',
        'medecin_id',
        'nom',
        'code',
        'acces',
        'statut',
        'pourcentage_reduction',
        'montant_avant_reduction',
        'montant_apres_reduction',
        'date_validation',
        'validateur_id',
        'commentaire_medecin',
        'nbr_jour_hosp',
        'pu_chambre',
        'pu_visite',
        'pu_ami_jour',
        'nbr_chambre',
        'nbr_visite',
        'nbr_ami_jour'
    ];

    protected $casts = [
        'date_validation' => 'datetime'
    ];

    /**
     * Get the user (gestionnaire) who created this devis
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the patient
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the assigned doctor
     */
    public function medecin()
    {
        return $this->belongsTo(User::class, 'medecin_id');
    }

    /**
     * Get the validator (doctor who validated)
     */
    public function validateur()
    {
        return $this->belongsTo(User::class, 'validateur_id');
    }

    /**
     * Get the line items
     */
    public function ligneDevis()
    {
        return $this->hasMany(LigneDevi::class, 'devi_id');
    }




    /**
     * Calculate total before reduction
     */
    public function calculerMontantAvantReduction()
    {
        $total = $this->ligneDevis()->sum(\DB::raw('quantite * prix_u'));

        // Add hospitalization costs
        $total += ($this->nbr_chambre ?? 0) * ($this->pu_chambre ?? 0);
        $total += ($this->nbr_visite ?? 0) * ($this->pu_visite ?? 0);
        $total += ($this->nbr_ami_jour ?? 0) * ($this->pu_ami_jour ?? 0);

        return $total;
    }

    /**
     * Calculate total after reduction
     */
    public function calculerMontantApresReduction()
    {
        $montant = $this->montant_avant_reduction;
        $reduction = ($montant * $this->pourcentage_reduction) / 100;
        return $montant - $reduction;
    }

    /**
     * Apply reduction
     */
    public function appliquerReduction($pourcentage, $validateur_id, $commentaire = null)
    {
        $this->pourcentage_reduction = $pourcentage;
        $this->montant_apres_reduction = $this->calculerMontantApresReduction();
        $this->validateur_id = $validateur_id;
        $this->commentaire_medecin = $commentaire;
        $this->save();
    }

    /**
     * Validate devis
     */
    public function valider($validateur_id, $commentaire = null)
    {
        $this->statut = 'valide';
        $this->date_validation = now();
        $this->validateur_id = $validateur_id;
        $this->commentaire_medecin = $commentaire;
        $this->save();
    }

    /**
     * Refuse devis
     */
    public function refuser($validateur_id, $commentaire)
    {
        $this->statut = 'refuse';
        $this->date_validation = now();
        $this->validateur_id = $validateur_id;
        $this->commentaire_medecin = $commentaire;
        $this->save();
    }



    /**
     * Cancel refusal and return to brouillon (for editing)
     */
    public function annulerRefus()
    {
        $this->statut = 'brouillon';
        $this->date_validation = null;
        $this->validateur_id = null;
        $this->commentaire_medecin = null;
        $this->save();
    }

    /**
     * Send for validation
     */
    public function envoyerValidation()
    {
        $this->statut = 'en_attente';
        $this->save();
    }

    /**
     * Scope for pending validation
     */
    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

    /**
     * Scope for validated
     */
    public function scopeValide($query)
    {
        return $query->where('statut', 'valide');
    }

    /**
     * Scope for a specific doctor
     */
    public function scopePourMedecin($query, $medecin_id)
    {
        return $query->where('medecin_id', $medecin_id);
    }
}








