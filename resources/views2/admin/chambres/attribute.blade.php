@extends('layouts.admin') @section('title', 'CMCU | Ajouter une fiche une chambre') @section('content')
    <body>
    {{--<div class="se-pre-con"></div>--}}
    <div class="wrapper">
    @include('partials.side_bar')

    <!-- //Page Content Holder  -->
        @include('partials.header')
        <div class="container">
            <h1 class="text-center">ATTRIBUTION DE CHAMBRE AU PATIENT</h1>
            <hr>
            <!--  -->
            <!--  -->
            <div class="col-md-6">
                <form method="post" action="{{ route('chambres_status.update', $chambre->id) }}">
                    @method('PATCH')
                    @csrf
                    <div class="mb-3">
                        <label for="name">NUMERO :</label>
                        <input type="text" class="form-control"  name="numero"  value="{{ $chambre->numero }}" disabled/>
                    </div>
                    <div class="mb-3">
                        <label>CATEGORIE :</label>
                        <select class="form-control"  name="categorie" id="exampleFormControlSelect1" disabled>
                            <option value="{{ $chambre->categorie }}"  {{ $chambre->id == ' ' ? 'selected' : '' }}>{{ $chambre->categorie }}</option>
                        </select>
                    </div>
                    <input type="hidden" name="statut" value="occupé">
                    <select class="form-control"  name="patient" id="patient" required>
                        <option>Nom du patient :</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->name }}">{{ $patient->name }} {{ $patient->prenom }}</option>
                        @endforeach
                    </select>
                    <label>Nombre de jours :</label>
                    <input type="number" class="form-control  col-md-4" name="jour" value="{{ request('jour') }}" placeholder="nombre de jours">
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


