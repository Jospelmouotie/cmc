@extends('layouts.admin')

@section('title', 'CMCU | Surveillance rapprochée des paramètres')

@section('content')

    <body>
    <style>
        .custom-table{border-collapse:collapse;width:100%;border:solid 1px #c0c0c0;font-family:open sans;font-size:11px}
        .custom-table th,.custom-table td{text-align:left;padding:8px;border:solid 1px #c0c0c0}
        .custom-table th{color:#000080}
        .custom-table tr:nth-child(odd){background-color:#f7f7ff}
        .custom-table>thead>tr{background-color:#dde8f7!important}
        .tbtn{border:0;outline:0;background-color:transparent;font-size:13px;cursor:pointer}
        .toggler{display:none}
        .toggler1{display:table-row;}
        .custom-table a{color: #0033cc;}
        .custom-table a:hover{color: #f00;}
        .page-header{background-color: #eee;}
    </style>

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
            <a href="{{ route('surveillance_rapproche.index', $patient->id) }}" class="btn btn-success float-end  mb-2"
               title="Retour à la liste des patients">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
            <div class="container">
                <table class="custom-table">
                    <thead>
                    <tr>
                        <th>PERIODES</th>
                        <th>DATE / HEURE</th>
                        <th>T.A</th>
                        <th>F.R</th>
                        <th>POULS</th>
                        <th>SPO2</th>
                        <th>T°</th>
                        <th>DIURESE</th>
                        <th>CONSCIENCE</th>
                        <th>DOULEUR</th>
                        <th>OBSERVATIONS / PLAINTES</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td colspan="20" class="page-header"><button type="button" class="tbtn"><i class="fa fa-plus-circle fa-minus-circle"></i>   Pré-opératoire</button> </td>
                    </tr>
                        @if (!empty($paramPres))
                            @foreach ($paramPres as $paramPre)
                                <tr class="toggler toggler1">
                                    <td></td>
                                    <td><b>{{ $paramPre->date }} / {{ $paramPre->heure }}</b></td>
                                    <td>{{ $paramPre->ta }}</td>
                                    <td>{{ $paramPre->fr }}</td>
                                    <td>{{ $paramPre->pouls }}</td>
                                    <td>{{ $paramPre->spo2 }}</td>
                                    <td>{{ $paramPre->temperature }}</td>
                                    <td>{{ $paramPre->diurese }}</td>
                                    <td>{{ $paramPre->conscience }}</td>
                                    <td>{{ $paramPre->douleur }}</td>
                                    <td>{{ $paramPre->observation_plainte }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                    <tbody>
                    <tr>
                        <td colspan="20" class="page-header"><button type="button" class="tbtn"><i class="fa fa-plus-circle"></i>    Post-opératoire</button></td>
                    </tr>
                        @if (!empty($paramPosts))
                            @foreach ($paramPosts as $paramPost)
                                <tr class="toggler">
                                <td></td>
                                <td><b>{{ $paramPost->date }} / {{ $paramPost->heure }}</b></td>
                                <td>{{ $paramPost->ta }}</td>
                                <td>{{ $paramPost->fr }}</td>
                                <td>{{ $paramPost->pouls }}</td>
                                <td>{{ $paramPost->spo2 }}</td>
                                <td>{{ $paramPost->temperature }}</td>
                                <td>{{ $paramPost->diurese }}</td>
                                <td>{{ $paramPost->conscience }}</td>
                                <td>{{ $paramPost->douleur }}</td>
                                <td>{{ $paramPost->observation_plainte }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        @endcan

    </div>

    </body>

@stop
