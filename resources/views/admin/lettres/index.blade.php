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
            <h1 class="text-center">LETTRES DE SORTIE</h1>
        </div>
        <hr>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <!--  -->
                        <table id="myTable" class="table table-bordred table-striped">
                            <thead>
                            <th>PATIENT</th>
                            <th>MEDECIN</th>
                            <th>OBJET</th>
                            <th>ACTION</th>
                            </thead>
                            <tbody>

                            @foreach($lettres as $lettre)
                                <tr>
                                    <td>{{ $lettre->patient }}</td>
                                    <td>{{ $lettre->medecin }}</td>
                                    <td>{{ $lettre->objet }}</td>
                                    <td style="display: inline-flex;">
                                    @can('print', \App\Models\Patient::class)
                                        <p data-bs-placement="top" data-bs-toggle="tooltip" title="Delete">
                                            <a class="btn btn-success btn-sm me-1" title="Imprimer la lettre de sortie" href="{{ route('print.sortie', $lettre->id) }}"><i class="fas fa-print"></i></a>
                                        </p>
                                    @endcan
                                    {{--@can('print', \App\Patient::class)--}}
                                        {{--<form action="{{ route('destroy.sortie', $lettre->id) }}" method="post">--}}
                                            {{--@csrf @method('DELETE')--}}
                                            {{--<p data-bs-placement="top" data-bs-toggle="tooltip" title="Delete">--}}
                                                {{--<button type="submit" class="btn btn-danger btn-sm me-1" title="Supprimer la lettre de sortie"  onclick="return myFunction()"><i class="fas fa-trash-alt"></i></button>--}}
                                            {{--</p>--}}
                                        {{--</form>--}}
                                    {{--@endcan--}}
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>

        </div>
    </div>
    @endcan
    <script>
        function myFunction() {
            if(!confirm("Veuillez confirmer la suppréssion de la lettre"))
                event.preventDefault();
        }
    </script>
    </body>
@stop
