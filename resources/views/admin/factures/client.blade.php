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
            <div class="container">
                <h1 class="text-center">FACTURES CLIENTS</h1>
                <hr>
            </div>
            <div class="col-md-3 offset-md-8 text-center">
            </div>
            <div class="container">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <!--  -->
                        <table id="myTable" class="table table-striped table-bordered dt-responsive display nowrap td-responsive" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                            <td>ID</td>
                                <td>PATIENT</td>
                                <td>MOTIF</td>
                                <td>MONTANT</td>
                                <td>AVANCE</td>
                                <td>MEDECIN</td>
                                <td>DATE</td>
                                <td>ACTION</td>
                            </tr>
                            <tbody>
                            @foreach($facturesClients as $facture)
                                <tr>
                                    <td>{{$facture->id}}</td>
                                    <td>{{$facture->nom }}</td>
                                    <td>{{$facture->motif }}</td>
                                    <td>{{$facture->montant }} <b>FCFA</b></td>
                                    <td>{{$facture->avance }} <b>FCFA</b></td>
                                    <td>{{$facture->medecin_r }}</td>
                                    <td>{{$facture->created_at}}</td>
                                    <td style="display: inline-flex;">
                                        <p class="me-2" data-bs-placement="top" data-bs-toggle="tooltip" title="Voire les détails">
                                            <a class="btn btn-success btn-sm me-1" title="Imprimer la facture du client" href="{{ route('factures.client_pdf', $facture->id) }}"><i class="fas fa-print"></i></a>
                                        </p>
                                        @can('update', \App\Models\User::class)
                                            <form action="{{ route('factures.destroy', $facture->id) }}" method="post">
                                                @csrf @method('DELETE')
                                                <p data-bs-placement="top" data-bs-toggle="tooltip" title="Supprimer la facture">
                                                    <button type="submit" class="btn btn-danger btn-sm"  onclick="return myFunction()"><i class="fas fa-trash-alt"></i></button>
                                                </p>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        
                        <form class="mb-3 col-4" method="POST" action="{{ route('bilan_clientexterne.pdf') }}">
                            @csrf
                          <div class="input-group mb-3">
                            <select name="day" class="form-control" required>
                                <option>Bien vouloir choisir une date</option>
                                @foreach($lists as $list)
                                    <option value="{{ $list }}">{{ $list }}</option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                              <button class="btn btn-primary">Imprimer</button>
                            </div>
                          </div>
                        </form>
                        {{--{{ $factures->links() }}--}}
                        
                    </div>
                </div>
            </div>
    </div>
    </div>
    @endcan

    </body>

@endsection
