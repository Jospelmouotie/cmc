@extends('layouts.admin')

@section('title', 'CMCU | Surveillance rapprochée des paramètres')

@section('content')

    <body>

    <div class="wrapper">
        @include('partials.side_bar')

        @include('partials.header')
        <div class="row mb-1">
            <div class="col-sm-12">
                <h1 class="text-center ">SURVEILLANCE RAPPROCHEE DES PARAMETRES</h1>
            </div>
        </div>
        <hr>
        @can('show', \App\Models\User::class)
            <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-success float-end"
               title="Retour à la liste des patients">
                <i class="fas fa-arrow-left"></i> Retour au dossier patient
            </a>
            <div class="container">
                <div class="row">
                    @can('infirmier', \App\Models\Patient::class)
                        <button type="button" class="btn btn-primary mb-2 me-2" title="Surveillance pré-opératoire" data-bs-toggle="modal" data-bs-target="#SurveillancePre" data-whatever="@mdo">
                            <i class="far fa-plus-square"></i>
                            PRISE DE PARAMETRES
                        </button>
                    @endcan
                    <div class="col-md-10">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <td>
                                            <h1 class="text-info"><a href="{{ route('surveillance_rapproche', $patient->id) }}">Pré-opératoire</a></h1>
                                        </td>
                                        <td></td>
                                    </tr>
                                    @if (!empty($paramPre))
                                    <tr>
                                        <td class="table-active"><b>DATE :</b></td>
                                        <td class="table-active"><b>{{ $paramPre->date }}</b></td>
                                    </tr>
                                    <tr>
                                        <td><b>HEURE :</b></td>
                                        <td>{{ $paramPre->heure }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>T.A :</b></td>
                                        <td>{{ $paramPre->ta }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>F.R :</b></td>
                                        <td>{{ $paramPre->fr }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>POULS :</b></td>
                                        <td>{{ $paramPre->pouls }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>SPO2 :</b></td>
                                        <td>{{ $paramPre->spo2 }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>T° :</b></td>
                                        <td>{{ $paramPre->temperature }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>DIURESE :</b></td>
                                        <td>{{ $paramPre->diurese }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>CONSCIENCE :</b></td>
                                        <td>{{ $paramPre->conscience }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>DOULEUR :</b></td>
                                        <td>{{ $paramPre->douleur }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>OBSERVATIONS / PLAINTES :</b></td>
                                        <td>{{ $paramPre->observation_plainte }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td>
                                            <h1 class="text-info"><a href="{{ route('surveillance_rapproche', $patient->id) }}">Post-opératoire</a></h1>
                                        </td>
                                        <td></td>
                                    </tr>
                                    @if (!empty($paramPost))
                                        <tr>
                                            <td class="table-active"><b>DATE :</b></td>
                                            <td class="table-active"><b>{{ $paramPost->date }}</b></td>
                                        </tr>
                                        <tr>
                                            <td><b>HEURE :</b></td>
                                            <td>{{ $paramPost->heure }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>T.A :</b></td>
                                            <td>{{ $paramPost->ta }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>F.R :</b></td>
                                            <td>{{ $paramPost->fr }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>POULS :</b></td>
                                            <td>{{ $paramPost->pouls }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>T° :</b></td>
                                            <td>{{ $paramPost->temperature }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>DIURESE :</b></td>
                                            <td>{{ $paramPost->diurese }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>CONSCIENCE :</b></td>
                                            <td>{{ $paramPost->conscience }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>DOULEUR :</b></td>
                                            <td>{{ $paramPost->douleur }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>OBSERVATIONS / PLAINTES :</b></td>
                                            <td>{{ $paramPost->observation_plainte }}</td>
                                        </tr>
                                    @endif

                                    </thead>

                                </table>
                                @include('admin.modal.surveillance_rapproche_param')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endcan

    </div>
    </body>

@stop
