<div class="modal fade" id="ordonanceAll" tabindex="-1" role="dialog" aria-labelledby="ordonanceAll" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">DOCUMENTS MEDICAUX</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <!-- Onglets Navigation -->
                <ul class="nav nav-tabs mb-3" id="medicalDocsTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="ordonances-tab" data-bs-toggle="tab" data-bs-target="#ordonances-content" type="button" role="tab" aria-controls="ordonances-content" aria-selected="true">
                            <i class="fas fa-file-prescription"></i> Ordonnances
                        </button>
                    </li>  
                    @can('med_inf_anes', \App\Models\Patient::class)
                              
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" type="button" ><a style="text-decoration:none;" href="{{ route('fiche.prescription_medicale.index', $patient) }}" title="Prescriptions médicales">
                                    <i class="fas fa-pills"></i> Prescriptions Médicales
                                    </a>
                            </button>
                        </li>  
                    @endcan
                </ul>

                    <!-- Contenu des onglets -->
                    <div class="tab-content" id="medicalDocsTabContent">
                        
                        <!-- ONGLET 1: ORDONNANCES -->
                        <div class="tab-pane fade show active" id="ordonances-content" role="tabpanel" aria-labelledby="ordonances-tab">
                            @if (count($patient->ordonances))
                                <h4 class="mb-3">Ordonnances médicales</h4>
                                
                                <!-- Zone de recherche -->
                                <div class="mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        <input type="text" 
                                               class="form-control" 
                                               id="searchOrdonance" 
                                               placeholder="Rechercher par médicament, posologie ou date...">
                                        <button class="btn btn-outline-secondary" type="button" id="clearSearch">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <small class="text-muted">
                                        <span id="resultCount">{{ count($patient->ordonances) }}</span> ordonnance(s) trouvée(s)
                                    </small>
                                </div>

                                <!-- Tableau avec scroll -->
                                <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                                    <table class="table table-bordered table-striped table-hover" id="ordonancesTable">
                                        <thead class="table-primary" style="position: sticky; top: 0; z-index: 10;">
                                            <tr>
                                                <th>MEDICAMENT</th>
                                                <th>QUANTITE</th>
                                                <th>POSOLOGIE</th>
                                                <th>DATE</th>
                                                <th>ACTIONS</th>
                                            </tr>
                                        </thead>
                                        <tbody id="ordonancesBody">
                                            @foreach($patient->ordonances as $ordonance)
                                                <tr class="ordonance-row" 
                                                    data-medicament="{{ strtolower($ordonance->medicament) }}"
                                                    data-posologie="{{ strtolower($ordonance->description) }}"
                                                    data-date="{{ strtolower($ordonance->created_at->toFormattedDateString()) }}">
                                                    <td>{{ $ordonance->medicament }}</td>
                                                    <td>{{ $ordonance->quantite }}</td>
                                                    <td>{{ $ordonance->description }}</td>
                                                    <td>{{ $ordonance->created_at->toFormattedDateString() }}</td>
                                                    <td>
                                                        <a class="btn btn-success btn-sm" title="Imprimer l'ordonance" href="{{ route('ordonance.pdf', $ordonance->id) }}">
                                                            <i class="fas fa-print"></i>
                                                        </a>

                                                        <a class="btn btn-primary btn-sm" title="Modifier l'ordonance"
                                                            href="{{ route('ordonances.edit', ['id' => $ordonance->id]) }}?patient={{ $patient->id }}">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Message si aucun résultat -->
                                <div id="noResultMessage" class="alert alert-warning mt-3" style="display: none;">
                                    <i class="fas fa-exclamation-triangle"></i> Aucune ordonnance ne correspond à votre recherche.
                                </div>

                            @else
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> Aucune ordonnance enregistrée pour ce patient.
                                </div>
                            @endif
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Style pour le scroll */
    .table-responsive::-webkit-scrollbar {
        width: 8px;
    }
    
    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .table-responsive::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }
    
    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Highlight pour les résultats de recherche */
    .highlight {
        background-color: #fff3cd;
        font-weight: bold;
    }

    /* Animation pour les lignes cachées */
    .ordonance-row {
        transition: opacity 0.3s ease;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchOrdonance');
    const clearBtn = document.getElementById('clearSearch');
    const tableBody = document.getElementById('ordonancesBody');
    const resultCount = document.getElementById('resultCount');
    const noResultMessage = document.getElementById('noResultMessage');
    const rows = document.querySelectorAll('.ordonance-row');
    const totalRows = rows.length;

    // Fonction de recherche
    function performSearch() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        let visibleCount = 0;

        rows.forEach(row => {
            const medicament = row.getAttribute('data-medicament');
            const posologie = row.getAttribute('data-posologie');
            const date = row.getAttribute('data-date').toLowerCase();
            
            const matches = medicament.includes(searchTerm) || 
                          posologie.includes(searchTerm) || 
                          date.includes(searchTerm);

            if (matches || searchTerm === '') {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Mettre à jour le compteur
        resultCount.textContent = visibleCount;

        // Afficher/masquer le message "aucun résultat"
        if (visibleCount === 0 && searchTerm !== '') {
            noResultMessage.style.display = 'block';
        } else {
            noResultMessage.style.display = 'none';
        }
    }

    // Événement de recherche
    searchInput.addEventListener('input', performSearch);

    // Bouton clear
    clearBtn.addEventListener('click', function() {
        searchInput.value = '';
        performSearch();
        searchInput.focus();
    });

    // Recherche avec Enter
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            performSearch();
        }
    });
});
</script>