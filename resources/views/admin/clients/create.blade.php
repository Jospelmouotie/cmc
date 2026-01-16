@extends('layouts.admin')

@section('title', 'CMCU | Ajouter un client')

@section('content')

    <body>
    <div class="se-pr-con"></div>
    <div class="wrapper">
    @include('partials.side_bar')

    <!-- Page Content Holder -->
    @include('partials.header')
    <!--// top-bar -->

        <div class="container">
            <h1 class="text-center">AJOUTER UN CLIENT</h1>
            <hr>
            <!--  -->

            <div class="card" style="width: 40rem;">
                <div class="card-body">
                    <h5 class="card-title">Ajouter un client</h5>
                    <small class="text-info" title="Les champs marqués par une étoile rouge sont obligatoire"><i class="fas fa-info-circle"></i></small>
                    <hr>
                    <form class="mb-3 col-md-10" action="{{ route('clients.store') }}" method="POST">
                        @csrf
                        <div class="col-md-12">

                        <div class="mb-3">
                        <b>Médecin  :</b> <span class="text-danger">*</span>
                            
                                <select class="form-control" name="medecin_r" id="medecin_r" required>
                                    <option value="medecin_r"> Nom du médecin</option>
                                    @foreach ($users as $user)
                                        <option
                                            value="{{ $user->name }} {{ $user->prenom }}" {{old("medecin_r") ?: '' ? "selected": ""}}>{{ $user->name }} {{ $user->prenom }}
                                        </option>
                                    @endforeach
                                </select>
                           </div>
                            <div class="mb-3">
                                <!-- <label for="nom" class="col-form-label text-md-right">Nom <span class="text-danger">*</span></label> -->
                                 <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                                <input name="nom" class="form-control" value="{{ old('nom') }}" type="text" placeholder="Nom" required>
                            </div>
                            <div class="mb-3">
                                <!-- <label for="prenom" class="col-form-label text-md-right">Prenom <span class="text-danger">*</span></label> -->
                                 <label for="prenom" class="form-label">Prenom <span class="text-danger">*</span></label>
                                <input name="prenom" class="form-control" value="{{ old('prenom') }}" type="text" placeholder="prenom" >
                            </div>
                             <div class="mb-3">
                                <!-- <label for="motif" class="col-form-label text-md-right">Motif <span class="text-danger">*</span></label> -->
                                 <label for="motif" class="form-label">Motif <span class="text-danger">*</span></label>
                                <input name="motif" class="form-control" value="{{ old('motif') }}" type="text" placeholder="motif" >
                            </div>
                            <div class="mb-3">
                                <!-- <label for="montant" class="col-form-label text-md-right">Montant <span class="text-danger">*</span></label> -->
                                 <label for="montant" class="form-label">Montant <span class="text-danger">*</span></label>
                                <input name="montant" class="form-control" value="{{ old('montant') }}" type="text" placeholder="montant" >
                            </div>
                            <div class="mb-3">
                                <!-- <label for="avance" class="col-form-label text-md-right">avance</label> -->
                                 <label for="avance" class="form-label">avance</label>
                                <input name="avance" class="form-control" value="{{ old('avance') }}" type="text" placeholder="avance" >
                            </div>
                            <div class="mb-3">
                            <label for="demarcheur" class="form-label"> Démarcheur : <span class="text-danger"></span></label>
                            <select class="form-control" name="demarcheur" id="demarcheur" >
                                <option></option>
                                <option>DMH</option>
                            </select>
                        </div>
                            <div class="mb-3">
                            
                            <div class="mb-3">
                                <!-- <label for="assurance" class="col-form-label text-md-end">Assurance</label> -->
                                <label for="assurance" class="form-label">Assurance</label>
                                <input name="assurance" class="form-control" value="{{ old('assurance') }}" type="text" placeholder=" nom de l'assurance si le patient est assuré" >
                            </div>

                            <div class="mb-3">
                                <!-- <label for="numero_assurance" class="col-form-label text-md-right">Numéro d'assurance</label> -->
                                <label for="numero_assurance" class="form-label">Numéro d'assurance</label>
                                <input name="numero_assurance" class="form-control" value="{{ old('numero_assurance') }}" type="text" placeholder="Numéro d'assurance si le patient est assuré" >
                            </div>
                            <div class="mb-3">
                            <label for="prise_en_charge" class="form-label"> Taux de Prise en Charge : <span class="text-danger"></span></label>
                            <select class="form-control" name="prise_en_charge" id="prise_en_charge" required>
                            @foreach(range(0, 100) as  $taux)
                                @if ($taux == 0)
                                    <option>aucune</option>
                                @else
                                    <option>{{$taux}}</option>
                                @endif
                            @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                                <!-- <label for="date_insertion" class="col-form-label text-md-end">Date Création</label> -->
                                \<label for="date_insertion" class="form-label">Date Création</label>
                                <input type="date" name="date_insertion" class="form-control" value="{{ old('date_insertion') }}"  placeholder=" date de création du dossier au cmcu" required>
                            </div>
                       
                        </div>

                            </br>

                            <button type="submit" class="btn btn-primary btn-lg col-md-5" title="En cliquant sur ce bouton vous enregistrer un nouveau patient">Ajouter</button>
                            <a href="{{ route('clients.index') }}" class="btn btn-warning btn-lg col-md-5 offset-md-1" title="Retour à la liste des patients">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    </body>

@stop



