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

          @if ($errors->any())
              <div class="alert alert-danger">
                  <ul class="mb-0">
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif

          <form class="mb-3" action="{{ route('consultationsdesuivi.store') }}" method="post">
              @csrf

              <div class="row">
                  <div class="mb-3 col-md-6">
                      <label for="interrogatoire" class="col-form-label text-md-end">
                          Interrogatoire <span class="text-danger">*</span>
                      </label>
                      <textarea 
                          rows="10" 
                          name="interrogatoire" 
                          class="form-control @error('interrogatoire') is-invalid @enderror" 
                          required>{{ old('interrogatoire') }}</textarea>

                      @error('interrogatoire')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                  </div>

                  <div class="mb-3 col-md-6">
                      <label for="commentaire" class="col-form-label text-md-end">
                          Commentaire <span class="text-danger">*</span>
                      </label>
                      <textarea 
                          rows="10" 
                          name="commentaire" 
                          class="form-control @error('commentaire') is-invalid @enderror" 
                          required>{{ old('commentaire') }}</textarea>

                      @error('commentaire')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                  </div>
              </div>

              <div class="row">
                  <div class="mb-3 col-md-6">
                      <label for="date_creation" class="col-form-label text-md-end">
                          Date <span class="text-danger">*</span>
                      </label>
                      <input 
                          name="date_creation" 
                          type="date" 
                          class="form-control @error('date_creation') is-invalid @enderror" 
                          value="{{ old('date_creation') }}" 
                          required>

                      @error('date_creation')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                  </div>

                  <div class="col-md-6 d-flex align-items-end">
                      <input type="hidden" name="patient_id" value="{{ $patient->id }}">

                      <button type="submit" class="btn btn-primary btn-lg col-sm-4">
                          Ajouter
                      </button>

                      <a href="{{ route('patients.show', $patient->id) }}" 
                        class="btn btn-warning btn-lg col-md-5 offset-md-1">
                          Annuler
                      </a>
                  </div>
              </div>
          </form>


        </div>

        
        @endcan

</div>
@stop


