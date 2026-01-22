@extends('layouts.admin')

@section('title', 'CMCU | Bilan facure')

@section('content')

    <body>
    {{--<div class="se-pre-con"></div>--}}
    <div class="wrapper">
    @include('partials.side_bar')

    <!-- Page Content Holder -->
    @include('partials.header')
    <!--// top-bar -->
        @can('view', \App\Models\User::class)
            <div class="container_fluid">
                <h1 class="text-center">FACTURES DEVIS</h1>
                <hr>
            </div>
            <div class="container pt-3">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <!--  -->
                        <table id="myTable" class="table table-striped table-bordered dt-responsive display nowrap td-responsive" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <td>ID</td>
                                <td>PATIENT</td>
                                <td>DESIGNATION</td>
                                <td>MONTANT</td>
                                <td>ACTION</td>
                            </tr>
                            <tbody>
                            @foreach($facture_devis as $facture_devi)
                                <tr>
                                    <td>{{$facture_devi->numero_facture}}</td>
                                    <td>{{$facture_devi->patient->name }} {{$facture_devi->patient->prenom }}</td>
                                    <td>{{$facture_devi->designation_devis }}</td>
                                    <td>{{$facture_devi->montant_devis }} <b>FCFA</b></td>
                                    <td style="display: inline-flex;">
                                        <p class="me-2" data-bs-placement="top" data-bs-toggle="tooltip" title="Voire les détails">
                                            <a class="btn btn-success btn-sm me-1" title="Imprimer la facture de devis" href="{{ route('facture_devis.pdf', $facture_devi->id) }}"><i class="fas fa-print"></i></a>
                                        </p>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- <a href="{{ route('facture_devis.create') }}" class="btn btn-primary table_link_right"> Ajouter une facture</a> -->
                </div>
            </div>
    </div>
    </div>
    @endcan

    </body>

@endsection
