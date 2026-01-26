@extends('layouts.admin')

@section('title', 'CMCU | Ajouter un dossier patient')

@section('content')

<body>
    <div class="se-pr-con"></div>
    <div class="wrapper">
        @include('partials.side_bar')
        @include('partials.header')

        <div class="container-fluid px-4 py-4">
            <!-- En-tête de page -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-1"><i class="fas fa-user-plus text-primary me-2"></i>Nouveau Dossier Patient</h2>
                            <p class="text-muted mb-0">Enregistrement d'un nouveau patient</p>
                        </div>
                        <a href="{{ route('patients.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Retour à la liste
                        </a>
                    </div>
                </div>
            </div>

            <!--  -->

            <!-- Formulaire principal -->
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-9">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-primary text-white py-3">
                            <h5 class="mb-0"><i class="fas fa-file-medical me-2"></i>Informations du patient</h5>
                            <small><i class="fas fa-info-circle me-1"></i>Les champs marqués d'une étoile (<span class="text-warning">*</span>) sont obligatoires</small>
                        </div>
                        
                        <div class="card-body p-4">
                            <form action="{{ route('patients.store') }}" method="POST">
                                @csrf

                                <!-- Section 1: Informations personnelles -->
                                <div class="mb-4">
                                    <h6 class="text-primary border-bottom pb-2 mb-3">
                                        <i class="fas fa-user me-2"></i>Informations personnelles
                                    </h6>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="name" class="form-label fw-semibold">
                                                Nom <span class="text-danger">*</span>
                                            </label>
                                            <input name="name" id="name" class="form-control" value="{{ old('name') }}" type="text" placeholder="Entrez le nom" required>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="prenom" class="form-label fw-semibold">
                                                Prénom <span class="text-danger">*</span>
                                            </label>
                                            <input name="prenom" id="prenom" class="form-control" value="{{ old('prenom') }}" type="text" placeholder="Entrez le prénom">
                                        </div>

                                        <div class="col-md-12">
                                            <label for="medecin_r" class="form-label fw-semibold">
                                                Médecin traitant <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select" name="medecin_r" id="medecin_r" required>
                                                <option value="">Sélectionnez un médecin</option>
                                                @foreach ($users as $user)
                                                <option value="{{ $user->name }} {{ $user->prenom }}" {{ old("medecin_r") == "$user->name $user->prenom" ? "selected" : "" }}>
                                                    Dr. {{ $user->name }} {{ $user->prenom }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section 2: Motif de consultation -->
                                <div class="mb-4">
                                    <h6 class="text-primary border-bottom pb-2 mb-3">
                                        <i class="fas fa-stethoscope me-2"></i>Motif de consultation
                                    </h6>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="motif" class="form-label fw-semibold">
                                                Type de motif <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select" name="motif" id="motif" onchange="new_ckChange(this)">
                                                <option selected>Consultation</option>
                                                <option>Acte</option>
                                                <option>Examen</option>
                                                <option>Autres</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="details_motif" id="label_details_motif" class="form-label fw-semibold">
                                                Détails motif <span class="text-danger">*</span>
                                            </label>
                                            <input name="details_motif" id="details_motif" class="form-control" value="{{ old('details_motif') ?? 'Consultation'}}" type="text" placeholder="Précisez le motif" >
                                            
                                        </div>

                                        <div class="col-md-6">
                                            <label for="date_insertion" class="form-label fw-semibold">
                                                Date de création <span class="text-danger">*</span>
                                            </label>
                                            <input type="date" name="date_insertion" id="date_insertion" class="form-control" value="{{ old('date_insertion', date('Y-m-d')) }}" readonly required>
                                                <small class="text-muted">
                                                   <i class="fas fa-info-circle me-1"></i>Date générée automatiquement
                                                </small>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="demarcheur" class="form-label fw-semibold">Démarcheur</label>
                                            <select class="form-select" name="demarcheur" id="demarcheur">
                                                <option value="">Aucun</option>
                                                <option {{ old('demarcheur') == 'DMH' ? 'selected' : '' }}>DMH</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section 3: Informations financières -->
                                <div class="mb-4">
                                    <h6 class="text-primary border-bottom pb-2 mb-3">
                                        <i class="fas fa-money-bill-wave me-2"></i>Informations financières
                                    </h6>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="montant" class="form-label fw-semibold">
                                                Montant (FCFA) <span class="text-danger">*</span>
                                            </label>
                                            <input name="montant" id="montant" class="form-control" value="{{ old('montant') }}" type="number" min="0" placeholder="Ex: 25000">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="avance" class="form-label fw-semibold">
                                                Avance (FCFA) <span class="text-danger">*</span>
                                            </label>
                                            <input name="avance" id="avance" class="form-control" value="{{ old('avance') }}" type="number" min="0" placeholder="Ex: 10000">
                                        </div>

                                        <div class="col-md-12">
                                            <label for="mode_paiement" class="form-label fw-semibold">
                                                Mode de paiement <span class="text-danger">*</span>
                                            </label>
                                            <select name="mode_paiement" id="mode_paiement" class="form-select">
                                                <optgroup label="Monnaie électronique">
                                                    <option value="orange money" {{ old('mode_paiement') == 'orange money' ? 'selected' : '' }}>Orange Money</option>
                                                    <option value="mtn mobile money" {{ old('mode_paiement') == 'mtn mobile money' ? 'selected' : '' }}>MTN Mobile Money</option>
                                                </optgroup>
                                                <optgroup label="Autres moyens">
                                                    <option selected value="espèce">Espèce</option>
                                                    <option value="chèque" {{ old('mode_paiement') == 'chèque' ? 'selected' : '' }}>Chèque</option>
                                                    <option value="virement" {{ old('mode_paiement') == 'virement' ? 'selected' : '' }}>Virement</option>
                                                    <option value="bon de prise en charge" {{ old('mode_paiement') == 'bon de prise en charge' ? 'selected' : '' }}>Bon de prise en charge</option>
                                                    <option value="autre" {{ old('mode_paiement') == 'autre' ? 'selected' : '' }}>Autre</option>
                                                </optgroup>
                                            </select>
                                        </div>

                                        <!-- Champs conditionnels pour chèque -->
                                        <div id="cheque_fields" class="col-md-12" style="display: none;">
                                            <div class="card bg-light border-0 mt-2">
                                                <div class="card-body">
                                                    <h6 class="card-title text-secondary mb-3">
                                                        <i class="fas fa-money-check me-2"></i>Informations du chèque
                                                    </h6>
                                                    <div class="row g-3">
                                                        <div class="col-md-4">
                                                            <label for="num_cheque" class="form-label">Numéro <span class="text-danger">*</span></label>
                                                            <input name="num_cheque" id="num_cheque" class="form-control" value="{{ old('num_cheque') }}" type="text" placeholder="N° du chèque">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="emetteur_cheque" class="form-label">Émetteur <span class="text-danger">*</span></label>
                                                            <input name="emetteur_cheque" id="emetteur_cheque" class="form-control" value="{{ old('emetteur_cheque') }}" type="text" placeholder="Nom de l'émetteur">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="banque_cheque" class="form-label">Banque <span class="text-danger">*</span></label>
                                                            <input name="banque_cheque" id="banque_cheque" class="form-control" value="{{ old('banque_cheque') }}" type="text" placeholder="Nom de la banque">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Champs conditionnels pour bon de prise en charge -->
                                        <div id="bpc_field" class="col-md-12" style="display: none;">
                                            <div class="card bg-light border-0 mt-2">
                                                <div class="card-body">
                                                    <h6 class="card-title text-secondary mb-3">
                                                        <i class="fas fa-file-invoice me-2"></i>Bon de prise en charge
                                                    </h6>
                                                    <div class="row g-3">
                                                        <div class="col-md-12">
                                                            <label for="emetteur_bpc" class="form-label">Émetteur du bon <span class="text-danger">*</span></label>
                                                            <input name="emetteur_bpc" id="emetteur_bpc" class="form-control" value="{{ old('emetteur_bpc') }}" type="text" placeholder="Nom de l'organisme émetteur">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section 4: Assurance -->
                                <div class="mb-4">
                                    <h6 class="text-primary border-bottom pb-2 mb-3">
                                        <i class="fas fa-shield-alt me-2"></i>Informations d'assurance
                                    </h6>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="assurance" class="form-label fw-semibold">Assurance</label>
                                            <input name="assurance" id="assurance" class="form-control" value="{{ old('assurance') }}" type="text" placeholder="Nom de l'assurance (si assuré)">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="numero_assurance" class="form-label fw-semibold">Numéro d'assurance</label>
                                            <input name="numero_assurance" id="numero_assurance" class="form-control" value="{{ old('numero_assurance') }}" type="text" placeholder="N° d'assurance (si assuré)">
                                        </div>

                                        <div class="col-md-12">
                                            <label for="prise_en_charge" class="form-label fw-semibold">Taux de prise en charge</label>
                                            <div class="input-group">
                                                <select class="form-select" name="prise_en_charge" id="prise_en_charge" required>
                                                    @foreach(range(0, 100) as $taux)
                                                    <option {{ old('prise_en_charge') == $taux ? 'selected' : '' }}>{{$taux}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="input-group-text bg-primary text-white">
                                                    <i class="fas fa-percent"></i>
                                                </span>
                                            </div>
                                            <small class="text-muted">Pourcentage de prise en charge par l'assurance</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Boutons d'action -->
                                <div class="row mt-4 pt-3 border-top">
                                    <div class="col-12">
                                        <div class="d-flex gap-1 justify-content-between">
                                            <a href="{{ route('patients.index') }}" class="btn btn-lg btn-outline-secondary px-4">
                                                <i class="fas fa-times me-2"></i>Annuler
                                            </a>
                                            <button type="submit" class="btn btn-lg btn-primary px-5">
                                                <i class="fas fa-save me-2"></i>Enregistrer le patient
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

@endsection

@section('script')
<script>
    function new_ckChange(ckType) {
        var motif = document.getElementById('motif');
        var choix = motif[motif.selectedIndex].value;
        if (choix == 'Consultation') {
            document.getElementById("label_details_motif").innerText = 'Détails motif';
            document.getElementById("details_motif").value = "Consultation";
        } else {
            document.getElementById("details_motif").value = "";
        }
        if (choix == 'Acte' || choix == 'Examen') {
            document.getElementById("label_details_motif").innerText = 'Type ' + choix.toLowerCase();
        }
        if (choix == 'Autres') {
            document.getElementById("label_details_motif").innerText = 'Détails motif';
        }
    }

    // Gérer l'affichage des champs selon le mode de paiement
    document.addEventListener('DOMContentLoaded', function() {
        const modePaiementSelect = document.getElementById('mode_paiement');
        const chequeFields = document.getElementById('cheque_fields');
        const bpcField = document.getElementById('bpc_field');
        
        function togglePaymentFields() {
            const modePaiement = modePaiementSelect.value;
            
            chequeFields.style.display = 'none';
            bpcField.style.display = 'none';
            
            if (modePaiement !== 'chèque') {
                document.getElementById('num_cheque').value = '';
                document.getElementById('emetteur_cheque').value = '';
                document.getElementById('banque_cheque').value = '';
            }
            
            if (modePaiement !== 'bon de prise en charge') {
                document.getElementById('emetteur_bpc').value = '';
            }
            
            if (modePaiement === 'chèque') {
                chequeFields.style.display = 'block';
            } else if (modePaiement === 'bon de prise en charge') {
                bpcField.style.display = 'block';
            }
        }
        
        modePaiementSelect.addEventListener('change', togglePaymentFields);
        togglePaymentFields();
    });
</script>
@stop