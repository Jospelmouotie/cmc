@extends('layouts.admin') @section('title', 'CMCU | Ajouter une fiche une chambre') @section('content')
    <body>
    {{--<div class="se-pre-con"></div>--}}
    <div class="wrapper">
    @include('partials.side_bar')

    <!-- Page Content Holder -->
        @include('partials.header')
        <div class="container">
            <h1 class="text-center">AJOUTER UNE CHAMBRE</h1>
            <hr>
            <!--  -->
            <!--  -->
            <div class="col-md-6">
                <form method="post" action="{{ route('chambres.store') }}">
                    @csrf
                    <div class="mb-3 fw-bold">
                        <label for="name">NUMERO:</label>
                        <input type="text" class="form-control" name="numero"  />
                    </div>
                    <div class="mb-3 fw-bold">
                        <label for="exampleFormControlSelect1">CATEGORIE</label>
                        <select class="form-control" name="categorie" id="exampleFormControlSelect1">
                            <option value="">Veuillez choisir la catégorie</option>
                            <option value="Classique">Classique</option>
                            <option value="vip">VIP</option>
                            <option value="bloc">Bloc</option>
                        </select>
                    </div>
                    <select class="form-control" name="prix" id="exampleFormControlSelect1">
                        <option>Cout de la chambre</option>
                        <option value="2500">2500</option>
                        <option value="5000">5000</option>
                        <option value="10000">10000</option>
                        <option value="0">0</option>
                    </select>
                    <br>
                    <br>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary ">ENREGISTRER</button>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('chambres.index') }}" class="btn btn-success float-end"
                            title="Retour">
                                <i class="fas fa-arrow-left"></i> Retour
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </body>
@endsection