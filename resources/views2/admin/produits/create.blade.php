@extends('layouts.admin')

@section('title', 'CMCU | Ajouter un produit')

@section('content')

    <body>
    {{--<div class="se-pre-con"></div>--}}
    <div class="wrapper">
    @include('partials.side_bar')
    <!-- Page Content Holder -->
    @include('partials.header')
    <!--// top-bar -->
        @can('create', \App\Models\Produit::class)
        <div class="container">
            <h1 class="text-center">AJOUTER UN PRODUIT</h1>
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
                    <form class="mb-3 col-md-10" method="post" action="{{ route('produits.store') }}">
                        <div class="mb-3">
                            @csrf
                            <label for="designation">Désignation <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="designation" value="{{ old('designation') }}" required/>
                        </div>
                        <div class="mb-3">
                            <label for="categorie">Catégorie <span class="text-danger">*</span></label>
                            <select class="form-control" name="categorie" id="categorie" required>
                                <option value="PHARMACEUTIQUE">PHARMACEUTIQUE</option>
                                <option value="MATERIEL">MATERIEL</option>
                                <option value="ANESTHESISTE">ANESTHESISTE</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="qte_stock">Quantité <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="qte_stock" value="{{ old('qte_stock') }}" required/>
                        </div>
                        <div class="mb-3">
                            <label for="qte_alerte">Quanité d'alerte <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="qte_alerte" value="{{ old('qte_alerte') }}" required/>
                        </div>
                        <div class="mb-3">
                            <label for="prix_unitaire">Prix unitaire <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="prix_unitaire" value="{{ old('prix_unitaire') }}" required/>
                        </div>
                        <button type="submit" class="btn btn-primary" title="Enregistrement d'un nouveau produit">Enregistrer</button>
                        <a href="{{ route('produits.index') }}" class="btn btn-info float-end" title="Retour à la liste des produits"><i
                                class="fas fa-arrow-left"></i> Retour à la liste des produits</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endcan
    </body>
@endsection
