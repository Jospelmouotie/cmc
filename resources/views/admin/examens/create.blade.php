@extends('layouts.admin')
@section('title', 'CMCU | Ajouter un examen')
@section('content')
    <body>
    <div class="se-pre-con"></div>
    <div class="wrapper">
    @include('partials.side_bar')
    <!-- Page Content Holder -->
    @include('partials.header')
    <!--// top-bar -->
        <div class="container">
            <h1 class="text-center">IMPORTER UN EXAMEN </h1>
            <hr>
            <!--  -->
            <div class="card" style="width: 40rem;">
                <div class="card-body">
                    <h5 class="card-title">Ajouter un examen</h5>
                    <small class="text-info" title="Les champs marqués par une étoile rouge sont obligatoire"><i class="fas fa-info-circle"></i></small>
                    <hr>
                    <form class="mb-3 col-md-10" method="post" action="{{ route('examens.store') }}" enctype="multipart/form-data">
                        <div class="mb-3">
                            @csrf
                            <label for="type">Type d'examens <span class="text-danger"></span></label>
                            <input type="text" class="form-control" name="type" value="{{ old('type') }}" required/>
                        </div>
                        <label for="image">Image  <span class="text-danger"></span></label>
                        <input type="file" class="form-control" class="custum-file-input" name="image" value="{{ old('image') }}"  required/>
                        <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                </br>
                <button type="submit" class="btn btn-primary btn-lg col-sm-4" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span>&#xA0;Ajouter</button>
                <a href="{{ route('examens.index') }}" class="btn btn-warning btn-lg col-md-5 offset-md-1" title="Retour à la liste des patients">Annuler</a>
            </form>
        </div>
    </div>
    </div>
    </div>
    </body>
@stop
