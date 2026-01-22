@extends('layouts.admin') @section('title', 'CMCU | Modifier un produit') @section('content')

    <body>
    {{--<div class="se-pre-con"></div>--}}
    <div class="wrapper">
    @include('partials.side_bar')

    <!-- Page Content Holder -->
    @include('partials.header')
    <!--// top-bar -->
        @can('create', App\Models\Produit::class)
        <div class="container">
            <h1 class="text-center">MODIFIER UN PRODUIT</h1>
            <hr>
            <div class="row">
                <div class="col-md-7">
                    <!--  -->
                </div>
            </div>

            <div class="card" style="width: 40rem;">
                <div class="card-body">
                    <small class="text-info" title="Les champs marqués par une étoile rouge sont obligatoire"><i class="fas fa-info-circle"></i></small>
                    <hr>
                    <form class="mb-3 col-md-10" method="post" action="{{ route('produits.update', $produit->id) }}">
                        @method('PATCH')
                        @csrf
                        <div class="mb-3">
                            <label for="designation">Désignation</label>
                            <input type="text" class="form-control" name="designation" value="{{ $produit->designation }}" disabled/>
                        </div>
                        <div class="mb-3">
                            <label for="categorie">Catégorie</label>
                            <select class="form-control" name="categorie" id="categorie" disabled>
                                <option value="{{ $produit->id }}"  {{ $produit->id == ' ' ? 'selected' : '' }}>{{ $produit->categorie }}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="qte_stock">Quantité <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="qte_stock" value="{{ $produit->qte_stock }}" required/>
                        </div>
                        <div class="mb-3">
                            <label for="qte_alerte">Quanité d'alerte</label>
                            <input type="text" class="form-control" name="qte_alerte" value="{{ $produit->qte_alerte }}" disabled/>
                        </div>
                        <div class="mb-3">
                            <label for="prix_unitaire">Prix unitaire</label>
                            <input type="text" class="form-control" name="prix_unitaire" value="{{ $produit->prix_unitaire }}" disabled/>
                        </div>
                        <button type="submit" class="btn btn-primary" title="Enregistrement d'un nouveau produit">Enregistrer</button>
                        <a href="{{ route('produits.index') }}" class="btn btn-info float-end" title="Retour à la liste des produits"><i
                                class="fas fa-arrow-left"></i> Retour à la liste des produits</a>
                    </form>
                </div>
            </div>

            </div>
        @endcan
    </div>
    </body>
@endsection
