@extends('layouts.admin')

@section('title', 'CMCU | Liste des patients')

@section('content')

    <body>
    {{--<div class="se-pre-con"></div>--}}
    <div class="wrapper">
    @include('partials.side_bar')

    <!-- Page Content Holder -->
    @include('partials.header')
    <!--// top-bar -->
        @can('create', \App\Models\Patient::class)
        <div class="container">
            <h1 class="text-center">LISTE DES PATIENTS</h1>
        </div>
        <hr>
        <div class="container">
            <!--  -->
            <div class="row">
                <div class="col-lg-12">
                <form action="{{ route('search.results') }}" method="post">
                    @csrf
                    <label for="name">Name:</label>
                    <input type="text" name="name" id="name" class="form-control col-md-5" required>
                    <button type="submit" class="btn btn-primary btn-lg">Search</button>
                </form>
                @if (isset($patients))
                    <div class="table-responsive">
                        <p>Results of your reasearch on <strong>{{$name}}</strong></p><br>
                        <table id="myTable" class="table table-bordered table-hover" width="100%">
                            <thead>
                            <th>NUMERO</th>
                            <th>NOM </th>
                            <th>PRENOM</th>
                            <th>Assurance</th>
                            <th>DATE DE CREATION</th>
                            <th>ACTION</th>
                            </thead>
                            <tbody>

                            @foreach($patients as $patient)
                                <tr>
                                    <td>
                                        CMCU - {{ $patient->numero_dossier }}
                                        @if($patient->isNew())
                                            <span class="badge bg-success ms-2 animate-pulse">NOUVEAU</span>
                                        @endif
                                    </td>
                                    <td>{{ $patient->name }}</td>
                                    <td>{{ $patient->prenom }}</td>
                                    <td>{{ $patient->prise_en_charge }}</td>
                                    <td>{{ $patient->date_insertion}}</td>
                                    <td>
                                        <div class="d-flex"> 
                                        @can('consulter', \App\Models\Patient::class)
                                            <a href="{{ route('patients.show', $patient->id) }}" title="consulter le dossier du patient" class="btn btn-primary btn-sm me-1">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                        @endcan
                                        {{--
                                        @can('create', \App\Models\Event::class)
                                        <a href="{{ route('events.index') }}" title="Prendre un rendez-vous" class="btn btn-info btn-sm me-1"><i class="fas fa-calendar-plus"></i></a>
                                        @endcan
                                        --}}
                                        @can('print', \App\Models\Patient::class)
                                        
                                                <a class="btn btn-success btn-sm me-1" title="Générer la facture" href="{{ route('consultation.pdf', $patient->id) }}" onClick='if(this.disabled){ return false; } else { this.disabled = true; }'><i class="far fa-plus-square"></i></a>
                                            </p>
                                        @endcan
                                        @can('delete', \App\Models\Patient::class)
                                            <form action="{{ route('patients.destroy', $patient->id) }}" method="post">
                                                @csrf @method('DELETE')
                                                <p data-bs-placement="top" data-bs-toggle="tooltip" title="Delete">
                                                    <button type="submit" class="btn btn-danger btn-sm me-1" title="Supprimer le dossier du patient"  onclick="return myFunction()"><i class="fas fa-trash-alt"></i></button>
                                                </p>
                                            </form>
                                        @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                        <div class="clearfix"></div>

                        {{--{{ $patients->links() }}--}}
                    </div>
                @endif
                </div>
            </div>
        </div>
        @can('print', \App\Models\Patient::class)
            <div class="text-center table_link_right">

                <a href="{{ route('patients.create') }}" class="btn btn-primary" title="Vous allez jouter un nouveau patient dans le système">Ajouter un patient</a>

            </div>
        @endcan

        </div>
    </div>
    @endcan
    <script>
        function myFunction() {
            if(!confirm("Veuillez confirmer la suppréssion du dossier patient"))
                event.preventDefault();
        }
    </script>
    </body>
@stop
