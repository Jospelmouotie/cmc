@extends('layouts.admin')

@section('title', 'CMCU | Ajouter un devis')

@section('content')

    <body>
    <div class="se-pr-con"></div>
    <div class="wrapper">
    @include('partials.side_bar')

    <!-- Page Content Holder -->
    @include('partials.header')
    <!--// top-bar -->
        @can('create', \App\Models\Patient::class)
            <div class="container">
                <h1 class="text-center">FACTURATION DEVIS</h1>
                <hr>
                <!--  -->

                <a href="{{ route('facture_devis.index') }}" class="btn btn-success float-end mb-2"
                   title="Retour à la liste des patients">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
                <div class="card" style="width: 60rem;">
                    <div class="card-body">
                        <h5 class="card-title"><b>FACTURATION DEVIS</b></h5>
                        <hr>
                        <form class="mb-3 col-md-12" action="{{ route('facture_devis.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <div class="row">
                                    <select name="patient_id" id="patient_id" class="form-control col-md-5" required>
                                        <option value="">Nom du patient</option>
                                        @foreach ($patients as $patient)
                                            <option value="{{ $patient->id }}">{{ $patient->name }} {{ $patient->prenom }}</option>
                                        @endforeach
                                    </select>

                                    <select name="designation_devis" id="designation_devis" class="form-control col-md-6 offset-1" required>
                                        <option value="">Désignation devis</option>
                                        @foreach ($devis as $devi)
                                            <option value="{{ $devi->nom }}">{{ $devi->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row mt-2">
                                    <input type="number" value="{{ old('montant_devis') }}" name="montant_devis" class="form-control col-md-5" placeholder="Montant" required>

                                    <input type="number" value="{{ old('avance_devis') }}" name="avance_devis" class="form-control col-md-6 offset-1" placeholder="Avance">
                                </div>
                                <div class="row mt-2">
                                    <input type="text" value="{{ old('numero_assurance') }}" name="numero_assurance" class="form-control col-md-4" placeholder="Numéro d'assurance">
                                    <input type="text" value="{{ old('assurance') }}" name="assurance" class="form-control col-md-4 offset-2" placeholder="Assurance">
                                </div>
                                <div class="row mt-2">
                                    <select name="taux_assurance" class="form-control col-md-4">
                                        <option value=""><b>Taux de prise en charge</b></option>
                                        @for ($i = 0; $i <= 100; $i++)
                                            <option value="{{ $i }}">{{ $i }} %</option>
                                        @endfor
                                    </select>
                                    <input type="date" value="{{ old('date_creation', Carbon\Carbon::now()->ToDateString()) }}" name="date_creation" class="form-control col-md-4 offset-2" required>
                                </div>

                                <div class="row mt-2">
                                    <select name="type_paiement" id="paid" class="form-control col-md-4">
                                        <option value=""><b>Type de paiement</b></option>
                                        <option value="CASH"> CASH</option>
                                        <option value="CHEQUE"> CHEQUE</option>
                                        <option value="VIREMENT"> VIREMENT</option>
                                    </select>
                                </div>

                                <div class="row mt-2 otherFieldDiv">
                                    <input type="text" value="{{ old('numero_cheque') }}" name="numero_cheque" class="form-control col-md-4" placeholder="Numéro de chèque">
                                    <input type="text" value="{{ old('tireur_cheque') }}" name="tireur_cheque" class="form-control col-md-4 offset-2" placeholder="Tireur">
                                </div>

                                <div class="row mt-2 otherFieldDiv">
                                    <input type="text" value="{{ old('banque_emission') }}" name="banque_emission" class="form-control col-md-4" placeholder="Banque">
                                    <input type="date" value="{{ old('date_emission') }}" name="date_emission" class="form-control col-md-4 offset-2">
                                </div>

                                <div class="row mt-2 otherFieldDiv1">
                                    <input type="file" class="form-control-md" name="attestation_virement">
                                    <input type="text" value="{{ old('numero_compte') }}" name="numero_compte" class="form-control col-md-4 offset-2" placeholder="Numéro de compte">
                                </div>

                                <div class="row mt-2 otherFieldDiv1">
                                    <input type="number" value="{{ old('montant_virement') }}" name="montant_virement" class="form-control col-md-4" placeholder="Montant virement">
                                    <input type="text" value="{{ old('banque_virement') }}" name="banque_virement" class="form-control col-md-4 offset-2" placeholder="Banque">
                                </div>

                                <div class="row mt-2 otherFieldDiv1">
                                    <input type="date" value="{{ old('date_virement') }}" name="date_virement" class="form-control col-md-4">
                                </div>

                            </div>
                            <button type="submit" class="btn btn-success btn-sm" title="Imprimer la facture"><i class="fas fa-print"></i> Enregistrer la facture</button>
                        </form>
                    </div>
                </div>
            </div>

    </div>
    @endcan

    <script src="{{ asset('vendor/js/jquery-3.2.1.slim.min.js') }}"></script>
    <script type="text/javascript">

        $("#paid").change(function() {
            if ($(this).val() == 'CHEQUE') {
                $('.otherFieldDiv').show();
                // $('#specialite').attr('required', '');
            } else {
                $('.otherFieldDiv').hide();
                // $('#specialite').removeAttr('required');
            }

            if ($(this).val() == 'VIREMENT') {
                $('.otherFieldDiv1').show();
            } else {
                $('.otherFieldDiv1').hide();
            }
        });
        $("#paid").trigger("change");
    </script>
    </body>

@stop
