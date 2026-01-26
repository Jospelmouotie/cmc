@extends('layouts.admin') @section('title', 'CMCU | Nouvelle fiche') @section('content')

<body>
{{--<div class="se-pre-con"></div>--}}
<div class="wrapper">
    @include('partials.side_bar')

    <!-- Page Content Holder -->
    @include('partials.header')
    <div class="container">
        <div class="row">
            <div class="col-12 col-6 col-lg-6">
                <div class="card bg-light card-body mb-3 card bg-faded p-1 mb-3">
                    <div class="row">
                        <div class="col-6 col-lg-8">
                            <p> Nom: {{ $fiche->nom }}</p><br>
                            <p> Prénom: {{ $fiche->prenom }}</p><br>
                            <p> Numéro de chambre: {{ $fiche->chambre_numero }}</p><br>
                            <p> Age: {{ $fiche->age }}</p><br>
                            <p> Service: {{ $fiche->service }}</p><br>
                            <p> Infirmier en charge: {{ $fiche->infirmier_charge }}</p><br>
                            <p> Accueil: {{ $fiche->accueil }}</p><br>
                            <p> Restauration: {{ $fiche->restauration }}</p><br>
                            <p> Chambre: {{ $fiche->chambre }}</p><br>
                            <p> Soins: {{ $fiche->soins }}</p><br>
                            <p> Note: {{ $fiche->notes }}</p><br>
                            <p> Recommandation: {{ $fiche->quizz }}</p><br>
                            <p> Remarques/Suggestions: {{ $fiche->remarque_suggestion }}</p><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button class="btn btn-primary" >
        <a href="{{ route('fiches.index') }}">Retour</a>
    </button>
</div>
</body>

@stop
