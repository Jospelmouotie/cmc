<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\AdaptationTraitement
 *
 * @property int $id
 * @property int $user_id
 * @property int $patient_id
 * @property string $medicament_posologie_dosage
 * @property string|null $arret
 * @property string|null $poursuivre
 * @property string|null $continuer
 * @property string|null $j
 * @property string|null $j0
 * @property string|null $j1
 * @property string|null $j2
 * @property string|null $m
 * @property string|null $mi
 * @property string|null $n
 * @property string|null $s
 * @property string|null $m1
 * @property string|null $mi1
 * @property string|null $s1
 * @property string|null $n1
 * @property string $date
 * @property-read \App\Models\Patient $patient
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement whereArret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement whereContinuer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement whereJ($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement whereJ0($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement whereJ1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement whereJ2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement whereM($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement whereM1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement whereMedicamentPosologieDosage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement whereMi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement whereMi1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement whereN1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement wherePoursuivre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement whereS($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement whereS1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdaptationTraitement whereUserId($value)
 * @mixin \Eloquent
 */
	class AdaptationTraitement extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $prescription_medicale_id
 * @property int $user_id
 * @property string|null $matin
 * @property string|null $apre_midi
 * @property string|null $soir
 * @property string|null $nuit
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminPrescriptionMedicale newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminPrescriptionMedicale newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminPrescriptionMedicale query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminPrescriptionMedicale whereApreMidi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminPrescriptionMedicale whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminPrescriptionMedicale whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminPrescriptionMedicale whereMatin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminPrescriptionMedicale whereNuit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminPrescriptionMedicale wherePrescriptionMedicaleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminPrescriptionMedicale whereSoir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminPrescriptionMedicale whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminPrescriptionMedicale whereUserId($value)
 */
	class AdminPrescriptionMedicale extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Chambre
 *
 * @property int $id
 * @property int $user_id
 * @property string $numero
 * @property string $categorie
 * @property string|null $patient
 * @property int|null $prix
 * @property int|null $jour
 * @property string $statut
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Consultation $consultations
 * @property-read \App\Models\User $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chambre newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chambre newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chambre query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chambre whereCategorie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chambre whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chambre whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chambre whereJour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chambre whereNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chambre wherePatient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chambre wherePrix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chambre whereStatut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chambre whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chambre whereUserId($value)
 * @mixin \Eloquent
 */
	class Chambre extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CleActivation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CleActivation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CleActivation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CleActivation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CleActivation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CleActivation whereUpdatedAt($value)
 */
	class CleActivation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Client
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $nom
 * @property string|null $prenom
 * @property string|null $motif
 * @property int|null $montant
 * @property int|null $avance
 * @property int|null $reste
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FactureClient[] $facture_client
 * @property-read int|null $facture_client_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereAvance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereMontant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereMotif($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client wherePrenom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereReste($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereUserId($value)
 * @mixin \Eloquent
 * @property int|null $partassurance
 * @property int|null $partpatient
 * @property int|null $assurance
 * @property string|null $demarcheur
 * @property string|null $numero_assurance
 * @property string|null $prise_en_charge
 * @property string|null $date_insertion
 * @property string|null $medecin_r
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FactureClient> $facture_clients
 * @property-read int|null $facture_clients_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereAssurance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereDateInsertion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereDemarcheur($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereMedecinR($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereNumeroAssurance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client wherePartassurance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client wherePartpatient($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client wherePriseEnCharge($value)
 */
	class Client extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $patient_id
 * @property string $chirurgien
 * @property string $aide_op
 * @property string $anesthesiste
 * @property string $infirmier_anesthesiste
 * @property string $date_intervention
 * @property string $dure_intervention
 * @property string $compte_rendu_o
 * @property string $indication_operatoire
 * @property string|null $resultat_histo
 * @property string $suite_operatoire
 * @property string|null $traitement_propose
 * @property string|null $soins
 * @property string $date_e
 * @property string $date_s
 * @property string $type_e
 * @property string $type_s
 * @property string $conclusion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $type_intervention
 * @property string|null $titre_intervention
 * @property string|null $proposition_suivi
 * @property-read \App\Models\Patient|null $patient
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompteRenduBlocOperatoire newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompteRenduBlocOperatoire newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompteRenduBlocOperatoire query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompteRenduBlocOperatoire whereAideOp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompteRenduBlocOperatoire whereAnesthesiste($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompteRenduBlocOperatoire whereChirurgien($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompteRenduBlocOperatoire whereCompteRenduO($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompteRenduBlocOperatoire whereConclusion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompteRenduBlocOperatoire whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompteRenduBlocOperatoire whereDateE($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompteRenduBlocOperatoire whereDateIntervention($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompteRenduBlocOperatoire whereDateS($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompteRenduBlocOperatoire whereDureIntervention($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompteRenduBlocOperatoire whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompteRenduBlocOperatoire whereIndicationOperatoire($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompteRenduBlocOperatoire whereInfirmierAnesthesiste($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompteRenduBlocOperatoire wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompteRenduBlocOperatoire wherePropositionSuivi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompteRenduBlocOperatoire whereResultatHisto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompteRenduBlocOperatoire whereSoins($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompteRenduBlocOperatoire whereSuiteOperatoire($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompteRenduBlocOperatoire whereTitreIntervention($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompteRenduBlocOperatoire whereTraitementPropose($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompteRenduBlocOperatoire whereTypeE($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompteRenduBlocOperatoire whereTypeIntervention($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompteRenduBlocOperatoire whereTypeS($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompteRenduBlocOperatoire whereUpdatedAt($value)
 */
	class CompteRenduBlocOperatoire extends \Eloquent {}
}

namespace App\Models{
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
 * @property int|null $devis_id
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereDevisId($value)
 */
	class Consultation extends \Eloquent {}
}

namespace App\Models{
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
	class ConsultationAnesthesiste extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $patient_id
 * @property int $user_id
 * @property string $interrogatoire
 * @property string $commentaire
 * @property string $date_creation
 * @property-read \App\Models\Patient|null $patient
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationSuivi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationSuivi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationSuivi query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationSuivi whereCommentaire($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationSuivi whereDateCreation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationSuivi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationSuivi whereInterrogatoire($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationSuivi wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationSuivi whereUserId($value)
 */
	class ConsultationSuivi extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_id
 * @property int $nbr_jour_hosp
 * @property int $pu_chambre
 * @property int $pu_visite
 * @property int $pu_ami_jour
 * @property string $nom
 * @property string $acces
 * @property string $code
 * @property int $nbr_chambre
 * @property int $nbr_visite
 * @property int $nbr_ami_jour
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LigneDevi> $ligneDevis
 * @property-read int|null $ligne_devis_count
 * @property-read \App\Models\User|null $modifiePar
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Devi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Devi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Devi query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Devi whereAcces($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Devi whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Devi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Devi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Devi whereNbrAmiJour($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Devi whereNbrChambre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Devi whereNbrJourHosp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Devi whereNbrVisite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Devi whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Devi wherePuAmiJour($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Devi wherePuChambre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Devi wherePuVisite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Devi whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Devi whereUserId($value)
 */
	class Devi extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Dossier
 *
 * @property int $id
 * @property int $patient_id
 * @property string $sexe
 * @property string|null $personne_confiance
 * @property int|null $tel_personne_confiance
 * @property int|null $portable_1
 * @property int|null $portable_2
 * @property string|null $personne_contact
 * @property int|null $tel_personne_contact
 * @property string|null $profession
 * @property string|null $email
 * @property string|null $fax
 * @property string|null $adresse
 * @property string|null $lieu_naissance
 * @property string|null $date_naissance
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Patient $patients
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier whereAdresse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier whereDateNaissance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier whereFax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier whereLieuNaissance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier wherePersonneConfiance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier wherePersonneContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier wherePortable1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier wherePortable2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier whereProfession($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier whereSexe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier whereTelPersonneConfiance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier whereTelPersonneContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Dossier extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Event
 *
 * @property int $id
 * @property string $title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id
 * @property int|null $patient_id
 * @property-read \App\Models\Patient|null $patients
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereUserId($value)
 * @mixin \Eloquent
 * @property string $statut
 * @property string|null $objet
 * @property string|null $description
 * @property string|null $start
 * @property string|null $end
 * @property string $state
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereObjet($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereStatut($value)
 */
	class Event extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Examen
 *
 * @property int $id
 * @property int $patient_id
 * @property string $type
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Patient $patient
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Examen newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Examen newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Examen query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Examen whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Examen whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Examen whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Examen wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Examen whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Examen whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $nom
 * @property string $description
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Examen whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Examen whereNom($value)
 */
	class Examen extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Facture
 *
 * @property int $id
 * @property string|null $patient
 * @property int $user_id
 * @property int $numero
 * @property int $quantite_total
 * @property int $prix_total
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Produit[] $produits
 * @property-read int|null $produits_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Facture newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Facture newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Facture query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Facture whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Facture whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Facture whereNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Facture wherePatient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Facture wherePrixTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Facture whereQuantiteTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Facture whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Facture whereUserId($value)
 * @mixin \Eloquent
 */
	class Facture extends \Eloquent {}
}

namespace App\Models{
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
	class FactureChambre extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FactureClient
 *
 * @property int $id
 * @property int $user_id
 * @property int $client_id
 * @property string $nom
 * @property string|null $prenom
 * @property string $montant
 * @property string|null $avance
 * @property string|null $reste
 * @property string|null $motif
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Client $client
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureClient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureClient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureClient query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureClient whereAvance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureClient whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureClient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureClient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureClient whereMontant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureClient whereMotif($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureClient whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureClient wherePrenom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureClient whereReste($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureClient whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FactureClient whereUserId($value)
 * @mixin \Eloquent
 * @property int|null $partassurance
 * @property int|null $partpatient
 * @property int|null $assurance
 * @property string|null $demarcheur
 * @property string|null $numero_assurance
 * @property string|null $prise_en_charge
 * @property string|null $date_insertion
 * @property string|null $medecin_r
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactureClient whereAssurance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactureClient whereDateInsertion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactureClient whereDemarcheur($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactureClient whereMedecinR($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactureClient whereNumeroAssurance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactureClient wherePartassurance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactureClient wherePartpatient($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactureClient wherePriseEnCharge($value)
 */
	class FactureClient extends \Eloquent {}
}

namespace App\Models{
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
 * @property string|null $medecin_r
 * @property string|null $details_motif
 * @property string|null $statut
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $mode_paiement
 * @property string|null $mode_paiement_info_sup
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HistoriqueFacture> $historiques
 * @property-read int|null $historiques_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactureConsultation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactureConsultation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactureConsultation whereDetailsMotif($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactureConsultation whereMedecinR($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactureConsultation whereModePaiement($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactureConsultation whereModePaiementInfoSup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactureConsultation whereStatut($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactureConsultation withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactureConsultation withoutTrashed()
 */
	class FactureConsultation extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int $patient_id
 * @property string $designation_devis
 * @property int $numero_facture
 * @property int $montant_devis
 * @property int|null $avance_devis
 * @property int|null $reste_devis
 * @property int|null $part_assurance
 * @property int|null $part_patient
 * @property string|null $numero_assurance
 * @property string|null $assurance
 * @property int|null $taux_assurance
 * @property string $date_creation
 * @property string|null $type_paiement
 * @property string|null $numero_cheque
 * @property string|null $tireur_cheque
 * @property string|null $banque_emission
 * @property string|null $date_emission
 * @property string|null $attestation_virement
 * @property string|null $numero_compte
 * @property int|null $montant_virement
 * @property string|null $banque_virement
 * @property string|null $date_virement
 * @property-read \App\Models\Patient|null $patient
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactureDevi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactureDevi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactureDevi query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactureDevi whereAssurance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactureDevi whereAttestationVirement($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactureDevi whereAvanceDevis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactureDevi whereBanqueEmission($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactureDevi whereBanqueVirement($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactureDevi whereDateCreation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactureDevi whereDateEmission($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactureDevi whereDateVirement($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactureDevi whereDesignationDevis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactureDevi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactureDevi whereMontantDevis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactureDevi whereMontantVirement($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactureDevi whereNumeroAssurance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactureDevi whereNumeroCheque($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactureDevi whereNumeroCompte($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactureDevi whereNumeroFacture($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactureDevi wherePartAssurance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactureDevi wherePartPatient($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactureDevi wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactureDevi whereResteDevis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactureDevi whereTauxAssurance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactureDevi whereTireurCheque($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactureDevi whereTypePaiement($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactureDevi whereUserId($value)
 */
	class FactureDevi extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Fiche
 *
 * @property int $id
 * @property string $nom
 * @property string $prenom
 * @property string $chambre_numero
 * @property int $age
 * @property string $service
 * @property string $infirmier_charge
 * @property string $accueil
 * @property string $restauration
 * @property string $chambre
 * @property string $soins
 * @property int $notes
 * @property string $quizz
 * @property string $remarque_suggestion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id
 * @property-read \App\Models\User $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fiche newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fiche newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fiche query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fiche whereAccueil($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fiche whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fiche whereChambre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fiche whereChambreNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fiche whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fiche whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fiche whereInfirmierCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fiche whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fiche whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fiche wherePrenom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fiche whereQuizz($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fiche whereRemarqueSuggestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fiche whereRestauration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fiche whereService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fiche whereSoins($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fiche whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fiche whereUserId($value)
 * @mixin \Eloquent
 */
	class Fiche extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int $patient_id
 * @property string $consommable
 * @property string|null $jour
 * @property string|null $nuit
 * @property string $date
 * @property-read \App\Models\Patient|null $patient
 * @property-read \App\Models\Produit|null $produit
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FicheConsommable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FicheConsommable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FicheConsommable query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FicheConsommable whereConsommable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FicheConsommable whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FicheConsommable whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FicheConsommable whereJour($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FicheConsommable whereNuit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FicheConsommable wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FicheConsommable whereUserId($value)
 */
	class FicheConsommable extends \Eloquent {}
}

namespace App\Models{
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
	class FicheIntervention extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $patient_id
 * @property string|null $regime
 * @property string|null $consultation_specialise
 * @property string|null $protocole
 * @property string|null $allergie
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Patient $patient
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PrescriptionMedicale> $prescription_medicales
 * @property-read int|null $prescription_medicales_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FichePrescriptionMedicale newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FichePrescriptionMedicale newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FichePrescriptionMedicale query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FichePrescriptionMedicale whereAllergie($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FichePrescriptionMedicale whereConsultationSpecialise($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FichePrescriptionMedicale whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FichePrescriptionMedicale whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FichePrescriptionMedicale wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FichePrescriptionMedicale whereProtocole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FichePrescriptionMedicale whereRegime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FichePrescriptionMedicale whereUpdatedAt($value)
 */
	class FichePrescriptionMedicale extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $facture_consultation_id
 * @property int|null $user_id
 * @property int|null $patient_id
 * @property int|null $numero
 * @property string|null $motif
 * @property string|null $montant
 * @property int|null $avance
 * @property int|null $percu
 * @property int|null $reste
 * @property string|null $assurance
 * @property int|null $assurancec
 * @property int|null $assurec
 * @property string|null $demarcheur
 * @property string|null $prenom
 * @property string|null $date_insertion
 * @property string|null $medecin_r
 * @property string $mode_paiement
 * @property string|null $mode_paiement_info_sup
 * @property-read \App\Models\FactureConsultation $facture_consultation
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoriqueFacture newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoriqueFacture newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoriqueFacture query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoriqueFacture whereAssurance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoriqueFacture whereAssurancec($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoriqueFacture whereAssurec($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoriqueFacture whereAvance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoriqueFacture whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoriqueFacture whereDateInsertion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoriqueFacture whereDemarcheur($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoriqueFacture whereFactureConsultationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoriqueFacture whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoriqueFacture whereMedecinR($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoriqueFacture whereModePaiement($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoriqueFacture whereModePaiementInfoSup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoriqueFacture whereMontant($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoriqueFacture whereMotif($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoriqueFacture whereNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoriqueFacture wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoriqueFacture wherePercu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoriqueFacture wherePrenom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoriqueFacture whereReste($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoriqueFacture whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoriqueFacture whereUserId($value)
 */
	class HistoriqueFacture extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $user_id
 * @property int|null $patient_id
 * @property string|null $radiographie
 * @property string|null $echographie
 * @property string|null $scanner
 * @property string|null $irm
 * @property string|null $scintigraphie
 * @property string|null $autre
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Patient|null $patient
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Imagerie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Imagerie newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Imagerie query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Imagerie whereAutre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Imagerie whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Imagerie whereEchographie($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Imagerie whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Imagerie whereIrm($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Imagerie wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Imagerie whereRadiographie($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Imagerie whereScanner($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Imagerie whereScintigraphie($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Imagerie whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Imagerie whereUserId($value)
 */
	class Imagerie extends \Eloquent {}
}

namespace App\Models{
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
	class Intervention extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Lettre
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lettre newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lettre newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lettre query()
 * @mixin \Eloquent
 */
	class Lettre extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $license_key
 * @property string $client
 * @property string $create_date
 * @property string|null $active_date
 * @property string|null $expire_date
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Licence activeLicenceKey()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Licence activeLicenceOneMonth()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Licence disableLicenceKey()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Licence newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Licence newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Licence query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Licence whereActiveDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Licence whereClient($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Licence whereCreateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Licence whereExpireDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Licence whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Licence whereLicenseKey($value)
 */
	class Licence extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $element
 * @property int $quantite
 * @property int $prix_u
 * @property int $devi_id
 * @property-read \App\Models\Devi $devi
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LigneDevi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LigneDevi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LigneDevi query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LigneDevi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LigneDevi whereDeviId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LigneDevi whereElement($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LigneDevi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LigneDevi wherePrixU($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LigneDevi whereQuantite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LigneDevi whereUpdatedAt($value)
 */
	class LigneDevi extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int $patient_id
 * @property string $observation
 * @property string $anesthesiste
 * @property string $date
 * @property-read \App\Models\Patient|null $patient
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ObservationMedicale newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ObservationMedicale newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ObservationMedicale query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ObservationMedicale whereAnesthesiste($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ObservationMedicale whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ObservationMedicale whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ObservationMedicale whereObservation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ObservationMedicale wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ObservationMedicale whereUserId($value)
 */
	class ObservationMedicale extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Ordonance
 *
 * @property int $id
 * @property int $user_id
 * @property int $patient_id
 * @property string $description
 * @property string $medicament
 * @property string $quantite
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Patient $patient
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ordonance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ordonance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ordonance query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ordonance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ordonance whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ordonance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ordonance whereMedicament($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ordonance wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ordonance whereQuantite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ordonance whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ordonance whereUserId($value)
 * @mixin \Eloquent
 */
	class Ordonance extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Parametre
 *
 * @property int $id
 * @property int $user_id
 * @property int $patient_id
 * @property float $poids
 * @property float $taille
 * @property string $bras_gauche
 * @property string $bras_droit
 * @property string $inc_bmi
 * @property string $date_naissance
 * @property int $age
 * @property string $temperature
 * @property string|null $fr
 * @property string|null $fc
 * @property string|null $spo2
 * @property string|null $glycemie
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Patient $patient
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parametre newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parametre newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parametre query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parametre whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parametre whereBrasDroit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parametre whereBrasGauche($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parametre whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parametre whereDateNaissance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parametre whereFc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parametre whereFr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parametre whereGlycemie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parametre whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parametre whereIncBmi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parametre wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parametre wherePoids($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parametre whereSpo2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parametre whereTaille($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parametre whereTemperature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parametre whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parametre whereUserId($value)
 * @mixin \Eloquent
 */
	class Parametre extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int $numero_dossier
 * @property string $name
 * @property string|null $assurance
 * @property string|null $numero_assurance
 * @property string|null $prise_en_charge
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $reste
 * @property int|null $assurancec
 * @property int|null $assurec
 * @property string|null $demarcheur
 * @property string|null $motif
 * @property string|null $prenom
 * @property string|null $date_insertion
 * @property int|null $montant
 * @property int|null $avance
 * @property int|null $medecin_r
 * @property string|null $details_motif
 * @property string $mode_paiement
 * @property string|null $mode_paiement_info_sup
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AdaptationTraitement> $adaptation_traitements
 * @property-read int|null $adaptation_traitements_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CompteRenduBlocOperatoire> $compte_rendu_bloc_operatoires
 * @property-read int|null $compte_rendu_bloc_operatoires_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ConsultationAnesthesiste> $consultation_anesthesistes
 * @property-read int|null $consultation_anesthesistes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ConsultationSuivi> $consultationdesuivi
 * @property-read int|null $consultationdesuivi_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Consultation> $consultations
 * @property-read int|null $consultations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Dossier> $dossiers
 * @property-read int|null $dossiers_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Event> $event
 * @property-read int|null $event_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Examen> $examens
 * @property-read int|null $examens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FactureConsultation> $facture_chambres
 * @property-read int|null $facture_chambres_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FactureConsultation> $facture_consultations
 * @property-read int|null $facture_consultations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FicheConsommable> $fiche_consommables
 * @property-read int|null $fiche_consommables_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FicheIntervention> $fiche_interventions
 * @property-read int|null $fiche_interventions_count
 * @property-read \App\Models\FichePrescriptionMedicale|null $fiche_prescription_medicale
 * @property-read mixed $created_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Imagerie> $imageries
 * @property-read int|null $imageries_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Intervention> $interventions
 * @property-read int|null $interventions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ObservationMedicale> $observation_medicales
 * @property-read int|null $observation_medicales_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Ordonance> $ordonances
 * @property-read int|null $ordonances_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Parametre> $parametres
 * @property-read int|null $parametres_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Premedication> $premedications
 * @property-read int|null $premedications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Prescription> $prescriptions
 * @property-read int|null $prescriptions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SoinsInfirmier> $soins_infirmiers
 * @property-read int|null $soins_infirmiers_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SurveillancePostAnesthesique> $surveillance_post_anesthesiques
 * @property-read int|null $surveillance_post_anesthesiques_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SurveillanceRapprocheParametre> $surveillance_rapproche_parametres
 * @property-read int|null $surveillance_rapproche_parametres_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SurveillanceScore> $surveillance_scores
 * @property-read int|null $surveillance_scores_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TraitementHospitalisation> $traitement_hospitalisations
 * @property-read int|null $traitement_hospitalisations_count
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VisitePreanesthesique> $visite_preanesthesiques
 * @property-read int|null $visite_preanesthesiques_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereAssurance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereAssurancec($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereAssurec($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereAvance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereDateInsertion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereDemarcheur($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereDetailsMotif($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereMedecinR($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereModePaiement($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereModePaiementInfoSup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereMontant($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereMotif($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereNumeroAssurance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereNumeroDossier($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient wherePrenom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient wherePriseEnCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereReste($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereUserId($value)
 */
	class Patient extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Premedication
 *
 * @property int $id
 * @property int $user_id
 * @property int $patient_id
 * @property string $consigne_ide
 * @property string $preparation
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Patient $patient
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Premedication newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Premedication newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Premedication query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Premedication whereConsigneIde($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Premedication whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Premedication whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Premedication wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Premedication wherePreparation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Premedication whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Premedication whereUserId($value)
 * @mixin \Eloquent
 * @property string|null $medicament
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Premedication whereMedicament($value)
 */
	class Premedication extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Prescription
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $patient_id
 * @property string|null $hematologie
 * @property string|null $hemostase
 * @property string|null $biochimie
 * @property string|null $hormonologie
 * @property string|null $marqueurs
 * @property string|null $bacteriologie
 * @property string|null $spermiologie
 * @property string|null $urines
 * @property string|null $serologie
 * @property string|null $examen
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Patient|null $patient
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Prescription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Prescription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Prescription query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Prescription whereBacteriologie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Prescription whereBiochimie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Prescription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Prescription whereExamen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Prescription whereHematologie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Prescription whereHemostase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Prescription whereHormonologie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Prescription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Prescription whereMarqueurs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Prescription wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Prescription whereSerologie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Prescription whereSpermiologie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Prescription whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Prescription whereUrines($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Prescription whereUserId($value)
 * @mixin \Eloquent
 */
	class Prescription extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $fiche_prescription_medicale_id
 * @property int $user_id
 * @property string $medicament
 * @property string $posologie
 * @property string $voie
 * @property string $horaire
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AdminPrescriptionMedicale> $adminPrescriptionMedicales
 * @property-read int|null $admin_prescription_medicales_count
 * @property-read \App\Models\Patient|null $patient
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PrescriptionMedicale newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PrescriptionMedicale newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PrescriptionMedicale query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PrescriptionMedicale whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PrescriptionMedicale whereFichePrescriptionMedicaleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PrescriptionMedicale whereHoraire($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PrescriptionMedicale whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PrescriptionMedicale whereMedicament($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PrescriptionMedicale wherePosologie($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PrescriptionMedicale whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PrescriptionMedicale whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PrescriptionMedicale whereVoie($value)
 */
	class PrescriptionMedicale extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Produit
 *
 * @property int $id
 * @property string $designation
 * @property string $categorie
 * @property int $qte_stock
 * @property int $qte_alerte
 * @property int $prix_unitaire
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Facture[] $factures
 * @property-read int|null $factures_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Produit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Produit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Produit query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Produit whereCategorie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Produit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Produit whereDesignation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Produit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Produit wherePrixUnitaire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Produit whereQteAlerte($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Produit whereQteStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Produit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Produit whereUserId($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FicheConsommable> $fiche_consommables
 * @property-read int|null $fiche_consommables_count
 */
	class Produit extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int $patient_id
 * @property string $observation
 * @property string|null $patient_externe
 * @property string $date
 * @property-read \App\Models\Patient|null $patient
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SoinsInfirmier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SoinsInfirmier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SoinsInfirmier query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SoinsInfirmier whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SoinsInfirmier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SoinsInfirmier whereObservation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SoinsInfirmier wherePatientExterne($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SoinsInfirmier wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SoinsInfirmier whereUserId($value)
 */
	class SoinsInfirmier extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int $patient_id
 * @property string|null $surveillance
 * @property string|null $traitement
 * @property string|null $examen_paraclinique
 * @property string|null $observation
 * @property string|null $date_creation
 * @property string|null $date_sortie
 * @property string|null $heur_sortie
 * @property-read \App\Models\Patient|null $patient
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillancePostAnesthesique newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillancePostAnesthesique newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillancePostAnesthesique query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillancePostAnesthesique whereDateCreation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillancePostAnesthesique whereDateSortie($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillancePostAnesthesique whereExamenParaclinique($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillancePostAnesthesique whereHeurSortie($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillancePostAnesthesique whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillancePostAnesthesique whereObservation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillancePostAnesthesique wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillancePostAnesthesique whereSurveillance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillancePostAnesthesique whereTraitement($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillancePostAnesthesique whereUserId($value)
 */
	class SurveillancePostAnesthesique extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int $patient_id
 * @property string $date
 * @property string $heure
 * @property string $ta
 * @property string|null $fr
 * @property int|null $pouls
 * @property int $spo2
 * @property int|null $temperature
 * @property string|null $diurese
 * @property string $conscience
 * @property string|null $douleur
 * @property string|null $observation_plainte
 * @property string $periode
 * @property-read \App\Models\Patient|null $patient
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillanceRapprocheParametre newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillanceRapprocheParametre newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillanceRapprocheParametre query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillanceRapprocheParametre whereConscience($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillanceRapprocheParametre whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillanceRapprocheParametre whereDiurese($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillanceRapprocheParametre whereDouleur($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillanceRapprocheParametre whereFr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillanceRapprocheParametre whereHeure($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillanceRapprocheParametre whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillanceRapprocheParametre whereObservationPlainte($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillanceRapprocheParametre wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillanceRapprocheParametre wherePeriode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillanceRapprocheParametre wherePouls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillanceRapprocheParametre whereSpo2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillanceRapprocheParametre whereTa($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillanceRapprocheParametre whereTemperature($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillanceRapprocheParametre whereUserId($value)
 */
	class SurveillanceRapprocheParametre extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int $patient_id
 * @property string $horaire
 * @property string $ta
 * @property string $fc
 * @property int $spo2
 * @property int $fr
 * @property string|null $douleur
 * @property int $temperature
 * @property string|null $glycemie
 * @property string|null $sedation
 * @property string|null $nausee
 * @property string|null $vomissement
 * @property string|null $saignement
 * @property string|null $pansement
 * @property string|null $conscience
 * @property string|null $drains
 * @property string|null $miction
 * @property string|null $lever
 * @property string|null $score
 * @property-read \App\Models\Patient|null $patient
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillanceScore newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillanceScore newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillanceScore query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillanceScore whereConscience($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillanceScore whereDouleur($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillanceScore whereDrains($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillanceScore whereFc($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillanceScore whereFr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillanceScore whereGlycemie($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillanceScore whereHoraire($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillanceScore whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillanceScore whereLever($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillanceScore whereMiction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillanceScore whereNausee($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillanceScore wherePansement($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillanceScore wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillanceScore whereSaignement($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillanceScore whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillanceScore whereSedation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillanceScore whereSpo2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillanceScore whereTa($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillanceScore whereTemperature($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillanceScore whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurveillanceScore whereVomissement($value)
 */
	class SurveillanceScore extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TraitementHospitalisation
 *
 * @property int $id
 * @property int $user_id
 * @property int $patient_id
 * @property string $medicament_posologie_dosage
 * @property int|null $duree
 * @property string|null $j
 * @property string|null $j0
 * @property string|null $j1
 * @property string|null $j2
 * @property string|null $m
 * @property string|null $mi
 * @property string|null $n
 * @property string|null $s
 * @property string|null $m1
 * @property string|null $mi1
 * @property string|null $s1
 * @property string|null $n1
 * @property string $date
 * @property-read \App\Models\Patient $patient
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TraitementHospitalisation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TraitementHospitalisation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TraitementHospitalisation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TraitementHospitalisation whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TraitementHospitalisation whereDuree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TraitementHospitalisation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TraitementHospitalisation whereJ($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TraitementHospitalisation whereJ0($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TraitementHospitalisation whereJ1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TraitementHospitalisation whereJ2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TraitementHospitalisation whereM($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TraitementHospitalisation whereM1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TraitementHospitalisation whereMedicamentPosologieDosage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TraitementHospitalisation whereMi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TraitementHospitalisation whereMi1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TraitementHospitalisation whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TraitementHospitalisation whereN1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TraitementHospitalisation wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TraitementHospitalisation whereS($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TraitementHospitalisation whereS1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TraitementHospitalisation whereUserId($value)
 * @mixin \Eloquent
 */
	class TraitementHospitalisation extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $prenom
 * @property string $login
 * @property int $telephone
 * @property string $sexe
 * @property string $lieu_naissance
 * @property string $date_naissance
 * @property string|null $specialite
 * @property string|null $onmc
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $role_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AdaptationTraitement> $adaptation_traitements
 * @property-read int|null $adaptation_traitements_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Client> $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CompteRenduBlocOperatoire> $compte_rendu_bloc_operatoires
 * @property-read int|null $compte_rendu_bloc_operatoires_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ConsultationAnesthesiste> $consultation_anesthesistes
 * @property-read int|null $consultation_anesthesistes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ConsultationSuivi> $consultationdesuivi
 * @property-read int|null $consultationdesuivi_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Consultation> $consultations
 * @property-read int|null $consultations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Event> $events
 * @property-read int|null $events_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FactureClient> $facture_clients
 * @property-read int|null $facture_clients_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FactureConsultation> $facture_consultations
 * @property-read int|null $facture_consultations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FicheConsommable> $fiche_consommables
 * @property-read int|null $fiche_consommables_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FicheIntervention> $fiche_interventions
 * @property-read int|null $fiche_interventions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Fiche> $fiches
 * @property-read int|null $fiches_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ObservationMedicale> $observation_medicales
 * @property-read int|null $observation_medicales_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Ordonance> $ordonances
 * @property-read int|null $ordonances_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Patient> $patients
 * @property-read int|null $patients_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Premedication> $premedications
 * @property-read int|null $premedications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PrescriptionMedicale> $prescription_medicales
 * @property-read int|null $prescription_medicales_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Prescription> $prescriptions
 * @property-read int|null $prescriptions_count
 * @property-read \App\Models\Produit|null $produits
 * @property-read \App\Models\Role|null $role
 * @property-read \App\Models\Role|null $roles
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SoinsInfirmier> $soins_infirmiers
 * @property-read int|null $soins_infirmiers_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SurveillancePostAnesthesique> $surveillance_post_anesthesiques
 * @property-read int|null $surveillance_post_anesthesiques_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SurveillanceRapprocheParametre> $surveillance_rapproche_parametres
 * @property-read int|null $surveillance_rapproche_parametres_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SurveillanceScore> $surveillance_scores
 * @property-read int|null $surveillance_scores_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TraitementHospitalisation> $traitement_hospitalisations
 * @property-read int|null $traitement_hospitalisations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VisitePreanesthesique> $visite_preanesthesiques
 * @property-read int|null $visite_preanesthesiques_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDateNaissance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLieuNaissance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereOnmc($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePrenom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereSexe($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereSpecialite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTelephone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\VisitePreanesthesique
 *
 * @property int $id
 * @property int $user_id
 * @property int $patient_id
 * @property string $date_visite
 * @property string $element_nouveaux
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Patient $patient
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VisitePreanesthesique newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VisitePreanesthesique newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VisitePreanesthesique query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VisitePreanesthesique whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VisitePreanesthesique whereDateVisite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VisitePreanesthesique whereElementNouveaux($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VisitePreanesthesique whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VisitePreanesthesique wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VisitePreanesthesique whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VisitePreanesthesique whereUserId($value)
 * @mixin \Eloquent
 */
	class VisitePreanesthesique extends \Eloquent {}
}

