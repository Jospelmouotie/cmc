@extends('layouts.admin')

@section('title', 'CMCU | Fiches de consommables')

@section('content')

    <body>

    <style type="text/css">
        .tt-dropdown-menu {
            width: 100% !important;
        }
        .tt-menu {
            width: 422px;
            margin: 12px 0;
            padding: 8px 0;
            background-color: #fff;
            border: 1px solid #ccc;
            border: 1px solid rgba(0, 0, 0, 0.2);
            -webkit-border-radius: 8px;
            -moz-border-radius: 8px;
            border-radius: 8px;
            -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, .2);
            -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, .2);
            box-shadow: 0 5px 10px rgba(0, 0, 0, .2);
        }
        .tt-suggestion:hover {
            cursor: pointer;
            color: #fff;
            background-color: #0097cf;
        }
        #scrollable-dropdown-menu {
            max-height: 150px;
            overflow-y: auto;
        }
        .tt-suggestion p {
            margin: 0;
        }
    </style>

    <div class="wrapper">
        @include('partials.side_bar')

        @include('partials.header')
        @can('show', \App\Models\User::class)
        <div class="row mb-1">
            <div class="col-sm-12">
                <h1 class="text-center">FICHES DE CONSOMMABLES </h1>
            </div>
        </div>
        <hr>
            <div class="container">
                <div class="d-grid gap-2 mb-2 d-md-block">
                    <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-success float-end"
                       title="Retour à la liste des patients">
                        <i class="fas fa-arrow-left"></i> Retour au dossier patient
                    </a>
                    <a href="{{ route('patients.index') }}" class="btn btn-success offset-0">
                        <i class="fas fa-list-ul"></i>
                        Liste des patients
                    </a>
                </div>
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr >
                                <th class="text-center" width="60%">CONSOMMABLES</th>
                                <th class="text-center" width="10%">P</th>
                                <th class="text-center" width ="10%">G</th>
                                <th class="text-center border-right-0" width ="20%">DATE</th>
                                <th class="border-left-0"></th>
                            </tr>
                            </thead>
                            <tbody>
                           
                             
                             {!! Html::form('POST', route('fiche_consommable.store', $consommable->id)) !!}
                            @csrf
                               
                                {!! Html::input('hidden', 'patient_id', $patient->id, ['']) !!}

                                  {!! Html::input('hidden', 'user_id', $user_id) !!}
                                <tr>
                                    <td>{!! Html::input('search', 'consommable', null, ['class' => 'form-control col-md-10 typeahead tt-query', 'spellcheck' => 'false', 'autocomplete' => 'off', 'id' => 'search', 'required' => 'required']) !!}</td>
                                    <td>{!! Html::input('number', 'jour', null, ['class' => 'form-control', 'min' => 0]) !!}</td>
                                    <td>{!! Html::input('number', 'nuit', null, ['class' => 'form-control', 'min' => 0]) !!}</td>
                                    <td class="border-right-0">{!! Html::input('date', 'date', Carbon\Carbon::now()->ToDateString(), ['class' => 'form-control', 'required' => 'required']) !!}</td>
                                    <td class="border-left-0"></td>
                                </tr>
                                <tr>
                                    <td class="border-right-0">{!! Html::button('Enregistrer')->type('submit')->class('btn btn-primary') !!}</td>
                                    <td class="border-right-0 border-left-0"></td>
                                    <td class="border-left-0 border-right-0"></td>
                                    <td class="border-left-0 border-right-0"></td>
                                    <td class="border-left-0"></td>
                                </tr>
                            {!! Html::form()->close() !!}
                            <tr>
                                <td class="table-active"><b>CONSOMMABLES</b></td>
                                <td class="table-active">P</td>
                                <td class="table-active">G</td>
                                <td class="table-active">DATE</td>
                                <td class="table-active">IDE</td>
                            </tr>
                            @foreach($consommables as $consommable)
                            <tr>
                                <td>{{ $consommable->consommable }}</td>
                                <td>{{ $consommable->jour }}</td>
                                <td>{{ $consommable->nuit }}</td>
                                <td>{{ $consommable->date }}</td>
                                <td>{{ $consommable->user->name }}</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endcan
    </div>

    </body>

@stop
