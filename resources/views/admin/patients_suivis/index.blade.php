@extends('layouts.admin')
@section('title', 'CMCU | Mes Patients Suivis')
@section('content')
<body>
<div class="wrapper">
    @include('partials.side_bar')
    @include('partials.header')
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mb-3">
                <h2 class="text-center">
                    <i class="fas fa-user-check"></i> Mes Patients Suivis
                </h2>
                <p class="text-muted">Liste des patients que vous avez consultés</p>
            </div>
        </div>
<hr>
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-list"></i> 
                            Total: {{ $patients->total() }} patient(s)
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($patients->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>N° Dossier</th>
                                        <th>Nom & Prénom</th>
                                        <th>Téléphone</th>
                                        <th>Dernière Consultation</th>
                                        <th>Type</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($patients as $patient)
                                    <tr>
                                        <td>
                                            <span class="badge bg-primary">{{ $patient->numero_dossier }}</span>
                                        </td>
                                        <td>
                                            <strong>{{ $patient->name }} {{ $patient->prenom }}</strong>
                                        </td>
                                        <td>
                                            @if($patient->telephone)
                                                <i class="fas fa-phone text-success"></i> {{ $patient->telephone }}
                                            @else
                                                <span class="text-muted">Non renseigné</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $lastConsultation = $patient->consultations->first();
                                                $lastConsultationAnes = $patient->consultation_anesthesistes->first();
                                                
                                                $mostRecent = null;
                                                if ($lastConsultation && $lastConsultationAnes) {
                                                    $mostRecent = $lastConsultation->created_at > $lastConsultationAnes->created_at 
                                                        ? $lastConsultation 
                                                        : $lastConsultationAnes;
                                                } else {
                                                    $mostRecent = $lastConsultation ?: $lastConsultationAnes;
                                                }
                                            @endphp
                                            
                                            @if($mostRecent)
                                                <span class="text-muted">
                                                    <i class="far fa-clock"></i>
                                                    {{ $mostRecent->created_at->diffForHumans() }}
                                                </span>
                                                <br>
                                                <small class="text-secondary">
                                                    {{ $mostRecent->created_at->format('d/m/Y') }}
                                                </small>
                                            @else
                                                <span class="text-warning">Aucune consultation</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($patient->consultations->count() > 0)
                                                <span class="badge bg-success">Chirurgien</span>
                                            @endif
                                            @if($patient->consultation_anesthesistes->count() > 0)
                                                <span class="badge bg-warning">Anesthésiste</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('patients.show', $patient->id) }}" 
                                                   class="btn btn-sm btn-primary" 
                                                   title="Voir le dossier">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                
                                                @can('chirurgien', \App\Models\Patient::class)
                                                    @if($patient->consultations->count() > 0)
                                                    <a href="{{ route('consultations.edit', $patient->id) }}" 
                                                       class="btn btn-sm btn-warning" 
                                                       title="Modifier consultation">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    @endif
                                                @endcan
                                                
                                                @can('anesthesiste', \App\Models\Patient::class)
                                                    @if($patient->consultation_anesthesistes->count() > 0)
                                                    <a href="{{ route('consultations.edit', $patient->id) }}" 
                                                       class="btn btn-sm btn-info" 
                                                       title="Modifier consultation anesthésiste">
                                                        <i class="fas fa-stethoscope"></i>
                                                    </a>
                                                    @endif
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $patients->links() }}
                        </div>
                        @else
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle fa-3x mb-3"></i>
                            <h5>Aucun patient suivi</h5>
                            <p class="mb-0">Vous n'avez pas encore de patients en suivi.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Patients
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $patients->total() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Consultations Chirurgien
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $patients->filter(fn($p) => $p->consultations->count() > 0)->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-md fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Consultations Anesthésiste
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $patients->filter(fn($p) => $p->consultation_anesthesistes->count() > 0)->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-stethoscope fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
@stop