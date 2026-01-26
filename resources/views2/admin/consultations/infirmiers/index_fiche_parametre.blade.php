@extends('layouts.admin')
@section('title', 'CMCU | Fiche de paramètres patient')
@section('content')
    <body>
    <div class="wrapper">
    @include('partials.side_bar')
    <!-- Page Content Holder -->
        @include('partials.header')
        <div class="container">
            <div class="row">
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
                                            <li class="list-group-item"><i class="fa fa-phone"></i> <b>TELEPHONE :</b> {{ $patient->portable_1 }}</li>
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
                                <tr>
                                    <td></td>
                                    <td><h1 class="text-info">PARAMETRES PATIENT</h1></td>
                                </tr>
                                @foreach($parametres as $parametre)
                                    <tr>
                                        <td class="table-active"><b>DATE</b></td>
                                        <td class="table-active">{{ $parametre->created_at->toFormattedDateString() }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>DATE DE NAISSANCE</b></td>
                                        <td> {{ $parametre->date_naissance }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>AGE</b></td>
                                        <td> {{ $parametre->age }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>POIDS</b></td>
                                        <td> {{ $parametre->poids }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>TAILLE</b></td>
                                        <td> {{ $parametre->taille }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>TEMPERATURE</b></td>
                                        <td> {{ $parametre->temperature }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>GLYCEMIE</b></td>
                                        <td> {{ $parametre->glycemie }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>SPO2</b></td>
                                        <td> {{ $parametre->spo2 }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>IMC / BMI</b></td> 
                                        <td> {{ $parametre->inc_bmi }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>TA :</b></td>
                                        <td>
                                            <b>Bg :</b> {{ $parametre->bras_gauche ?? '—' }} mmHg
                                            <br>
                                            <b>Bd :</b> {{ $parametre->bras_droit ?? '—' }} mmHg
                                        </td>
                                    </tr>
                                    <!-- <tr>
                                        <td><b>TA</b></td>
                                        <td> {{ $parametre->ta }}</td>
                                    </tr> -->
                                    <tr>
                                        <td><b>FR</b></td>
                                        <td> {{ $parametre->fr }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>FC</b></td>
                                        <td> {{ $parametre->fc }}</td>
                                    </tr>
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
