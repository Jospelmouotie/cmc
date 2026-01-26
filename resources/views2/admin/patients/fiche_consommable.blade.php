@extends('layouts.admin')

@section('title', 'CMCU | Fiches de consommables')

@section('content')

<style type="text/css">
    .tt-dropdown-menu {
        width: 100% !important;
    }
    .tt-menu {
        width: 422px;
        margin: 12px 0;
        padding: 8px 0;
        background-color: #fff;
        border: 1px solid #ccc;
        border: 1px solid rgba(0, 0, 0, 0.2);
        border-radius: 8px;
        box-shadow: 0 5px 10px rgba(0, 0, 0, .2);
    }
    .tt-suggestion:hover {
        cursor: pointer;
        color: #fff;
        background-color: #0097cf;
    }
    #scrollable-dropdown-menu {
        max-height: 150px;
        overflow-y: auto;
    }
    .tt-suggestion p {
        margin: 0;
    }
</style>

<div class="wrapper">
    @include('partials.side_bar')
    @include('partials.header')
    
    @can('show', \App\Models\User::class)
    <div class="row mb-1">
        <div class="col-sm-12">
            <h1 class="text-center">FICHES DE CONSOMMABLES</h1>
        </div>
    </div>
    <hr>
    
    <div class="container">
        <!-- Boutons de navigation -->
        <div class="d-grid gap-2 mb-2 d-md-block">
            <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-success float-end" title="Retour à la liste des patients">
                <i class="fas fa-arrow-left"></i> Retour au dossier patient
            </a>
            <a href="{{ route('patients.index') }}" class="btn btn-success offset-0">
                <i class="fas fa-list-ul"></i> Liste des patients
            </a>
        </div>

        <!-- Messages d'erreur et de succès -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Erreur !</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Informations patient -->
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Patient: {{ $patient->name }} {{ $patient->prenom }}</h5>
                <p class="card-text">Dossier N°: {{ $patient->numero_dossier }}</p>
            </div>
        </div>

        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center" width="40%">CONSOMMABLES</th>
                            <th class="text-center" width="10%">P (Jour)</th>
                            <th class="text-center" width="10%">G (Nuit)</th>
                            <th class="text-center" width="10%">DATE</th>
                            <th class="text-center" width="10%">IDE</th>
                            <th class="text-center" width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- FORMULAIRE D'AJOUT -->
                        <form method="POST" action="{{ route('fiche_consommable.store') }}" id="formConsommable">
                            @csrf
                            
                            <!-- Champs cachés -->
                            <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                            <input type="hidden" name="user_id" value="{{ $user_id }}">
                            
                            <tr class="table-info">
                                <td>
                                    <!--select
                                        name="consommable"
                                        id="consommable"
                                        class="form-control"
                                        required>
                                        <option value="">Sélectionner un consommable...</option>
                                        @foreach($produits->groupBy('categorie') as $categorie => $produitsParCategorie)
                                            <optgroup label="{{ $categorie }}">
                                                @foreach($produitsParCategorie as $produit)
                                                    <option value="{{ $produit->designation }}"
                                                            {{ old('consommable') == $produit->designation ? 'selected' : '' }}
                                                            @if($produit->qte_stock <= 0) style="color: red;" @elseif($produit->qte_stock <= $produit->qte_alerte) style="color: orange;" @endif>
                                                        {{ $produit->designation }}
                                                        @if($produit->qte_stock <= 0)
                                                            (ÉPUISÉ)
                                                        @elseif($produit->qte_stock <= $produit->qte_alerte)
                                                            (Stock faible: {{ $produit->qte_stock }})
                                                        @else
                                                            (Stock: {{ $produit->qte_stock }})
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select-->

                                    <input type="text"
                                            name="consommable"
                                            id="consommable"
                                            class="form-control"
                                            list="consommablesList"
                                            placeholder="Saisir ou sélectionner un consommable..."
                                            value="{{ old('consommable') }}"
                                            required>

                                        <datalist id="consommablesList" style= "background-color: #fff;">
                                            @foreach($produits as $produit)
                                                <option value="{{ $produit->designation }}" style= "background-color: #fff;">
                                                    {{ $produit->designation }}
                                                    @if($produit->qte_stock <= 0)
                                                        (Rupture)
                                                    @elseif($produit->qte_stock <= $produit->qte_alerte)
                                                        (Stock faible: {{ $produit->qte_stock }})
                                                    @else
                                                        (Stock: {{ $produit->qte_stock }})
                                                    @endif
                                                </option>
                                            @endforeach
                                        </datalist>

                                        @error('consommable')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror


                                    @error('consommable')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                
                                <td>
                                    <input 
                                        type="number" 
                                        name="jour" 
                                        class="form-control" 
                                        min="0" 
                                        step="1"
                                        value="{{ old('jour', 0) }}"
                                        placeholder="0">
                                    @error('jour')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </td>
                                
                                <td>
                                    <input 
                                        type="number" 
                                        name="nuit" 
                                        class="form-control" 
                                        min="0" 
                                        step="1"
                                        value="{{ old('nuit', 0) }}"
                                        placeholder="0">
                                    @error('nuit')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </td>
                                
                                <td>
                                    <input 
                                        type="date" 
                                        name="date" 
                                        class="form-control" 
                                        value="{{ old('date', \Carbon\Carbon::now()->toDateString()) }}"
                                        required>
                                    @error('date')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </td>
                                
                                <td class="text-center">
                                    <button type="submit" class="btn btn-primary btn-sm w-100">
                                        <i class="fas fa-save"></i> Enregistrer
                                    </button>
                                </td>
                            </tr>
                        </form>
                        <!-- FIN FORMULAIRE -->

                      <!-- En-tête de la liste -->
                        <tr class="table-active">
                            <th>CONSOMMABLES</th>
                            <th>P (Jour)</th>
                            <th>G (Nuit)</th>
                            <th>DATE</th>
                            <th>IDE</th>
                            <th>ACTION</th>
                        </tr>

                        <!-- LISTE DES CONSOMMABLES -->
                        @forelse($consommables as $consommable)
                            <tr>
                                <td>{{ $consommable->consommable }}</td>
                                <td class="text-center">{{ $consommable->jour ?? 0 }}</td>
                                <td class="text-center">{{ $consommable->nuit ?? 0 }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($consommable->date)->format('d/m/Y') }}</td>
                                <td>{{ $consommable->user->name ?? 'N/A' }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $consommable->id }}" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form method="POST" action="{{ route('fiche_consommable.destroy', $consommable->id) }}" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce consommable ?')" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal de modification -->
                            <div class="modal fade" id="editModal{{ $consommable->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $consommable->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel{{ $consommable->id }}">Modifier le consommable</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form method="POST" action="{{ route('fiche_consommable.update', $consommable->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="consommable{{ $consommable->id }}" class="form-label">Consommable</label>
                                                    <input type="text"
                                                            name="consommable"
                                                            id="consommable{{ $consommable->id }}"
                                                            class="form-control"
                                                            list="consommablesList{{ $consommable->id }}"
                                                            placeholder="Saisir ou sélectionner un consommable..."
                                                            value="{{ $consommable->consommable }}"
                                                            required>

                                                        <datalist id="consommablesList{{ $consommable->id }}" style= "background-color: #fff;">
                                                            @foreach($produits as $produit)
                                                                <option value="{{ $produit->designation }}" style= "background-color: #fff;">
                                                                    {{ $produit->designation }}
                                                                    @if($produit->qte_stock <= 0)
                                                                        (Rupture)
                                                                    @elseif($produit->qte_stock <= $produit->qte_alerte)
                                                                        (Stock faible: {{ $produit->qte_stock }})
                                                                    @else
                                                                        (Stock: {{ $produit->qte_stock }})
                                                                    @endif
                                                                </option>
                                                            @endforeach
                                                        </datalist>

                                                        @error('consommable')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="jour{{ $consommable->id }}" class="form-label">P (Jour)</label>
                                                    <input type="number" class="form-control" id="jour{{ $consommable->id }}" name="jour" value="{{ $consommable->jour }}" min="0">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nuit{{ $consommable->id }}" class="form-label">G (Nuit)</label>
                                                    <input type="number" class="form-control" id="nuit{{ $consommable->id }}" name="nuit" value="{{ $consommable->nuit }}" min="0">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="date{{ $consommable->id }}" class="form-label">Date</label>
                                                    <input type="date" class="form-control" id="date{{ $consommable->id }}" name="date" value="{{ $consommable->date }}" required>
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
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    <em>Aucun consommable enregistré pour ce patient</em>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                @if($consommables->hasPages())
                    <div class="d-flex justify-content-center">
                        {{ $consommables->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endcan
</div>

@endsection

<!--@push('scripts')-->
@section('script')
<script>
waitForjQuery(function() {
    $(document).ready(function() {
        // Initialiser Select2 sur le champ consommable pour permettre la recherche
        $('#consommable').select2({
            placeholder: 'Tapez pour rechercher un consommable...',
            allowClear: true,
            width: '100%',
            minimumInputLength: 1,
            language: {
                noResults: function() {
                    return "Aucun résultat trouvé";
                },
                searching: function() {
                    return "Recherche en cours...";
                },
                inputTooShort: function() {
                    return "Tapez au moins 1 caractère";
                }
            }
        });

        // Gestion de la soumission du formulaire
        $('#formConsommable').on('submit', function(e) {
            console.log('Formulaire en cours de soumission...');

            var consommable = $('#consommable').val();
            var jour = $('input[name="jour"]').val();
            var nuit = $('input[name="nuit"]').val();
            var date = $('input[name="date"]').val();


            if (!consommable || consommable.trim() === '') {
                e.preventDefault();
                alert('Veuillez sélectionner un consommable');
                return false;
            }

            if (!date) {
                e.preventDefault();
                alert('Veuillez saisir une date');
                return false;
            }

            // Vérifier qu'au moins jour ou nuit est renseigné
            if ((!jour || jour == 0) && (!nuit || nuit == 0)) {
                if (!confirm('Aucune quantité n\'est renseignée. Voulez-vous continuer ?')) {
                    e.preventDefault();
                    return false;
                }
            }

            console.log('Données du formulaire:', {
                consommable: consommable,
                jour: jour,
                nuit: nuit,
                date: date
            });

            // Le formulaire sera soumis normalement
            return true;
        });

        // Auto-dismiss des alertes après 5 secondes
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    });
});
</script>
@endsection
