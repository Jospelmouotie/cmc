@extends('layouts.admin')

@section('title', 'CMCU | Observations médicales')

@section('content')

    <body>
    
    <div class="wrapper">
        @include('partials.side_bar')

        @include('partials.header')
        <div class="row mb-1">
            <div class="col-sm-12">
                <h1 class="text-center ">Surveillance d'aptitude ≥ 9/10 </h1>
            </div>
        </div>
        <hr>
        @can('show', \App\Models\User::class)
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-between">
                            
                            {{-- Button on the LEFT: PATIENTS --}}
                            <a href="{{ route('patients.index') }}" class="btn btn-primary" title="Retour vers la liste des patients">
                                <i class="fas fa-list-ul"></i> PATIENTS
                            </a>
                            
                            {{-- Button on the RIGHT: Retour au dossier patient --}}
                            <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-success" title="Retour au dossier patient">
                                <i class="fas fa-arrow-left"></i> Retour au dossier patient
                            </a>
                            
                        </div>
                    </div>
                </div>

                <br>
                <div class="table-responsive">
                    @can('infirmier', \App\Models\Patient::class)
                        <button type="button" class="btn btn-success"
                                title="Administrer des soins" data-bs-toggle="modal" data-bs-target="#SurveillanceAptitude">
                            <i class="fas fa-user-secret"></i>
                        </button>
                    @endcan
                    <table class="table table-bordered table-striped col-md-12">
                        @can('med_inf_anes', \App\Models\Patient::class)
                            <tr>
                                <th colspan="0">HORAIRES</th>
                                @foreach($surveillance_scores as $surveillance_score)
                                <td colspan="0">{{ $surveillance_score->horaire }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <th colspan="0">TA s/d</th>
                                @foreach($surveillance_scores as $surveillance_score)
                                <td colspan="0">{{ $surveillance_score->ta }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <th>FC</th>
                                @foreach($surveillance_scores as $surveillance_score)
                                <td>{{ $surveillance_score->fc }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <th>SPO2</th>
                                @foreach($surveillance_scores as $surveillance_score)
                                <td>{{ $surveillance_score->spo2 }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <th>FR</th>
                                @foreach($surveillance_scores as $surveillance_score)
                                <td>{{ $surveillance_score->fr }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <th>DOULEUR (EN/EVA)</th>
                                @foreach($surveillance_scores as $surveillance_score)
                                <td>{{ $surveillance_score->douleur }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <th>TEMPERATURE</th>
                                @foreach($surveillance_scores as $surveillance_score)
                                <td>{{ $surveillance_score->temperature }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <th>GLYCEMIE</th>
                                @foreach($surveillance_scores as $surveillance_score)
                                <td>{{ $surveillance_score->glycemie }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <th>SEDATION</th>
                                @foreach($surveillance_scores as $surveillance_score)
                                <td>{{ $surveillance_score->sedation }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <th>NAUSEES</th>
                                @foreach($surveillance_scores as $surveillance_score)
                                <td>{{ $surveillance_score->nausee }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <th>VOMISSEMENTS</th>
                                @foreach($surveillance_scores as $surveillance_score)
                                <td>{{ $surveillance_score->vomissement }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <th>SAIGNEMENTS</th>
                                @foreach($surveillance_scores as $surveillance_score)
                                <td>{{ $surveillance_score->saignement }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <th>PANSEMENTS</th>
                                @foreach($surveillance_scores as $surveillance_score)
                                <td>{{ $surveillance_score->pansement }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <th>DRAINS</th>
                                @foreach($surveillance_scores as $surveillance_score)
                                <td>{{ $surveillance_score->drains }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <th>MICTION</th>
                                @foreach($surveillance_scores as $surveillance_score)
                                <td>{{ $surveillance_score->miction }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <th>LEVER</th>
                                @foreach($surveillance_scores as $surveillance_score)
                                <td>{{ $surveillance_score->lever }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <th>SCORE</th>
                                @foreach($surveillance_scores as $surveillance_score)
                                <td>{{ $surveillance_score->score }}</td>
                                @endforeach
                            </tr>
                        @endcan
                    </table>
                </div>
            </div>
        @endcan

        {{--        MODAL ZONE--}}
        @include('admin.modal.surveillance_aptitude_form')
        {{--END MODAL ZONE--}}
    </div>
    </body>

@stop
