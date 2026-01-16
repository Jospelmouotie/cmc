@extends('layouts.admin') @section('title', 'CMCU | Liste des produits pharmaceutique') @section('content')

    <body>
    {{--<div class="se-pre-con"></div>--}}
    <div class="wrapper">
    @include('partials.side_bar')

    <!-- Page Content Holder -->
        @include('partials.header')

            <div class="container">
                <h2 class="text-center">FACTURATION</h2>
                <div class="row">
                    <div class="col-md-12 col-lg-10 offset-md-1">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Quantité</th>
                                    <th class="">Prix unitaire</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Reduire</th>
                                    <th class="text-center">Ajouter</th>
                                    <th class="text-center">Supprimer</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if (Session::has('cart'))
                                @foreach($produits as $produit)
                                <tr>
                                    <td class="col-md-8 col-lg-6">
                                        <div class="media-body">
                                            <p class="">{{ $produit['item']['designation'] }}</p>
                                        </div>
                                    </td>
                                    <td class="col-md-1 col-lg-1" style="text-align: center">
                                        <input type="number" class="form-control" id="exampleInputEmail1" value="{{ $produit['quantite'] }}">
                                    </td>
                                    <td class="col-md-1 col-lg-1 text-center"><strong>{{ $produit['prix_unitaire'] }}</strong></td>
                                    <td class="col-md-1 col-lg-1 text-center"><strong>{{ $totalPrix }}</strong></td>
                                    <td>
                                        <a href="{{ route('facturation.reduire', ['id' => $produit['item']['id']]) }}" title="Reduire la quantité" class="btn btn-primary"> <i class="fas fa-minus"></i></a>
                                    </td>
                                    <td>
                                        <a href="{{ route('pharmaceutique.cart', $produit['item']['id']) }}" class="btn btn-success" title="Ajouter la quantité"><i class="fas fa-plus-square"></i></a>
                                    </td>
                                    <td>
                                        <a href="{{ route('facturation.supprimer', ['id' => $produit['item']['id']]) }}" title="Supprimer le produit de la facture" class="btn btn-danger"> <i class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td>&#xA0;</td>
                                <td>&#xA0;</td>
                                <td>&#xA0;</td>
                                <td>&#xA0;</td>
                                <td>&#xA0;</td>
                                <td>
                                    <h3>Total</h3>
                                </td>
                                <td class="text-end">
                                    <h3><strong>{{ $totalPrix }}</strong></h3>
                                </td>
                            </tr>
                            <tr>
                                <td>&#xA0;</td>
                                <td>&#xA0;</td>
                                <td>&#xA0;</td>
                                <td>&#xA0;</td>

                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                        <form action="{{ route('pharmacie.pdf') }}" method="post" class="mb-3">
                            @csrf
                            <td>
                                <label for="patient"><b>Nom du patient :</b></label>
                                <select name="patient" id="patient" class="form-control col-md-5 mb-2">
                                    <option value="">Nom du patient</option>
                                    @foreach ($patient as $patients)
                                        <option value="{{ $patients->name }}">{{ $patients->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            @can('update', \App\Models\Produit::class)
                            <td>
                                <a href="{{ route('produits.pharmaceutique') }}" title="Retour à la liste des produits" class="btn btn-secondary"> <i class="fas fa-arrow-left"></i> Ajouter des produits</a>
                            </td>
                            @endcan
                            @can('anesthesiste', \App\Models\Produit::class)
                            <td>
                                <a href="{{ route('produits.anesthesiste') }}" title="Retour à la liste des produits" class="btn btn-secondary"> <i class="fas fa-arrow-left"></i> Ajouter des produits</a>
                            </td>
                            @endcan

                            <td>
                                <button type="submit" href="{{ route('pharmacie.pdf') }}" title="Imprimer la facture" class="btn btn-success float-end">Imprimer <i class="fas fa-print"></i></button>
                            </td>
                        </form>
                        @endif
                    </div>
                </div>
            </div>

    </div>
    </div>
    <script src="{{ asset('admin/js/main.js') }}"></script>
    </body>

@endsection
