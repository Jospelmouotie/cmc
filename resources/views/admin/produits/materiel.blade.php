@extends('layouts.admin')

@section('title', 'CMCU | Liste des produits materiels')

@section('content')

    <body>
    {{--<div class="se-pre-con"></div>--}}
    <div class="wrapper">
    @include('partials.side_bar')

    <!-- Page Content Holder -->
    @include('partials.header')
    <!--// top-bar -->
        <div class="container">
            <h1 class="text-center">LISTE DES PRODUITS MATERIELS</h1>
        </div>
        <hr>
        <div class="col-md-3 offset-md-8 text-center">

            <a href="" class=" btn btn-danger " style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span>&#xA0;
                <h2>TOTAL PRODUIT :</h2>
                <h1><P>{{"$materielCount"}}</P> </h1>
            </a>
        </div>
        <div class="container">
            </br>
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <!--  -->
                        <table id="myTable" class="table table-bordred table-striped">
                            <thead>
                            <tr>
                                <td>ID</td>
                                <td>DESIGNATION</td>
                                <td>CATEGORIE</td>
                                <td>QUANTITE STOCK</td>
                                <td>QUANTITE ALERTE</td>
                                <td>PRIX UNITAIRE</td>
                                <td>EDITER</td>
                                <td>SUPPRIMER</td>
                            </tr>
                            <tbody>
                            @foreach($produits as $produit)
                                <tr>
                                    <td>{{$produit->id}}</td>
                                    <td>{{$produit->designation}}</td>
                                    <td>{{$produit->categorie}}</td>
                                    <td>{{$produit->qte_stock}}</td>
                                    <td>{{$produit->qte_alerte}}</td>
                                    <td>{{$produit->prix_unitaire}}</td>
                                    <td><a href="{{ route('produits.edit',$produit->id)}}" title="Enregistrer une nouvelle entré en stock" class="btn btn-primary"><i class="far fa-edit"></i></a></td>
                                    <td>
                                        <form action="{{ route('produits.destroy', $produit->id)}}" method="post">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-danger" title="Supprimer le produit du stock" type="submit"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </td>
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
