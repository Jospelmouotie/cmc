@extends('layouts.admin')
@section('title', 'CMCU | Consultations anesthésiques')
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
                                <tr>
                                    <td></td>
                                    <td><h1 class="text-info">CONSULTATIONS</h1></td>
                                </tr>
                                @foreach($consultationAnesthesistes as $consultationAnesthesiste)
                                    <tr>
                                        <td class="table-active"><b>DATE</b></td>
                                        <td class="table-active">{{ $consultationAnesthesiste->created_at->toFormattedDateString() }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>SPECIALITE</b></td>
                                        <td> {{ $consultationAnesthesiste->specialite }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>MEDECIN TRAITANT</b> </td>
                                        <td>{{ $consultationAnesthesiste->medecin_traitant }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>OPERATEUR</b> </td>
                                        <td>{{ $consultationAnesthesiste->operateur }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>ANESTHESISTE</b> </td>
                                        <td>{{ $consultationAnesthesiste->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>MOTIF DE D'ADMISSION</b> </td>
                                        <td>{{ $consultationAnesthesiste->motif_admission }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>DATE D'INTERVENTION</b> </td>
                                        <td>{{ $consultationAnesthesiste->date_intervention }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>MEMO</b> </td>
                                        <td>{{ $consultationAnesthesiste->memo }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>ANESTHESIE EN SALLE</b> </td>
                                        <td>{{ $consultationAnesthesiste->anesthesi_salle }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>DATE D'HOSPITALISATION</b> </td>
                                        <td>{{ $consultationAnesthesiste->date_hospitalisation }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>CLASSE ASA</b> </td>
                                        <td>{{ $consultationAnesthesiste->classe_asa }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>BENEFICES RISQUES</b> </td>
                                        <td>{{ $consultationAnesthesiste->benefice_risque }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>RISQUES</b> </td>
                                        <td>{{ $consultationAnesthesiste->risque }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>JEUNE PRE-OPERATOIRE</b> </td>
                                        <td>
                                            <p><b>Solide : </b></p>
                                            {{ $consultationAnesthesiste->solide }}
                                            <p><b>Liquide : </b></p>
                                            {{ $consultationAnesthesiste->liquide }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>ANTECEDENTS / TRAITEMENT</b> </td>
                                        <td>{{ $consultationAnesthesiste->antecedent_traitement  }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>ALLERGIES</b> </td>
                                        <td>{{ $consultationAnesthesiste->allergie }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>EXAMENS CLINIQUES</b> </td>
                                        <td>{{ $consultationAnesthesiste->examen_clinique }}</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <p><b>INTUBATION :</b></p>
                                            {{ $consultationAnesthesiste->intubation }}
                                            <p><b>MALLAMPATI :</b></p>
                                            {{ $consultationAnesthesiste->mallampati }}
                                            <p><b>DISTANCE-INTERINCISIVE :</b></p>
                                            {{ $consultationAnesthesiste->distance_interincisive }}
                                            <p><b>DISTANCE-TYROMENTONIERE :</b></p>
                                            {{ $consultationAnesthesiste->distance_tyromentoniere }}
                                            <p><b>MOBILITE SERVICALE :</b></p>
                                            {{ $consultationAnesthesiste->mobilite_servicale }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>TECHNIQUE D'ANESTHESIE</b> </td>
                                        <td>{{ $consultationAnesthesiste->technique_anesthesie1 }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>TECHNIQUE D'ANESTHESIE ENVISAGEE</b> </td>
                                        <td>
                                            @foreach(explode(",", $consultationAnesthesiste->technique_anesthesie) as $technique)
                                                <ul>
                                                    <li>
                                                        {{ $technique }}
                                                    </li>
                                                </ul>
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>ANTIBIOPROPHYLAXIE</b> </td>
                                        <td>{{ $consultationAnesthesiste->antibiotique }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>SYNTHES PREOPERATOIRE</b> </td>
                                        <td>{{ $consultationAnesthesiste->synthese_preop }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>EXAMENS PARACLINIQUES</b> </td>
                                        <td>
                                            @foreach(explode(",", $consultationAnesthesiste->examen_paraclinique) as $examen)
                                                <ul>
                                                    <li>
                                                        {{ $examen }}
                                                    </li>
                                                </ul>
                                            @endforeach
                                        </td>
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
