@extends('layouts.admin')

@section('title', 'CMCU | Liste des produits pharmaceutique')

@section('content')

    <body>
    {{--<div class="se-pre-con"></div>--}}
    <div class="wrapper">
    @include('partials.side_bar')

    <!-- Page Content Holder -->
    @include('partials.header')
    <!--// top-bar -->
        <div class="container">
            <h1 class="text-center">LISTE DES PRODUITS DE L'ANESTHESISTE</h1>
        </div>
        <hr>
        <div class="container">
            @can('anesthesiste', \App\Models\Patient::class)
            <a href="{{ route('pharmaceutique.facturation') }}" title="Proceder à la facturation" class="btn btn-success btn-sm col-md-1 float-end">
                Facture
                <span class="badge text-dark"><p>{{ Session::has('cart') ? Session::get('cart')->totalQte : 0 }}</p></span>
            </a>
            @endcan

            </br>
            </br>
            </br>
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <!--  -->
                        <table id="myTable" class="table table-bordered table-striped" width="100%">
                            <thead>
                            <tr>
                                <td>ID</td>
                                <td>DESIGNATION</td>
                                <td>QUANTITE STOCK</td>
                                <td>QUANTITE ALERTE</td>
                                <td>PRIX UNITAIRE</td>
                                @can('anesthesiste', \App\Models\Patient::class)
                                <td>AJOUTER A LA FACTURE</td>
                                @endcan
                                @can('update', \App\Models\Produit::class)
                                <td>EDITER</td>
                                <td>SUPPRIMER</td>
                                @endcan
                            </tr>
                            <tbody>
                            @foreach($produits as $produit)
                                <tr>
                                    <td>{{$produit->id}}</td>
                                    <td>{{$produit->designation}}</td>
                                    <td>{{$produit->qte_stock}}</td>
                                    <td>{{$produit->qte_alerte}}</td>
                                    <td>{{$produit->prix_unitaire}}</td>
                                    @can('anesthesiste', \App\Models\Patient::class)
                                    <td><a href="{{ route('pharmaceutique.cart', $produit->id) }}" class="btn btn-success" title="Ajouter à la facture"><i class="fas fa-plus-square"></i></a></td>
                                    @endcan
                                    @can('update', \App\Models\Produit::class)
                                    <td><a href="{{ route('produits.edit',$produit->id)}}" title="Enregistrer une nouvelle entré en stock" class="btn btn-primary"><i class="far fa-edit"></i></a></td>
                                    <td>
                                        <form action="{{ route('produits.destroy', $produit->id)}}" method="post">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-danger" title="Supprimer le produit du stock" type="submit"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                    @endcan
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('admin/js/main.js') }}"></script>
    </body>

@endsection
