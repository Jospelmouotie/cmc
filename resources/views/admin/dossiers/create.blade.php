@extends('layouts.admin')

@section('title', 'CMCU | Renseigner un dossier patient')

@section('content')

<body>
    <div class="se-pre-con"></div>
    <div class="wrapper">
        @include('partials.side_bar')
        @include('partials.header')

        <div class="container-fluid px-4 py-4">
            <!-- En-tête de page -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-1">
                                <i class="fas fa-folder-open text-primary me-2"></i>
                                Dossier de {{ $patient->name }} {{ $patient->prenom }}
                            </h2>
                            <p class="text-muted mb-0">Renseignement des informations complémentaires</p>
                        </div>
                        <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Retour au dossier
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
                            <h5 class="mb-0">
                                <i class="fas fa-user-edit me-2"></i>Informations complémentaires du patient
                            </h5>
                            <small>
                                <i class="fas fa-info-circle me-1"></i>Veuillez remplir les informations ci-dessous
                            </small>
                        </div>

                        <div class="card-body p-4">
                            <form method="post" action="{{ route('dossiers.store') }}">
                                @csrf

                                <input type="hidden" name="patient_id" value="{{ $patient->id }}">

                                <!-- Section 1: Informations personnelles -->
                                <div class="mb-4">
                                    <h6 class="text-primary border-bottom pb-2 mb-3">
                                        <i class="fas fa-id-card me-2"></i>Informations personnelles
                                    </h6>
                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <label class="form-label fw-semibold">
                                                Sexe <span class="text-danger">*</span>
                                            </label>
                                            <div class="d-flex gap-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="sexe" id="sexe_masculin" value="Masculin">
                                                    <label class="form-check-label" for="sexe_masculin">
                                                        <i class="fas fa-mars text-primary me-1"></i> Masculin
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="sexe" id="sexe_feminin" value="Féminin">
                                                    <label class="form-check-label" for="sexe_feminin">
                                                        <i class="fas fa-venus text-danger me-1"></i> Féminin
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="date_naissance" class="form-label fw-semibold">
                                                Date de naissance
                                            </label>
                                            <input type="date" 
                                                   class="form-control" 
                                                   id="date_naissance"
                                                   name="date_naissance" 
                                                   value="{{ old('date_naissance') }}" 
                                                   placeholder="Date de naissance">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="lieu_naissance" class="form-label fw-semibold">
                                                Lieu de naissance
                                            </label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   id="lieu_naissance"
                                                   name="lieu_naissance" 
                                                   value="{{ old('lieu_naissance') }}" 
                                                   placeholder="Ville de naissance">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="profession" class="form-label fw-semibold">
                                                Profession
                                            </label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   id="profession"
                                                   name="profession" 
                                                   value="{{ old('profession') }}" 
                                                   placeholder="Ex: Ingénieur, Enseignant...">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="adresse" class="form-label fw-semibold">
                                                Adresse
                                            </label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   id="adresse"
                                                   name="adresse" 
                                                   value="{{ old('adresse') }}" 
                                                   placeholder="Adresse complète">
                                        </div>
                                    </div>
                                </div>

                                <!-- Section 2: Coordonnées -->
                                <div class="mb-4">
                                    <h6 class="text-primary border-bottom pb-2 mb-3">
                                        <i class="fas fa-phone me-2"></i>Coordonnées
                                    </h6>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="portable_2" class="form-label fw-semibold">
                                                Téléphone principal
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light">
                                                    <i class="fas fa-mobile-alt"></i>
                                                </span>
                                                <input type="number" 
                                                       class="form-control" 
                                                       id="portable_1"
                                                       name="portable_1" 
                                                       value="{{ old('portable_1') }}" 
                                                       placeholder="Ex: 690123456">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="portable_1" class="form-label fw-semibold">
                                                Téléphone secondaire
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light">
                                                    <i class="fas fa-phone"></i>
                                                </span>
                                                <input type="number" 
                                                       class="form-control" 
                                                       id="portable_2"
                                                       name="portable_2" 
                                                       value="{{ old('portable_2') }}" 
                                                       placeholder="Ex: 677654321">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="email" class="form-label fw-semibold">
                                                Adresse email
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light">
                                                    <i class="fas fa-envelope"></i>
                                                </span>
                                                <input type="email" 
                                                       class="form-control" 
                                                       id="email"
                                                       name="email" 
                                                       value="{{ old('email') }}" 
                                                       placeholder="exemple@email.com">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="fax" class="form-label fw-semibold">
                                                Fax
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light">
                                                    <i class="fas fa-fax"></i>
                                                </span>
                                                <input type="text" 
                                                       class="form-control" 
                                                       id="fax"
                                                       name="fax" 
                                                       value="{{ old('fax') }}" 
                                                       placeholder="Numéro de fax">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section 3: Personne à contacter -->
                                <div class="mb-4">
                                    <h6 class="text-primary border-bottom pb-2 mb-3">
                                        <i class="fas fa-user-friends me-2"></i>Personne à contacter en cas d'urgence
                                    </h6>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="personne_contact" class="form-label fw-semibold">
                                                Nom complet
                                            </label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   id="personne_contact"
                                                   name="personne_contact" 
                                                   value="{{ old('personne_contact') }}" 
                                                   placeholder="Nom de la personne à contacter">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="tel_personne_contact" class="form-label fw-semibold">
                                                Téléphone
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light">
                                                    <i class="fas fa-phone-alt"></i>
                                                </span>
                                                <input type="number" 
                                                       class="form-control" 
                                                       id="tel_personne_contact"
                                                       name="tel_personne_contact" 
                                                       value="{{ old('tel_personne_contact') }}" 
                                                       placeholder="Téléphone de la personne">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Boutons d'action -->
                                <div class="row mt-4 pt-3 border-top">
                                    <div class="col-12">
                                        <div class="d-flex gap-2 justify-content-between">
                                            <a href="{{ route('patients.show', $patient->id) }}" 
                                               class="btn btn-lg btn-outline-secondary px-4">
                                                <i class="fas fa-times me-2"></i>Annuler
                                            </a>
                                            <button type="submit" class="btn btn-lg btn-primary px-5">
                                                <i class="fas fa-save me-2"></i>Enregistrer le dossier
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                                                <!-- Carte d'information supplémentaire -->
                    <div class="card shadow-sm border-0 mt-3">
                        <div class="card-body bg-light">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h6 class="mb-1">
                                        <i class="fas fa-lightbulb text-warning me-2"></i>Astuce
                                    </h6>
                                    <small class="text-muted">
                                        Assurez-vous que toutes les informations sont correctes avant d'enregistrer. 
                                        Les coordonnées de la personne à contacter sont importantes en cas d'urgence.
                                    </small>
                                </div>
                             
                            </div>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</body>

@stop