@extends('layouts.admin') @section('title', 'CMCU | Liste des produits pharmaceutique') @section('content')

    <body>
    {{--<div class="se-pre-con"></div>--}}
    <div class="wrapper">
    @include('partials.side_bar')

    <!-- Page Content Holder -->
        @include('partials.header')

        <div class="container">
            <h2 class="text-center">DETAILS DE LA FACTURE - {{ $facture->numero }}</h2>
            <div class="row">
                <div class="col-12 col-lg-10 offset-md-1">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>DESIGNATION</th>
                                <th>PATIENT</th>
                                <th>QUANTITE</th>
                                <th>PRIX UNITAIRE</th>
                                <th>DATE D'EMISSION</th>
                            </tr>
                        </thead>
                        <tbody>
                                <tr>
                                    <td>
                                        <p class="">Produits pharmaceutiques</p>
                                    </td>
                                    <td>
                                        <p class="">{{ $facture->patient }}</p>
                                    </td>
                                    <td>
                                        <p>{{ $facture->quantite_total }}</p>
                                    </td>
                                    <td>
                                        <p>{{ $facture->pivot }}</p>
                                    </td>
                                    <td>
                                        <p>{{ $facture->created_at }}</p>
                                    </td>
                                </tr>
                            <tr>
                                <td>
                                    <h3>Total</h3>
                                </td>
                                <td></td>
                                <td class="text-end">
                                    <h3><strong>{{ $facture->prix_total }} Fcfa</strong></h3>
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>

                    <td>
                        <a href="{{ route('pharmacie.pdf') }}" title="Imprimer la facture" class="btn btn-success float-end">Imprimer <i class="fas fa-print"></i></a>
                    </td>

                </div>
            </div>
        </div>

    </div>
    </div>
    <script src="{{ asset('admin/js/main.js') }}"></script>
    </body>

@endsection
