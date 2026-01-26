@extends('layouts.admin')

@section('title', 'CMCU | Modifier le dossier du patient')

@section('content')


<style>
    .name {
    border-bottom: 2px solid currentColor;
    padding-bottom: 2px;
}

</style>
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
                                <i class="fas fa-user-edit text-primary me-2"></i>
                                Modifier le dossier
                            </h2>
                            <p class="text-muted mb-0">
                                Patient: <strong class="name">{{ $patient->name }} {{ $patient->prenom }}</strong>
                            </p>
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
                                <i class="fas fa-file-medical me-2"></i>Informations du dossier  patient  : {{ $patient->name }} {{ $patient->prenom }}
                            </h5>
                        </div>

                        <div class="card-body p-4">
                            <form method="POST" action="{{ route('dossiers.update', $dossier->id) }}">
                                {{ method_field('PATCH') }}
                                @csrf
                                <input type="hidden" value="{{ $dossier->patient_id }}" name="patient_id">

                                <!-- Section 1: Informations personnelles -->
                                <div class="mb-4">
                                    <h6 class="text-primary border-bottom pb-2 mb-3">
                                        <i class="fas fa-user me-2"></i>Informations personnelles
                                    </h6>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Sexe</label>
                                            <div class="d-flex gap-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="sexe" id="sexe_m" value="Masculin"
                                                        {{ old('sexe', $dossier->sexe) === 'Masculin' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="sexe_m">
                                                        <i class="fas fa-mars text-primary me-1"></i>Masculin
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="sexe" id="sexe_f" value="Féminin"
                                                        {{ old('sexe', $dossier->sexe) === 'Féminin' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="sexe_f">
                                                        <i class="fas fa-venus text-danger me-1"></i>Féminin
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="date_naissance" class="form-label fw-semibold">Date de naissance</label>
                                            <input type="date" class="form-control" id="date_naissance" value="{{ old('date_naissance', $dossier->date_naissance) }}" name="date_naissance">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="lieu_naissance" class="form-label fw-semibold">Lieu de naissance</label>
                                            <input type="text" class="form-control" id="lieu_naissance" value="{{ old('lieu_naissance', $dossier->lieu_naissance) }}" name="lieu_naissance" placeholder="Ville/Région de naissance">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="profession" class="form-label fw-semibold">Profession</label>
                                            <input type="text" class="form-control" id="profession" value="{{ old('profession', $dossier->profession) }}" name="profession" placeholder="Profession du patient">
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
                                            <label for="portable_1" class="form-label fw-semibold">
                                                <i class="fas fa-mobile-alt me-1"></i>Téléphone principal
                                            </label>
                                            <input type="text" class="form-control" id="portable_1" value="{{ old('portable_1', $dossier->portable_1) }}" name="portable_1" placeholder="Ex: 6 XX XX XX XX">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="portable_2" class="form-label fw-semibold">
                                                <i class="fas fa-mobile-alt me-1"></i>Téléphone secondaire
                                            </label>
                                            <input type="text" class="form-control" id="portable_2" value="{{ old('portable_2', $dossier->portable_2) }}" name="portable_2" placeholder="Ex: 6 XX XX XX XX">
                                        </div>

                                        <div class="col-md-12">
                                            <label for="adresse" class="form-label fw-semibold">
                                                <i class="fas fa-map-marker-alt me-1"></i>Adresse complète
                                            </label>
                                            <input type="text" class="form-control" id="adresse" value="{{ old('adresse', $dossier->adresse) }}" name="adresse" placeholder="Quartier, ville">
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
                                            <input type="text" class="form-control" id="personne_contact" value="{{ old('personne_contact', $dossier->personne_contact) }}" name="personne_contact" placeholder="Nom de la personne à contacter">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="tel_personne_contact" class="form-label fw-semibold">
                                                Téléphone
                                            </label>
                                            <input type="text" class="form-control" id="tel_personne_contact" value="{{ old('tel_personne_contact', $dossier->tel_personne_contact) }}" name="tel_personne_contact" placeholder="Ex: 6 XX XX XX XX">
                                        </div>
                                    </div>
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Cette personne sera contactée en cas d'urgence médicale
                                    </small>
                                </div>

                                <!-- Boutons d'action -->
                                <div class="row mt-4 pt-3 border-top">
                                    <div class="col-12">
                                        <div class="d-flex gap-2 justify-content-between">
                                            <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-lg btn-outline-secondary px-4">
                                                <i class="fas fa-times me-2"></i>Annuler
                                            </a>
                                            <button type="submit" class="btn btn-lg btn-success px-5">
                                                <i class="fas fa-check me-2"></i>Enregistrer les modifications
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
                                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        Dernière modification: {{ $dossier->updated_at ? $dossier->updated_at->format('d/m/Y à H:i') : 'N/A' }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

@endsection