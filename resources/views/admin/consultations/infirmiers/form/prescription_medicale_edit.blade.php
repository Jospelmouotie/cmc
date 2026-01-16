@extends('layouts.admin')

@section('title', 'CMCU | Modifier prescription médicale')

@section('content')

<body>
    <div class="wrapper">
        @include('partials.side_bar')
        @include('partials.header')
        
        @can('show', \App\Models\User::class)
            <div class="container">
                <div class="row">
                    <div class="col-md-12 toppad offset-md-0">
                        <a class="btn btn-dark" href="{{ route('fiche.prescription_medicale.index', $patient) }}" title="Prescriptions médicales">
                            <i class="fas fa-arrow-left"></i>  Retour a  la liste
                        </a>
                    </div>
                    
                    <div class="container">
                        <br>
                        <h3 class="text-center">MODIFIER PRESCRIPTION MÉDICALE</h3>
                        <h5 class="text-center text-muted">{{ $patient->name }} {{ $patient->prenom }}</h5>
                        <br>
                        
                        <div class="card shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="fas fa-pills"></i> Informations de la prescription</h5>
                            </div>
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <strong><i class="fas fa-exclamation-triangle"></i> Erreurs de validation :</strong>
                                        <ul class="mb-0 mt-2">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form action="{{ route('prescription_medicale.update', $prescription_medicale->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    
                                    <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                                    <input type="hidden" name="fiche_prescription_medicale_id" value="{{ $prescription_medicale->fiche_prescription_medicale_id }}">

                                    {{-- Inclure le composant partagé --}}
                                    @include('admin.consultations.infirmiers.form._prescription_medicale_fields')

                                    <hr class="my-4">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save"></i> Enregistrer les modifications
                                            </button>
                                            <a href="{{ route('fiche.prescription_medicale.index', $patient) }}" class="btn btn-secondary">
                                                <i class="fas fa-times"></i> Annuler
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    </div>
</body>

@endsection