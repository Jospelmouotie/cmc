@extends('layouts.admin')
@section('title', 'CMCU | Mes Patients Suivis')
@section('content')

<style>
/* Styles pour la pagination */
.pagination-wrapper {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    margin: 0.5rem 0;
    padding: 0.5rem 0;
}

.pagination-wrapper .pagination {
    margin-bottom: 0;
    display: flex;
    list-style: none;
    padding-left: 0;
}

.pagination-wrapper .pagination li {
    margin: 0 2px;
}

.pagination-wrapper .pagination .page-link {
    position: relative;
    display: block;
    padding: 0.5rem 0.75rem;
    margin-left: -1px;
    line-height: 1.25;
    color: #007bff;
    background-color: #fff;
    border: 1px solid #dee2e6;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 0.875rem;
}

.pagination-wrapper .pagination .page-link:hover {
    z-index: 2;
    color: #0056b3;
    background-color: #e9ecef;
    border-color: #dee2e6;
}

.pagination-wrapper .pagination .page-item.active .page-link {
    z-index: 3;
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
}

.pagination-wrapper .pagination .page-item.disabled .page-link {
    color: #6c757d;
    pointer-events: none;
    cursor: not-allowed;
    background-color: #fff;
    border-color: #dee2e6;
}

.pagination-wrapper .pagination .page-link svg {
    width: 14px !important;
    height: 14px !important;
    vertical-align: middle;
}

.pagination-results {
    text-align: left;
    color: #6c757d;
    font-size: 0.875rem;
    margin: 0.5rem 0;
}

.pagination-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 0.5rem;
}

/* Style pour la barre de recherche */
.search-bar {
    background-color: #f8f9fa;
    padding: 1rem;
    border-bottom: 1px solid #dee2e6;
}

.search-bar .form-control {
    border-radius: 20px;
    padding: 0.5rem 1rem;
}

.search-bar .btn {
    border-radius: 20px;
    padding: 0.5rem 1.5rem;
}

.clear-search {
    border-radius: 20px;
}
</style>

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
                <p class="text-muted text-center">Liste des patients que vous avez consultés</p>
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
                    
                    <!-- Barre de recherche -->
                    <div class="search-bar">
                        <form method="GET" action="{{ route('patients.suivis') }}" id="searchForm">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <span class="input-group-text bg-white">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        <input type="text" 
                                               name="search" 
                                               class="form-control" 
                                               placeholder="Rechercher par nom, prénom ou n° dossier..." 
                                               value="{{ request('search') }}"
                                               id="searchInput">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary me-2">
                                        <i class="fas fa-search"></i> Rechercher
                                    </button>
                                    @if(request('search'))
                                        <a href="{{ route('patients.suivis') }}" class="btn btn-secondary clear-search">
                                            <i class="fas fa-times"></i> Effacer
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
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
                                            @php
                                                $telephone = $patient->user->telephone ?? null;
                                                if (!$telephone && $patient->dossiers->first()) {
                                                    $telephone = $patient->dossiers->first()->portable_1 ?: $patient->dossiers->first()->portable_2;
                                                }
                                            @endphp
                                            @if($telephone)
                                                <i class="fas fa-phone text-success"></i> {{ $telephone }}
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
                                                <span class="badge bg-success fs-7">Chirurgien</span>
                                            @endif
                                            @if($patient->consultation_anesthesistes->count() > 0)
                                                <span class="badge bg-warning fs-6">Anesthésiste</span>
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
                        
                        <!-- Pagination améliorée -->
                        <div class="pagination-container">
                            <div class="pagination-results">
                                Affichage de {{ $patients->firstItem() }} à {{ $patients->lastItem() }} 
                                sur {{ $patients->total() }} résultat(s)
                            </div>
                            <div class="pagination-wrapper">
                                {{ $patients->appends(request()->query())->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                        
                        @else
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle fa-3x mb-3"></i>
                            <h5>
                                @if(request('search'))
                                    Aucun résultat trouvé pour "{{ request('search') }}"
                                @else
                                    Aucun patient suivi
                                @endif
                            </h5>
                            <p class="mb-0">
                                @if(request('search'))
                                    Essayez avec d'autres critères de recherche.
                                    <br>
                                    <a href="{{ route('patients.suivis') }}" class="btn btn-sm btn-primary mt-2">
                                        <i class="fas fa-arrow-left"></i> Voir tous les patients
                                    </a>
                                @else
                                    Vous n'avez pas encore de patients en suivi.
                                @endif
                            </p>
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

<script>
// Recherche en temps réel (optionnel - décommentez si vous voulez)
/*
document.getElementById('searchInput').addEventListener('input', function() {
    clearTimeout(window.searchTimeout);
    window.searchTimeout = setTimeout(function() {
        document.getElementById('searchForm').submit();
    }, 500);
});
*/
</script>

</body>
@endsection