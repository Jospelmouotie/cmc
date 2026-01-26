@extends('layouts.admin')

@section('title', 'CMCU |  Modifier la fiche de stisfaction')

@section('content')
    <body>
    {{--<div class="se-pre-con"></div>--}}
    <div class="wrapper">
    @include('partials.side_bar')

    <!-- Page Content Holder -->
        @include('partials.header')
        <div class="container">
            <h1 class="text-center">MODIFIER FICHE LA DE SATISFACTION</h1>
            <hr>
            <!--  -->
            <!--  -->
            <div class="col-6">
                <form method="post" action="{{ route('fiches.update', $fiche->id) }}">
                    {{method_field('PATCH')}} @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">NOM:</label>
                        <input type="text" class="form-control" value="{{ $fiche->nom }}" name="nom" placeholder="facultatif" />
                    </div>
                    <div class="mb-3">
                        <label for="prenom" class="form-label">PRENOM :</label>
                        <input type="text" class="form-control" value="{{ $fiche->prenom }}" name="prenom" placeholder="facultatif" />
                    </div>
                    <div class="mb-3">
                        <label for="chambre_numero" class="form-label">NUMERO DE CHAMBRE :</label>
                        <input type="text" class="form-control" value="{{ $fiche->chambre_numero }}" name="chambre_numero" placeholder="facultatif" />
                    </div>
                    <div class="mb-3">
                        <label for="age" class="form-label">AGE :</label>
                        <input type="text" class="form-control" value="{{ $fiche->age }}" name="age" placeholder="facultatif" />
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlSelect1" class="form-label">SERVICE</label>
                        <select class="form-control" name="service" id="exampleFormControlSelect1">
                            <option value="{{ $fiche->service }}"  {{ $fiche->id == ' ' ? 'selected' : '' }}><b>{{ $fiche->service }}</b></option>
                            <option>URGENCE</option>
                            <option>AMBULLATOIRE</option>
                            <option>HOSPITALISATION</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">INFIRMIER EN CHARGE :</label>
                        <input type="text" class="form-control" value="{{ $fiche->infirmier_charge }}" name="infirmier_charge" />
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlSelect1" class="form-label">ACCUEIL</label>
                        <select class="form-control" name="accueil" id="exampleFormControlSelect1">
                            <option value="{{ $fiche->accueil }}"  {{ $fiche->id == ' ' ? 'selected' : '' }}><b>{{ $fiche->accueil }}</b></option>
                            <option>EXCELLENT</option>
                            <option>TRES BIEN</option>
                            <option>BIEN</option>
                            <option>PASSABLE</option>
                            <option>MEDIOCRE</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlSelect1" class="form-label">RESTAURANT </label>
                        <select class="form-control" name="restauration" id="exampleFormControlSelect1">
                            <option value="{{ $fiche->restauration }}"  {{ $fiche->id == ' ' ? 'selected' : '' }}><b>{{ $fiche->restauration }}</b></option>
                            <option>EXCELLENT</option>
                            <option>TRES BIEN</option>
                            <option>BIEN</option>
                            <option>PASSABLE</option>
                            <option>MEDIOCRE</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlSelect1" class="form-label">CHAMBRE </label>
                        <select class="form-control" name="chambre" id="exampleFormControlSelect1">
                            <option value="{{ $fiche->chambre }}"  {{ $fiche->id == ' ' ? 'selected' : '' }}><b>{{ $fiche->chambre }}</b></option>
                            <option>EXCELLENT</option>
                            <option>TRES BIEN</option>
                            <option>BIEN</option>
                            <option>PASSABLE</option>
                            <option>MEDIOCRE</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlSelect1" class="form-label">SOINS</label>
                        <select class="form-control" name="soins" id="exampleFormControlSelect1">
                            <option>EXCELLENT</option>
                            <option>TRES BIEN</option>
                            <option>BIEN</option>
                            <option>PASSABLE</option>
                            <option>MEDIOCRE</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">UNE NOTE :</label>
                        <input type="text" class="form-control" name="notes" value="{{ $fiche->notes }}" placeholder="Entrer une note sur 10 " />
                    </div>
                    <div class="mb-3">
                        <label for="bla" class="form-label">Recommanderiez-vous le Centre Médico-Chirurgical d’Urologie à vos proches ? </label>
                        <br>
                        <input type="radio" id="" class="form-check-input" name="quizz" value="Oui" @if($fiche->quizz == 'Oui') checked @endif required> Oui
                        <br>
                        <input type="radio" id="" class="form-check-input" name="quizz" value="Non" @if($fiche->quizz == 'Non') checked @endif required> Non
                        <br>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">REMARQUE ET SUGGESTION:</label>
                        <div >
                            <TEXTAREA name="remarque_suggestion" rows=4 cols=40>{{ $fiche->remarque_suggestion }}</TEXTAREA>
                        </div>
                    </div>
                    <div class="row">
                        <button type="submit" class="btn btn-primary me-2">ENREGISTRER</button>
                        <button class="btn btn-success float-start" >
                            <a href="{{ route('fiches.index') }}"><i class="fas fa-long-arrow-alt-left"></i> Retour</a>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </body>
@endsection
