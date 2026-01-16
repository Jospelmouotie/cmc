@extends('layouts.admin')
@section('title', 'CMCU | Compte-rendu d\'opérations')
@section('content')
    <body>
    <div class="wrapper">
    @include('partials.side_bar')
    <!-- Page Content Holder -->
        @include('partials.header')
        <div class="container">
            <div class="row">
                <div class="col-md-12  toppad  offset-md-0 ">
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
                    
                                        <h1 class="text-center">COMPTE-RENDU</h1>
                                   
                                </thead>
                                <tbody>
                                    @foreach($compteRenduBlocOperatoires as $compteRenduBlocOperatoire)
                                        <tr>
                                            <td class="table-active"><b>DATE</b></td>
                                            <td class="table-active">{{ $compteRenduBlocOperatoire->created_at->toFormattedDateString() }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>OPERATEUR</b></td>
                                            <td><b>Dr.</b> {{ $compteRenduBlocOperatoire->chirurgien }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>AIDE OPERATOIRE</b></td>
                                            <td><b>Dr.</b> {{ $compteRenduBlocOperatoire->aide_op }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>ANESTHESISTE</b></td>
                                            <td><b>Dr.</b> {{ $compteRenduBlocOperatoire->anesthesiste }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>INFIRMIER ANESTHESISTE</b></td>
                                            <td> {{ $compteRenduBlocOperatoire->infirmier_anesthesiste }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>DATE D'ENTREE</b> </td>
                                            <td>{{ $compteRenduBlocOperatoire->date_e }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>TYPE D'ENTREE</b></td>
                                            <td> {{ $compteRenduBlocOperatoire->type_e }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>DATE DE SORTIE</b></td>
                                            <td> {{ $compteRenduBlocOperatoire->date_s }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>TYPE DE SORTIE</b></td>
                                            <td> {{ $compteRenduBlocOperatoire->types_s }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>DATE INTERVENTION</b></td>
                                            <td> {{ $compteRenduBlocOperatoire->date_intervention }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>DUREE INTERVENTION</b></td>
                                            <td> {{ $compteRenduBlocOperatoire->dure_intervention }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>COMPTE-RENDU OPERATOIRE</b></td>
                                            <td>{{ $compteRenduBlocOperatoire->compte_rendu_o }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>INDICATIONS OPERATOIRE</b></td>
                                            <td>{{ $compteRenduBlocOperatoire->indication_operatoire }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>RESULTATS HISTOPATHOLOGIQUES</b></td>
                                            <td>{{ $compteRenduBlocOperatoire->resultat_histo }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>SUITES OPERATOIRES</b></td>
                                            <td>{{ $compteRenduBlocOperatoire->suite_operatoire }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>TRAITEMENT PROPOSE</b></td>
                                            <td>{{ $compteRenduBlocOperatoire->traitement_propose }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>SOINS</b></td>
                                            <td>{{ $compteRenduBlocOperatoire->soins }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>CONCLUSION</b></td>
                                            <td>{{ $compteRenduBlocOperatoire->conclusion }}</td>
                                        </tr>
                                    @endforeach

                                </tbody>

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
