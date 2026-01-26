@extends('layouts.admin')

@section('title', 'CMCU | Liste des devis')

@section('content')

<body>
    <div class="wrapper">
        @include('partials.side_bar')
        @include('partials.header')

        @can('view', \App\Models\Devi::class)
        <div class="container-fluid px-4 py-4">
            <h1 class="text-center mb-4">LISTE DES DEVIS</h1>
            
            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card text-white bg-secondary">
                        <div class="card-body">
                            <h6>Brouillons</h6>
                            <h3>{{ $devis->where('statut', 'brouillon')->count() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-warning">
                        <div class="card-body">
                            <h6>En attente</h6>
                            <h3>{{ $devis->where('statut', 'en_attente')->count() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <h6>Validés</h6>
                            <h3>{{ $devis->where('statut', 'valide')->count() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-danger">
                        <div class="card-body">
                            <h6>Refusés</h6>
                            <h3>{{ $devis->where('statut', 'refuse')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Devis Table -->
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="devisTable" class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Code</th>
                                    <th>Patient</th>
                                    <th>Médecin</th>
                                    <th>Montant</th>
                                    <th>Réduction</th>
                                    <th>Statut</th>
                                    <th>Date</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($devis as $devi)
                                <tr>
                                    <td><strong>{{ $devi->code }}</strong></td>
                                    <td>
                                        @if($devi->patient)
                                        {{ $devi->patient->name }} {{ $devi->patient->prenom }}
                                        @else
                                        <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($devi->medecin)
                                        Dr. {{ $devi->medecin->name }}
                                       
                                        
                                        <!-- helps gestionnaires identify devis that can't be sent for validation -->
                                        @elseif(!$devi->medecin_id && $devi->statut == 'brouillon')
                                            <span class="badge bg-warning">
                                                <i class="fas fa-exclamation-triangle"></i> Pas de médecin assigné
                                            </span>
                                        @else
                                            <span class="text-muted">Non assigné</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ number_format($devi->montant_apres_reduction, 0, ',', ' ') }} FCFA</strong>
                                        </div>
                                        @if($devi->pourcentage_reduction > 0)
                                        <small class="text-muted">
                                            <del>{{ number_format($devi->montant_avant_reduction, 0, ',', ' ') }} FCFA</del>
                                        </small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($devi->pourcentage_reduction > 0)
                                        <span class="badge bg-info">-{{ $devi->pourcentage_reduction }}%</span>
                                        @else
                                        <span class="text-muted">Aucune</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($devi->statut == 'brouillon')
                                        <span class="badge bg-secondary">Brouillon</span>
                                        @elseif($devi->statut == 'en_attente')
                                        <span class="badge bg-warning">En attente</span>
                                        @elseif($devi->statut == 'valide')
                                        <span class="badge bg-success">Validé</span>
                                        @elseif($devi->statut == 'refuse')
                                            <span class="badge bg-danger">Refusé</span>
                                            @if($devi->commentaire_medecin)
                                                <i class="fas fa-comment-dots text-danger ms-1" 
                                                title="Raison: {{ $devi->commentaire_medecin }}" 
                                                data-bs-toggle="tooltip"></i>
                                            @endif
                                        @endif
                                    </td>
                                    <td><small>{{ $devi->created_at->format('d/m/Y') }}</small></td>
                                    
                                    <td class="text-center">
                                        <!-- View/Edit button (Gestionnaire) -->
                                        @can('update', \App\Models\Devi::class)
                                            @if($devi->statut == 'brouillon' || $devi->statut == 'refuse')
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-primary"
                                                        data-devi='@json($devi)' 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#devisModal"
                                                        data-mode="edit"
                                                        title="Modifier">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            @endif
                                            
                                            <!-- Send for validation -->
                                            @if($devi->statut == 'brouillon')
                                                <form action="{{ route('devis.envoyer_validation', $devi->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-success" title="Envoyer pour validation">
                                                        <i class="fas fa-paper-plane"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            <!-- Cancel send (for en_attente status) -->
                                            @if($devi->statut == 'en_attente' && $devi->user_id == Auth::id())
                                                <form action="{{ route('devis.annuler_envoi', $devi->id) }}" 
                                                    method="POST" 
                                                    class="d-inline"
                                                    onsubmit="return confirm('Voulez-vous annuler l\'envoi de ce devis? Il reviendra en brouillon.');">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-warning" title="Annuler l'envoi">
                                                        <i class="fas fa-undo-alt"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            <!-- Cancel refusal (for refuse status) - Return to brouillon for editing -->
                                            @if($devi->statut == 'refuse' && $devi->user_id == Auth::id())
                                                <form action="{{ route('devis.annuler_refus', $devi->id) }}" 
                                                    method="POST" 
                                                    class="d-inline"
                                                    onsubmit="return confirm('Voulez-vous réinitialiser ce devis refusé? Il reviendra en brouillon pour modification.');">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-info" title="Réinitialiser le devis refusé">
                                                        <i class="fas fa-sync-alt"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        @endcan

                                        <!-- Undo validation (Doctor) -->
                                        @if($devi->statut == 'valide' && $devi->medecin_id == Auth::id())
                                            <form action="{{ route('devis.annuler_validation', $devi->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-warning" title="Annuler validation">
                                                    <i class="fas fa-undo"></i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <!-- Doctor actions -->
                                        @can('validate', \App\Models\Devi::class)
                                            @if($devi->statut == 'en_attente' && $devi->medecin_id == Auth::id())
                                                <button type="button"
                                                        class="btn btn-sm btn-outline-info"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#reductionModal"
                                                        data-devi-id="{{ $devi->id }}"
                                                        data-montant="{{ $devi->montant_avant_reduction }}"
                                                        title="Appliquer réduction">
                                                    <i class="fas fa-percent"></i>
                                                </button>
                                                
                                                <button type="button"
                                                        class="btn btn-sm btn-outline-success"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#validerModal"
                                                        data-devi-id="{{ $devi->id }}"
                                                        title="Valider">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                
                                                <button type="button"
                                                        class="btn btn-sm btn-outline-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#refuserModal"
                                                        data-devi-id="{{ $devi->id }}"
                                                        title="Refuser">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            @endif
                                        @endcan

                                        <!-- View button (Always visible) -->
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-info view-devis-btn"
                                                data-devi='@json($devi)'
                                                title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <!-- Print button -->
                                        @can('print', \App\Models\Devi::class)
                                            @if($devi->statut == 'valide')
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-secondary"
                                                        data-devi='@json($devi)' 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#devisModal"
                                                        data-mode="print"
                                                        title="Imprimer">
                                                    <i class="fas fa-print"></i>
                                                </button>
                                            @endif
                                        @endcan

                                        <!-- Delete button -->
                                        @can('delete', \App\Models\Devi::class)
                                            @if($devi->statut == 'brouillon' || $devi->statut == 'refuse')
                                                <form action="{{ route('devis.destroy', $devi->id) }}" 
                                                    method="POST" 
                                                    class="d-inline" 
                                                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce devis ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{ $devis->links() }}
                </div>
            </div>
        </div>

        @can('create', \App\Models\Devi::class)
        <div class="text-center table_link_right">
            <button type="button" 
                    data-bs-toggle="modal" 
                    data-bs-target="#devisModal" 
                    data-mode="create"
                    class="btn btn-primary me-1" 
                    title="Créer un nouveau devis">
                <i class="fas fa-plus me-2"></i>Nouveau Devis
            </button>
        </div>
        @endcan

        
        <!-- Main Devis Modal (Create/Edit/Print) -->
        @include('admin.devis.modal')
        
        <!-- Reduction Modal (Doctor) -->
        @include('admin.devis.modals.reduction')
        
        <!-- Validation Modal (Doctor) -->
        @include('admin.devis.modals.validation')
        
        <!-- Refusal Modal (Doctor) -->
        @include('admin.devis.modals.refusal')

        <!-- View Devis Modal -->
        <div class="modal fade" id="viewDevisModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Détails du Devis</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" id="viewDevisContent">
                    <!-- Content loaded via JavaScript -->
                    </div>
                </div>
            </div>
        </div>
        @endcan
    </div>

    
</body>



@push('scripts')
<script src="{{ asset('admin/js/devis/convert_chiffre_lettre.js') }}"></script>
<script src="{{ asset('admin/js/devis/devis.js') }}"></script>

<script>
console.log('Loading view devis functionality...');

// Define viewDevis function in GLOBAL scope
window.viewDevis = function(devi) {
    console.log('viewDevis called with:', devi);
    
    if (!devi) {
        console.error('No devis data provided');
        return;
    }
    
    try {
        let statusClass = 'secondary';
        let statusText = devi.statut || 'N/A';
        
        if (devi.statut === 'valide') {
            statusClass = 'success';
            statusText = 'Validé';
        } else if (devi.statut === 'en_attente') {
            statusClass = 'warning';
            statusText = 'En attente';
        } else if (devi.statut === 'refuse') {
            statusClass = 'danger';
            statusText = 'Refusé';
        } else if (devi.statut === 'brouillon') {
            statusClass = 'secondary';
            statusText = 'Brouillon';
        }
        
        const patientName = devi.patient ? (devi.patient.name + ' ' + devi.patient.prenom) : 'N/A';
        const medecinName = devi.medecin ? ('Dr. ' + devi.medecin.name + ' ' + (devi.medecin.prenom || '')) : 'Non assigné';
        
        // IMPORTANT: Laravel converts camelCase to snake_case in JSON
        const ligneDevis = devi.ligne_devis || [];
        
        console.log('Ligne devis count:', ligneDevis.length);
        
        // Build line items table
        let lignesHtml = '';
        if (ligneDevis.length > 0) {
            lignesHtml = `
                <h6 class="mt-3">Éléments du devis:</h6>
                <table class="table table-sm table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Élément</th>
                            <th class="text-end">Qté</th>
                            <th class="text-end">Prix U.</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
            `;
            
            ligneDevis.forEach(function(ligne, index) {
                const quantite = parseFloat(ligne.quantite) || 0;
                const prixU = parseFloat(ligne.prix_u) || 0;
                const total = quantite * prixU;
                
                lignesHtml += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${ligne.element || 'N/A'}</td>
                        <td class="text-end">${quantite}</td>
                        <td class="text-end">${parseInt(prixU).toLocaleString('fr-FR')} FCFA</td>
                        <td class="text-end">${parseInt(total).toLocaleString('fr-FR')} FCFA</td>
                    </tr>
                `;
            });
            
            lignesHtml += `
                    </tbody>
                </table>
            `;
        } else {
            lignesHtml = `
                <div class="alert alert-warning mt-3">
                    <i class="fas fa-info-circle"></i> Aucun élément dans ce devis
                </div>
            `;
        }
        
        // Build hospitalization section
        let hospitalizationHtml = '';
        const hasHospitalization = (devi.nbr_chambre > 0) || (devi.nbr_visite > 0) || (devi.nbr_ami_jour > 0);
        
        if (hasHospitalization) {
            hospitalizationHtml = `
                <h6 class="mt-3">Hospitalisation:</h6>
                <table class="table table-sm table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Type</th>
                            <th class="text-end">Quantité</th>
                            <th class="text-end">Prix U.</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
            `;
            
            if (devi.nbr_chambre > 0) {
                const totalChambre = (parseFloat(devi.nbr_chambre) || 0) * (parseFloat(devi.pu_chambre) || 0);
                hospitalizationHtml += `
                    <tr>
                        <td>Chambre</td>
                        <td class="text-end">${devi.nbr_chambre}</td>
                        <td class="text-end">${parseInt(devi.pu_chambre).toLocaleString('fr-FR')} FCFA</td>
                        <td class="text-end">${parseInt(totalChambre).toLocaleString('fr-FR')} FCFA</td>
                    </tr>
                `;
            }
            
            if (devi.nbr_visite > 0) {
                const totalVisite = (parseFloat(devi.nbr_visite) || 0) * (parseFloat(devi.pu_visite) || 0);
                hospitalizationHtml += `
                    <tr>
                        <td>Visite</td>
                        <td class="text-end">${devi.nbr_visite}</td>
                        <td class="text-end">${parseInt(devi.pu_visite).toLocaleString('fr-FR')} FCFA</td>
                        <td class="text-end">${parseInt(totalVisite).toLocaleString('fr-FR')} FCFA</td>
                    </tr>
                `;
            }
            
            if (devi.nbr_ami_jour > 0) {
                const totalAmi = (parseFloat(devi.nbr_ami_jour) || 0) * (parseFloat(devi.pu_ami_jour) || 0);
                hospitalizationHtml += `
                    <tr>
                        <td>AMI-JOUR</td>
                        <td class="text-end">${devi.nbr_ami_jour}</td>
                        <td class="text-end">${parseInt(devi.pu_ami_jour).toLocaleString('fr-FR')} FCFA</td>
                        <td class="text-end">${parseInt(totalAmi).toLocaleString('fr-FR')} FCFA</td>
                    </tr>
                `;
            }
            
            hospitalizationHtml += `
                    </tbody>
                </table>
            `;
        }
        
        // Build comments section
        let commentsHtml = '';
        if (devi.commentaire_medecin) {
            commentsHtml = `
                <div class="alert alert-info mt-3">
                    <strong><i class="fas fa-comment-medical"></i> Commentaire du médecin:</strong><br>
                    ${devi.commentaire_medecin}
                </div>
            `;
        }
        
        let content = `
            <div class="row mb-3">
                <div class="col-6"><strong>Code:</strong> ${devi.code || 'N/A'}</div>
                <div class="col-6"><strong>Type:</strong> 
                    <span class="badge bg-primary">${devi.acces || 'N/A'}</span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-6"><strong>Nom:</strong> ${devi.nom || 'N/A'}</div>
                <div class="col-6"><strong>Statut:</strong> 
                    <span class="badge bg-${statusClass}">
                        ${statusText}
                    </span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-6"><strong>Patient:</strong> ${patientName}</div>
                <div class="col-6"><strong>Médecin:</strong> ${medecinName}</div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <strong>Date de création:</strong> 
                    ${devi.created_at ? new Date(devi.created_at).toLocaleDateString('fr-FR') : 'N/A'}
                </div>
            </div>
            <hr>
            ${lignesHtml}
            ${hospitalizationHtml}
            ${commentsHtml}
            <hr>
            <h6>Résumé des montants:</h6>
            <div class="row">
                <div class="col-6">
                    <strong>Montant initial:</strong><br>
                    <span class="fs-5">${parseInt(devi.montant_avant_reduction || 0).toLocaleString('fr-FR')} FCFA</span>
                </div>
                <div class="col-6">
                    <strong>Réduction appliquée:</strong><br>
                    <span class="fs-5 ${devi.pourcentage_reduction > 0 ? 'text-danger' : ''}">${devi.pourcentage_reduction || 0}%</span>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <div class="alert alert-success mb-0">
                        <strong>Montant final à payer:</strong><br>
                        <span class="fs-4">${parseInt(devi.montant_apres_reduction || 0).toLocaleString('fr-FR')} FCFA</span>
                    </div>
                </div>
            </div>
        `;
        
        // Update modal content
        $('#viewDevisContent').html(content);
        
        // Show modal using Bootstrap 5
        const modalEl = document.getElementById('viewDevisModal');
        if (modalEl) {
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
        } else {
            console.error('Modal element not found');
        }
        
    } catch (error) {
        console.error('Error in viewDevis:', error);
        alert('Erreur lors de l\'affichage du devis');
    }
};

// Attach event listeners using delegation
waitForjQuery(function() {
    $(document).ready(function() {
        console.log('Attaching view devis button listeners...');
        
        // Use event delegation for dynamically loaded content
        $(document).on('click', '.view-devis-btn', function(e) {
            e.preventDefault();
            console.log('View button clicked');
            
            const deviData = $(this).data('devi');
            console.log('Devis data from button:', deviData);
            
            if (deviData) {
                viewDevis(deviData);
            } else {
                console.error('No devis data found on button');
                alert('Erreur: Données du devis introuvables');
            }
        });
        
        console.log('View devis listeners attached');
    });
});

console.log('View devis functionality loaded');
</script>


<script>
// Initialize DataTable ONCE
waitForjQuery(function() {
    $(document).ready(function() {
        if ($('#devisTable').length && !$.fn.DataTable.isDataTable('#devisTable')) {
            console.log('Initializing devisTable...');
            $('#devisTable').DataTable({
                language: { 
                    url: "{{ asset('vendor/i18n/fr_fr.json') }}" 
                },
                pageLength: 10,
                responsive: true,
                order: [[6, 'desc']]
            });
        }
    });
});
</script>
@endpush

@endsection














