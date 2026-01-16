@extends('layouts.admin')
@section('title', 'CMCU | Consultations chirurgien')
@section('content')
    <body>
    <div class="wrapper">
    @include('partials.side_bar')
    <!-- Page Content Holder -->
        @include('partials.header')
        <div class="container">
            <div class="row">
                <h1 class="text-center">CONSULTATIONS DU PATIENT</h1>
                <div class="col-md-12  toppad  offset-md-0 mb-2">
                    <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-success float-end"><i
                            class="fas fa-arrow-left"></i> Retour au dossier patient</a>
                </div>
                <div class="col-md-10">
                    <!-- resumt -->
                    <div class="card">
                        <div class="card-header resume-heading">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="col-12 col-md-12">
                                        <ul class="list-group">
                                            <li class="list-group-item"><b>NOM ET PRENOM DU PATIENT :</b> {{ $patient->name }} {{ $patient->prenom }}</li>
                                            <li class="list-group-item"><i class="fa fa-phone"></i> <b>TELEPHONE :</b> {{ $patient->telephone }}</li>
                                            <li class="list-group-item"><i class="fa fa-envelope"></i> {{ $patient->email }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                @foreach($consultations as $consultation)
                                <tr>
                                    <td class="table-active text-primary"><b><h6>CONSULTATION DU</h6></b></td>
                                    <td class="table-active"><b>{{ $consultation->created_at->toFormattedDateString() }}</b></td>
                                    <!-- <td><a class="btn btn-success btn-action-fixed" title="Imprimer la lettre de sortie" href="{{ route('print.sortie', $patient->id) }}">
                                        <i class="fas fa-print"></i>
                                        </a>
                                    </td> -->
                                </tr>
                                <tr>
                                    <td><b>MEDECIN DE REFERENCE</b></td>
                                    <td> Dr. {{ $consultation->medecin_r }}</td>
                                </tr>
                                <tr>
                                    <td><b>NOM ET PRENOM DU MEDECIN</b></td> 
                                    <td> Dr. {{ $consultation->user->name }}</td>
                                </tr>
                                <tr>
                                    <td><b>MOTIF DE CONSULTATION</b></td>
                                    <td>{{ $consultation->motif_c }}</td>
                                </tr>
                                <tr>
                                    <td><b>INTERROGATOIE</b></td>
                                    <td>{{ $consultation->interrogatoire }}</td>
                                </tr>
                                <tr>
                                    <td><b>EXAMENS PHYSIQUES</b></td>
                                    <td>{{ $consultation->examen_p }}</td>
                                </tr>
                                <tr>
                                    <td><b>EXAMENS COMPLEMENTAIRES</b></td>
                                    <td>{{ $consultation->examen_c }}</td>
                                </tr>
                                <tr>
                                    <td><b>PROPOSITIONS THERAPEUTIQUES</b></td>
                                    <td>{{ $consultation->proposition_therapeutique }}</td>
                                </tr>
                                <tr>
                                    <td><b>PROPOSITIONS DE SUIVI</b></td>
                                    <td>{{ $consultation->proposition }}</td>
                                </tr>
                                @if (!empty($consultation->type_intervention))
                                <tr>
                                    <td><b>TYPE D'INTERVENTION</b></td>
                                    <td>{{ $consultation->type_intervention }}</td>
                                </tr>
                                @endif
                                @if (!empty($consultation->date_intervention))
                                <tr>
                                    <td><b>DATE INTERVENTION</b></td>
                                    <td>{{ $consultation->date_intervention }}</td>
                                </tr>
                                @endif
                                @if (!empty($consultation->acte))
                                <tr>
                                    <td><b>TYPE D'ACTES A REALISER</b></td>
                                    <td>{{ $consultation->acte }}</td>
                                </tr>
                                @endif
                                @if (!empty($consultation->devis_id))
                                <tr>
                                    <td><b>DEVIS PREVISIONNEL</b></td>
                                    <td>{{ $consultation->devis_id }}</td>
                                </tr>
                                @endif
                                @if (!empty($consultation->date_consultation_anesthesiste))
                                <tr>
                                    <td><b>DATE CONSULTATION ANESTHESISTE</b></td>
                                    <td>{{ $consultation->date_consultation_anesthesiste }}</td>
                                </tr>
                                @endif
                                @if (!empty($consultation->date_consultation))
                                <tr>
                                    <td><b>DATE PROCHAINE CONSULTATION</b></td>
                                    <td>{{ $consultation->date_consultation }}</td>
                                </tr>
                                @endif
                                @endforeach

                                </thead>

                            </table>
                        </div>
                    </div>
                </div>
                <!-- resume -->
            </div>

        </div>
    </div>

    </body>
@stop
