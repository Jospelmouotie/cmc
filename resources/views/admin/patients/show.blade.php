@extends('layouts.admin')
@section('title', 'CMCU | dossier patient')
@section('content')

<style>
    .grid-container {
        display: grid;
        grid-gap: 30px 60px;
        grid-template-columns: auto auto auto;
        padding: 10px;
    }

    .grid-item {
        background-color: rgba(255, 255, 255, 0.8);
        border: 1px solid rgba(0, 0, 0, 0.8);
        padding: 10px;
        font-size: 12px;
        margin-right: 1px;
    }

    .table-sortable tbody tr {
        cursor: move;
    }

    /* Ensure main content doesn't overflow */
    .main-content-area {
        overflow-x: hidden;
        padding: 15px;
    }

    /* === Uniform Action Button Styling === */
    .btn-action-fixed {
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        font-size: 0.95rem;
        padding: 0 12px;
        border-radius: 8px;
    }

    @media (max-width: 767.98px) {
        .sidebar {
            position: static !important;
            min-height: auto;
            width: 100% !important;
        }

        .btn-action-fixed {
            font-size: 0.85rem;
            height: auto;
            white-space: normal;
        }
    }

    @media (max-width: 576px) {
        .btn-action-fixed {
            font-size: 0.85rem;
            height: auto;
            white-space: normal;
        }
    }
</style>

<div class="wrapper">
    @include('partials.side_bar')

    <!-- Page Content Holder -->
    <div class="main-content-area">
        @include('partials.header')

        @can('show', \App\Models\User::class)
        <div class="container-fluid">
            <!--  -->

            <div class="row mb-3">
                
                <div class="col-12">
                    @include('admin.patients.partials.menu')
                    <a href="{{ route('patients.index') }}" class="btn btn-success float-end" title="Retour à la liste des patients">
                        <i class="fas fa-arrow-left"></i> Retour à la liste des patients
                    </a>
                </div>
            </div>

            <div class="row">
                <!-- Main Patient Dossier Section - Dynamic width based on sidebar visibility -->
                <div class="@can('med_inf_anes', \App\Models\Patient::class) col-lg-9 @else col-lg-12 @endcan col-md-12 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h2 class="card-title text-danger text-center mb-4">
                                DOSSIER PATIENT {{ $patient->name }} {{ $patient->prenom }}
                            </h2>

                            <!-- Action Buttons -->
                            <div class="d-flex flex-wrap justify-content-center gap-2 mb-4">
                                <button class="btn btn-secondary" title="Cacher / Afficher les données personnelles du patient" onclick="ShowDetailsPatient()">
                                    <i class="fas fa-eye"></i> Détails Personnels
                                </button>

                                @can('infirmier_secretaire', \App\Models\Patient::class)
                                <a href="{{ route('dossiers.create', $patient->id) }}" class="btn btn-info">
                                    <i class="fas fa-bars"></i> Compléter le dossier
                                </a>
                                @endcan

                                @can('secretaire', \App\Models\Patient::class)
                                <button class="btn btn-secondary" title="Modifier le motif et le montant" onclick="ShoweditMotif_montant()">
                                    <i class="fas fa-edit"></i> Editer
                                </button>
                                @endcan

                                @can('med_inf_anes', \App\Models\Patient::class)
                                <a class="btn btn-dark" href="{{ route('fiche.prescription_medicale.index', $patient) }}" title="Prescriptions médicales">
                                    <i class="fas fa-book"></i> Prescriptions Médicales
                                </a>
                                @endcan

                                @can('infirmier', \App\Models\Patient::class)
                                
                                    @if($dossiers)
                                        <a class="btn btn-secondary" href="{{ route('consultations.create', $patient->id) }}" title="Nouvelle consultation du patient pour la prise des paramètres">
                                            <i class="fas fa-book"></i> Fiche De Paramètres
                                        </a>
                                    @else
                                        <a class="btn btn-secondary" href="#" data-bs-placement="top" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-content="Vous devez d'abord compléter le dossier patient !" title="Fiche de prise des paramètres">
                                            <i class="fas fa-book"></i> Fiche De Paramètres
                                        </a>
                                    @endif
                                @endcan

                                @can('medecin_secretaire', \App\Models\Patient::class)
                                <button class="btn btn-secondary" title="Gérer les images scannés des examens" onclick="Showexamen_scannes()">
                                    <i class="fas fa-image"></i> Images Scannées
                                </button>
                                @endcan
                            </div>

                            <!-- Patient Data Tables -->
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    @include('admin.consultations.partials.detail_patient')
                                    @include('admin.consultations.show_consultation')
                                    @include('admin.consultations.partials.motif_et_montant')
                                </table>
                            </div>

                            @include('admin.patients.partials.examens_scannes')
                        </div>
                    </div>
                </div>

                <!-- Action Sidebar (Right Column) - Only visible for med_inf_anes users -->
                @can('med_inf_anes', \App\Models\Patient::class)
                <div class="col-lg-3 col-md-12 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header fw-bold py-3">
                            <small>DÉTAILS ACTION</small>
                        </div>
                        <br>
                        <div class="card-body p-0">
                            <button type="button" class="btn btn-primary w-100 mb-2 py-3 gap-2 rounded-3 btn-action-fixed" title="Liste des ordonnances pour ce patient" data-bs-toggle="modal" data-bs-target="#ordonanceAll">
                                <i class="fas fa-eye"></i> Ordonnances
                            </button>

                            <button type="button" class="btn btn-primary w-100 mb-2 py-3 gap-2 rounded-3 btn-action-fixed" title="Liste des examens pour ce patient" data-bs-toggle="modal" data-bs-target="#biologieAll">
                                <i class="fas fa-eye"></i> Examens Biologiques
                            </button>

                            @can('anesthesiste', \App\Models\Patient::class)
                            <a href="{{ route('surveillance_rapproche.index', $patient->id) }}" class="btn btn-primary w-100 mb-2 py-3 gap-2 rounded-3 btn-action-fixed" title="Surveillance rapprochée des paramètres">
                                <i class="fas fa-eye"></i> Surveillance Rapprochée
                            </a>
                            @endcan

                            @can('chirurgien', \App\Models\Patient::class)
                            <a href="{{ route('consultations.index_anesthesiste', $patient->id) }}" class="btn btn-primary w-100 mb-2 py-3 gap-2 rounded-3 btn-action-fixed">
                                <i class="fas fa-eye"></i> Consultations Anesthésistes
                            </a>
                            <a href="{{ route('surveillance_rapproche.index', $patient->id) }}" class="btn btn-primary w-100 mb-2 py-3 gap-2 rounded-3 btn-action-fixed" title="Surveillance rapprochée des paramètres">
                                <i class="fas fa-eye"></i> Surveillance Rapprochée
                            </a>
                            @endcan

                            @can('infirmier', \App\Models\Patient::class)
                            <a href="{{ route('surveillance_rapproche.index', $patient->id) }}" class="btn btn-primary w-100 mb-2 py-3 gap-2 rounded-3 btn-action-fixed" title="Surveillance rapprochée des paramètres">
                                <i class="fas fa-eye"></i> Surveillance Rapprochée
                            </a>
                            <a href="{{ route('consultations.index_anesthesiste', $patient->id) }}" class="btn btn-primary w-100 mb-2 py-3 gap-2 rounded-3 btn-action-fixed">
                                <i class="fas fa-eye"></i> Consultations Anesthésistes
                            </a>
                            @endcan
                            
                            <!-- // Added for imagerie exams -->
                            <!-- <button type="button" class="btn btn-primary w-100 mb-2 py-3 gap-2 rounded-3 btn-action-fixed" title="Liste des examens pour ce patient" data-bs-toggle="modal" data-bs-target="#imagerieAll" data-bs-whatever="@mdo">
                                <i class="fas fa-eye"></i> Examens Imageries
                            </button>
                            <a href="{{ route('examens.index') }}" class="btn btn-primary w-100 mb-2 py-3 gap-2 rounded-3 btn-action-fixed" title="Détails surveillance post-aneshésiste">
                                <i class="fas fa-eye"></i> Résultats d'Examens
                            </a> -->

                            <!-- // End of Imagerie exams addition -->

                            <a href="{{ route('surveillance_post_anesthesise.index', $patient->id) }}" class="btn btn-primary w-100 mb-2 py-3 gap-2 rounded-3 btn-action-fixed" title="Détails surveillance post-aneshésiste">
                                <i class="fas fa-eye"></i> Surveillance Post-Anesthésique
                            </a>

                            <button type="button" class="btn btn-primary w-100 mb-2 py-3 gap-2 rounded-3 btn-action-fixed" title="Fiches d'intervention" data-bs-toggle="modal" data-bs-target="#FicheInterventionAll">
                                <i class="fas fa-eye"></i> Fiche d'Intervention
                            </button>

                            <a href="{{ route('dossiers.create', $patient->id) }}" class="btn btn-info w-100 mb-2 py-3 gap-2 rounded-3 btn-action-fixed">
                                Compléter Le Dossier
                            </a>

                        
                            @if($patient->consultations && $patient->consultations->isNotEmpty())
                                @can('medecin', \App\Models\Patient::class)
                                <a class="btn btn-success w-100 mb-2 py-3 gap-2 rounded-3 btn-action-fixed" title="Imprimer la lettre de sortie" href="{{ route('print.sortie', $patient->id) }}">
                                    <i class="fas fa-print"></i> Lettre De Consultation
                                </a>
                                <button type="button" class="btn btn-primary w-100 mb-2 py-3 gap-2 rounded-3 btn-action-fixed" title="Liste de fiches pour ce patient" data-bs-toggle="modal" data-bs-target="#ficheSuiviAll">
                                    <i class="fas fa-eye"></i> Fiche De Suivi
                                </button>
                                @endcan
                            @endif
                        </div>
                    </div>
                </div>
                @endcan
            </div>
        </div>
        @endcan

        <!-- MODALS -->
        @include('admin.modal.feuille_precription_examen')
        @include('admin.modal.detail_premedication_preparation')
        @include('admin.modal.ordonance_show')
        @include('admin.modal.consultation_show')
        @include('admin.modal.index_examen_biologie')
        @include('admin.modal.index_examen_imagerie')
        @include('admin.modal.fiche_intervention_show') 
        @include('admin.modal.fiche_intervention')
        @include('admin.modal.fiche_intervention_anesthesiste')
        @include('admin.modal.visite_preanesthesique')
        @include('admin.modal.surveillance_post_a')
        @include('admin.modal.fichede_suivi')
    </div>
</div>

<script>
    function ShowDetailsPatient() {
        var x = document.getElementById("myDIV");
        var y = document.getElementById("editMotifMontform");
        var z = document.getElementById("examens_scannes_form");
        if (y?.style.display === "contents") y.style.display = "none";
        if (z?.style.display === "contents") z.style.display = "none";
        x.style.display = x.style.display === "none" ? "contents" : "none";
    }

    function ShoweditMotif_montant() {
        var x = document.getElementById("editMotifMontform");
        var y = document.getElementById("myDIV");
        var z = document.getElementById("examens_scannes_form");
        if (y?.style.display === "contents") y.style.display = "none";
        if (z?.style.display === "contents") z.style.display = "none";
        x.style.display = x.style.display === "none" ? "contents" : "none";
    }

    function Showexamen_scannes() {
        var x = document.getElementById("editMotifMontform");
        var y = document.getElementById("myDIV");
        var z = document.getElementById("examens_scannes_form");
        var t = document.getElementById("show_consultation");
        if (y?.style.display === "contents") y.style.display = "none";
        if (x?.style.display === "contents") x.style.display = "none";
        if (t?.style.display === "contents") t.style.display = "none";
        z.style.display = z.style.display === "none" ? "contents" : "none";
    }

    document.querySelectorAll('.form-control[type="file"]').forEach(input => {
        input.addEventListener('change', e => {
            const fileName = e.target.files[0]?.name || 'Choose file';
            const label = e.target.nextElementSibling;
            if (label?.classList.contains('form-label')) label.textContent = fileName;
        });
    });

    function handleFiles(files) {
            var imageType = /^image\//;
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                if (!imageType.test(file.type)) {
                    alert("Veuillez sélectionner une image");
                } else {
                    let form_parent = document.getElementById('preview');
                    let img1 = document.getElementById("img1");
                    let clone_img = img1.cloneNode(false);
                    clone_img.file = file;
                    clone_img.classList.add("obj");
                    form_parent.replaceChild(clone_img, img1);
                    var reader = new FileReader();
                    reader.onload = (function(aImg) {
                        return function(e) {
                            aImg.src = e.target.result;
                        };
                    })(clone_img);
                    reader.readAsDataURL(file);
                }
            }
        }

    document.querySelectorAll('[data-bs-toggle="popover"]').forEach(el => new bootstrap.Popover(el));
</script>

@stop









