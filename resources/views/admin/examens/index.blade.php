@extends('layouts.admin')

@section('title', 'CMCU | Liste des examens')

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
            <h1 class="text-center">LISTE DES EXAMENS</h1>
        </div>
        <hr>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <!--  -->
                        <table id="myTable" class="table table-bordred table-striped">
                            <thead>
                            @can('print', \App\Models\Patient::class)
                            <th>NOM DU PATIENT</th>
                            <th>TYPE D'EXAMEN</th>
                            <th>CONSULTER</th>
                            <th>AJOUTER</th>
                            @endcan
                            </thead>
                            <tbody>
                             @foreach($patients as $patient)
                             @foreach($patient->examens as $examen)
                                 <tr>
                                 <td> {{ $patient->name }}</td>
                                 <td>{{ $examen->type }}</td>
                                         
                                                @can('consulter', \App\Models\Patient::class)
                                                        <td style="display: inline-flex;">
                                                            <a href="{{ route('examens.show', $examen->id) }}" title="consulter les examens patient" class="btn btn-primary btn-sm me-1"><i class="fas fa-eye"></i></a>
                                                        </td>
                                                @endcan
                                                    @can('consulter', \App\Models\Patient::class)
                                                        <td>
                                                            <a href="{{ route('examens.create', $patient->id) }}" title="ajouter un examen" class="btn btn-info btn-sm me-1"><i class="far fa-calendar-plus"></i></a>
                                                        </td>
                                                @endcan
                                               
                                    </tr>
                                    @endforeach 
                                  @endforeach  
           
                            </tbody>
                        </table>
                        <br>
                        <div class="col-md-12 text-center">

                        <a href="{{ route('patients.index') }}" class="btn btn-success float-end"><i class="fas fa-arrow-left"></i>  Retour à la liste des patients</a>
</div>
                        <div class="clearfix"></div>
                        {{--{{ $patients->links() }}--}}
                    </div>
                </div>
            </div>
        </div>
       
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
