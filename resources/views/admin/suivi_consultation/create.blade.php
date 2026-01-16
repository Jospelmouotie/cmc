@extends('layouts.admin')
@section('title', 'CMCU | Renseignement du dossier patient')
@section('content')
  
    {{--<div class="se-pre-con"></div>--}}
    
    <div class="wrapper">
    @include('partials.side_bar')
    <!-- Page Content Holder -->
        @include('partials.header')
        @can('chirurgien', \App\Models\Patient::class)
        <div class="container_fluid">
              <h1 class="text-center">CONSULTATION DE SUIVI - {{ $patient->name }} {{ $patient->prenom }} </h1>
              <hr>
          </div> 
        <div class="container">
          <form class="mb-3" action="{{ route('consultationsdesuivi.store') }}" method="post">
           <div class="row">
            <div class="mb-3  col-md-6">
            @csrf
            <label for="interrogatoire" class="col-form-label text-md-end">Interrogatoire <span class="text-danger"></span></label>
              <textarea rows="10" name="interrogatoire" class="form-control" value="{{ old('interrogatoire') }}" type="textarea" placeholder="interrogatoire" required>
              </textarea>
              </div>
              <div class="mb-3  col-md-6">
            <label for="commentaire" class="col-form-label text-md-end">Commentaire <span class="text-danger"></span></label>
              <textarea rows="10" name="commentaire" class="form-control" value="{{ old('commentaire') }}" type="textarea" placeholder="votre commentaire" required>
              </textarea>
              </div>
           </div> 
           <div class="row">
             <div class="mb-3 col-md-6 mb-0">
           <label for="date_creation" class="col-form-label text-md-end">Date <span class="text-danger"></span></label>
            <input name="date_creation" class="form-control" value="{{ old('date_creation') }}" type="date"  required>
           </div>
             <div class="col-md-6 d-flex align-items-end">
               <input name="patient_id" value="{{ $patient->id }}" type="hidden">
              <button type="submit" class="btn btn-primary btn-lg col-sm-4" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span>&#xA0;Ajouter</button>
              <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-warning btn-lg col-md-5 offset-md-1" title="Retour à la liste des patients">Annuler</a>
             </div>
           
             </div>
             
             
        </form>
        </div>
        
        @endcan
@stop
