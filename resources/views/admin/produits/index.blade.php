@extends('layouts.admin')
@section('title', 'CMCU | Liste des produits')

@section('content')
<div class="wrapper">
    @include('partials.side_bar')
    @include('partials.header')

    <div class="content-wrapper">
        @can('create', \App\Models\Produit::class)
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-4 align-items-center">
                    <div class="col-sm-6">
                        <h1 class="fw-bold text-dark"><i class="fas fa-boxes me-2"></i>Gestion des Produits</h1>
                    </div>
                    <div class="col-sm-6 text-end">
                        <a href="{{ route('produits.create') }}" class="btn btn-success shadow-sm">
                            <i class="fas fa-plus-circle"></i> Nouveau Produit
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <div class="card shadow-sm border-0 border-start border-primary border-4">
                            <div class="card-body py-2">
                                <p class="text-muted mb-0 small uppercase fw-bold">Total Inventaire</p>
                                <h3 class="fw-bold mb-0 text-primary">{{ $produitCount }} <small class="text-muted fs-6">articles</small></h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0 fw-bold"><i class="fas fa-list me-2"></i>Répertoire des articles</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="produitsTable" class="table table-hover align-middle border-bottom">
                                <thead class="table-light text-secondary">
                                    <tr>
                                        <th class="border-0">ID</th>
                                        <th class="border-0">DÉSIGNATION</th>
                                        <th class="border-0">CATÉGORIE</th>
                                        <th class="border-0">STOCK ACTUEL</th>
                                        <th class="border-0">PRIX UNITAIRE</th>
                                        <th class="border-0 text-center">ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($produits as $produit)
                                    <tr>
                                        <td class="text-muted fw-bold">#{{ $produit->id }}</td>
                                        <td>
                                            <span class="fw-bold text-dark d-block">{{ $produit->designation }}</span>
                                            <small class="text-muted">Alerte à : {{ $produit->qte_alerte }} unités</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border">{{ $produit->categorie }}</span>
                                        </td>
                                        <td>
                                            @if($produit->qte_stock <= $produit->qte_alerte)
                                                <span class="badge rounded-pill bg-danger px-3">
                                                    <i class="fas fa-exclamation-triangle me-1"></i> {{ $produit->qte_stock }} (Faible)
                                                </span>
                                            @else
                                                <span class="badge rounded-pill bg-success px-3">
                                                    {{ $produit->qte_stock }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="fw-bold">{{ number_format($produit->prix_unitaire, 0, ',', ' ') }} <small>FCFA</small></td>
                                        <td class="text-center">
                                            <div class="btn-group shadow-sm">
                                                <a href="{{ route('produits.edit', $produit->id)}}"
                                                   class="btn btn-sm btn-white text-primary border"
                                                   title="Modifier">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                <form action="{{ route('produits.destroy', $produit->id) }}"
                                                      method="post" class="d-inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                            class="btn btn-sm btn-white text-danger border"
                                                            onclick="return confirm('Confirmer la suppression de cet article ?')"
                                                            title="Supprimer">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div class="text-muted small">
                                Affichage de {{ $produits->firstItem() }} à {{ $produits->lastItem() }} sur {{ $produits->total() }} produits
                            </div>
                            <div>
                                {{ $produits->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @endcan
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        if (!$.fn.DataTable.isDataTable('#produitsTable')) {
            $('#produitsTable').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json"
                },
                pageLength: 25,
                responsive: true,
                dom: '<"d-flex justify-content-between mb-3"Bf>rt', // Custom layout
                buttons: [
                    {
                        extend: 'excelHtml5',
                        className: 'btn btn-sm btn-outline-success',
                        text: '<i class="fas fa-file-excel me-1"></i> Excel'
                    },
                    {
                        extend: 'pdfHtml5',
                        className: 'btn btn-sm btn-outline-danger',
                        text: '<i class="fas fa-file-pdf me-1"></i> PDF'
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-sm btn-outline-secondary',
                        text: '<i class="fas fa-print me-1"></i> Imprimer'
                    }
                ]
            });
        }
    });
</script>
@endpush
