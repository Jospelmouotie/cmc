@extends('layouts.admin')

@section('title', 'CMCU | Gestion des éléments de devis')

@section('content')

@php
use Illuminate\Support\Str;
@endphp

<body>

    <div class="wrapper">
        @include('partials.side_bar')
        @include('partials.header')

        @can('viewAny', \App\Models\DevisElement::class)
        <div class="container-fluid px-4 py-4">
            <!-- Header -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-1"><i class="fas fa-list-ul text-primary me-2"></i>Éléments de Devis</h2>
                            <p class="text-muted mb-0">Gestion des éléments prédéfinis pour les devis</p>
                        </div>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addElementModal">
                            <i class="fas fa-plus me-2"></i>Nouvel Élément
                        </button>
                    </div>
                </div>
            </div>

            <!-- Elements Table -->
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="elementsTable" class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Nom</th>
                                    <th>Code</th>
                                    <th>Prix Unitaire</th>
                                    <th>Statut</th>
                                    <th>Créé par</th>
                                    <th>Date</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($elements as $element)
                                <tr>
                                    <td>
                                        <strong>{{ $element->nom }}</strong>
                                        @if($element->description)
                                        <br><small class="text-muted">{{ Str::limit($element->description, 50) }}</small>
                                        @endif
                                    </td>
                                    <td><span class="badge bg-secondary">{{ $element->code ?? 'N/A' }}</span></td>
                                    <td><strong>{{ number_format($element->prix_unitaire, 0, ',', ' ') }} FCFA</strong></td>
                                    <td>
                                        @if($element->actif)
                                        <span class="badge bg-success">Actif</span>
                                        @else
                                        <span class="badge bg-warning">Inactif</span>
                                        @endif
                                    </td>
                                    <td>{{ $element->user->name ?? 'N/A' }}</td>
                                    <td><small>{{ $element->created_at->format('d/m/Y') }}</small></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-outline-primary" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editElementModal"
                                                data-id="{{ $element->id }}"
                                                data-nom="{{ $element->nom }}"
                                                data-code="{{ $element->code }}"
                                                data-prix="{{ $element->prix_unitaire }}"
                                                data-description="{{ $element->description }}"
                                                data-actif="{{ $element->actif }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        
                                        <form action="{{ route('devis_elements.destroy', $element->id) }}" method="POST" class="d-inline" 
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet élément ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{ $elements->links() }}
                </div>
            </div>
        </div>

        <!-- Add Element Modal -->
        <div class="modal fade" id="addElementModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('devis_elements.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Nouvel Élément de Devis</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nom" required 
                                       placeholder="Ex: CS ANESTHESIQUE EN INTERNE">
                            </div>
                            
                            <div class="mb-3">
                                <label for="code" class="form-label">Code</label>
                                <input type="text" class="form-control" name="code" 
                                       placeholder="Ex: KC, KA">
                            </div>
                            
                            <div class="mb-3">
                                <label for="prix_unitaire" class="form-label">Prix Unitaire (FCFA) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="prix_unitaire" required min="0" 
                                       placeholder="Ex: 25000">
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" name="description" rows="3" 
                                          placeholder="Description optionnelle"></textarea>
                            </div>
                            
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="actif" value="1" checked id="actif_add">
                                <label class="form-check-label" for="actif_add">
                                    Actif
                                </label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Element Modal -->
        <div class="modal fade" id="editElementModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="editElementForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Modifier l'Élément</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="edit_nom" class="form-label">Nom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nom" id="edit_nom" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="edit_code" class="form-label">Code</label>
                                <input type="text" class="form-control" name="code" id="edit_code">
                            </div>
                            
                            <div class="mb-3">
                                <label for="edit_prix_unitaire" class="form-label">Prix Unitaire (FCFA) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="prix_unitaire" id="edit_prix_unitaire" required min="0">
                            </div>
                            
                            <div class="mb-3">
                                <label for="edit_description" class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="edit_description" rows="3"></textarea>
                            </div>
                            
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="actif" value="1" id="edit_actif">
                                <label class="form-check-label" for="edit_actif">
                                    Actif
                                </label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Mettre à jour</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endcan
    </div>
</body>

@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const editModal = document.getElementById('editElementModal');

    editModal.addEventListener('show.bs.modal', function (event) {

        const button = event.relatedTarget;

        // Get data attributes
        const id = button.getAttribute('data-id');
        const nom = button.getAttribute('data-nom');
        const code = button.getAttribute('data-code');
        const prix = button.getAttribute('data-prix');
        const description = button.getAttribute('data-description');
        const actif = button.getAttribute('data-actif');

        // Update form action
        const form = editModal.querySelector('#editElementForm');
        form.action = `/admin/devis-elements/${id}`;

        // Fill fields
        editModal.querySelector('#edit_nom').value = nom ?? '';
        editModal.querySelector('#edit_code').value = code ?? '';
        editModal.querySelector('#edit_prix_unitaire').value = prix ?? '';
        editModal.querySelector('#edit_description').value = description ?? '';
        editModal.querySelector('#edit_actif').checked = actif == 1;
    });
});
</script>
@endsection
