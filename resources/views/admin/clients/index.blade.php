@extends('layouts.admin')

@section('title', 'CMCU | Liste des clients')

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
            <h1 class="text-center">LISTE DES CLIENTS</h1>
        </div>
        <hr>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <!--  -->
                        <table id="myTable" class="table table-bordred table-striped">
                            <thead>
                           
                            <th>NOM </th>
                            <th>PRENOM </th>
                            <th>DATE DE CREATION</th>
                            <th>ACTION</th>
                            </thead>
                            <tbody>

                            @foreach($clients as $client)
                                <tr>
                                   
                                    <td>{{ $client->nom }}</td>
                                    <td>{{ $client->prenom }}</td>
                                    <td>{{ $client->created_at->toFormattedDateString() }}</td>
                                    <td style="display: inline-flex;">
                                         @can('consulter', \App\Models\Patient::class)
                                   
                                        <p data-bs-placement="top" data-bs-toggle="tooltip" title="Delete">
                                            <a class="btn btn-success btn-sm me-1" title="Générer la facture du client" href="{{ route('clientP.pdf', $client->id) }}" onClick='if(this.disabled){ return false; } else { this.disabled = true; }'><i class="far fa-plus-square"></i></a>
                                        </p>
                                        @endcan
                                        @can('delete', \App\Models\Patient::class)
                                        <form action="{{ route('clients.destroy', $client->id) }}" method="post">
                                            @csrf @method('DELETE')
                                            <p data-bs-placement="top" data-bs-toggle="tooltip" title="Delete">
                                                <button type="submit" class="btn btn-danger btn-sm me-1" title="Supprimer le dossier du client"  onclick="return myFunction()"><i class="fas fa-trash-alt"></i></button>
                                            </p>
                                        </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                        <div class="clearfix"></div>
                        {{--{{ $clients->links() }}--}}
                    </div>
                </div>
            </div>
        </div>
        @can('print', \App\Models\Patient::class)
            <div class="col-md-12 text-center">

                <a href="{{ route('clients.create') }}" class="btn btn-primary" title="Vous allez jouter un nouveau client dans le système">Ajouter un client</a>

            </div>
         @endcan
        </div>
    </div>
   
    <script>
        function myFunction() {
            if(!confirm("Veuillez confirmer la suppréssion du dossier client"))
                event.preventDefault();
        }
    </script>
     @endcan
    </body>
@stop
