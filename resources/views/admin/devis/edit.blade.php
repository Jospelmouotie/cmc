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
                <h1 class="text-center">EDITION DU DEVIS POUR PATIENT</h1>
                <hr>
                <!--  -->

                <a href="{{ route('devis.index') }}" class="btn btn-success float-right mb-2"
                   title="Retour à la liste des patients">
                    <i class="fas fa-arrow-left"></i> Retour à la liste des devis
                </a>
                <div class="card" style="width: 60rem;">
                    <div class="card-body">
                        <h5 class="card-title"><b>{{ $devi->nom }}</b></h5>
                        <small class="text-info" title="Les champs marqués par une étoile rouge sont obligatoire"><i
                                class="fas fa-info-circle"></i></small>
                        <hr>
                        <form class="mb-3 col-md-6" action="{{ route('devis.pdf', $devi->id) }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="nom" class="col-form-label text-md-right"><b>NOM DU PATIENT</b> <span class="text-danger">*</span></label>
                                <select name="patient_id" id="patient_id" class="form-control" required>
                                    <option value="">Nom du patient</option>
                                    @foreach ($patients as $patient)
                                        <option value="{{ $patient->id }}">{{ $patient->name }} {{ $patient->prenom }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success btn-sm me-1" title="Imprimer le devis"><i class="fas fa-print"></i> Imprimer le devis</button>
                        </form>
                    </div>
                </div>
            </div>

    </div>
    @endcan
    </body>

@stop
