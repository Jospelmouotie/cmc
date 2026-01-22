@extends('layouts.admin')

@section('title', 'CMCU | Liste des produits pharmaceutique')

@section('content')
<div class="wrapper">
    @include('partials.side_bar')
    @include('partials.header')

    <div class="container-fluid py-4">

        <!-- Page Title -->
        <div class="row mb-4">
            <div class="col text-center">
                <h1 class="fw-bold text-primary">💉 Liste des Produits de l'Anesthésiste</h1>
                <hr class="w-25 mx-auto">
            </div>
        </div>

        <!-- Facturation Button -->
        @can('anesthesiste', \App\Models\Patient::class)
        <div class="row mb-4">
            <div class="col text-end">
                <a href="{{ route('pharmaceutique.facturation') }}" 
                   class="btn btn-lg btn-success shadow-sm" 
                   title="Procéder à la facturation">
                    <i class="fas fa-file-invoice"></i> Facture
                    <span class="badge bg-light text-dark ms-2">
                        {{ Session::has('cart') ? Session::get('cart')->totalQte : 0 }}
                    </span>
                </a>
            </div>
        </div>
        @endcan

        <!-- Products Table -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="produitsTable" class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Désignation</th>
                                        <th>Stock</th>
                                        <th>Alerte</th>
                                        <th>Prix Unitaire</th>
                                        @can('anesthesiste', \App\Models\Patient::class)
                                        <th>Ajouter à la Facture</th>
                                        @endcan
                                        @can('update', \App\Models\Produit::class)
                                        <th>Éditer</th>
                                        <th>Supprimer</th>
                                        @endcan
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($produits as $produit)
                                    <tr>
                                        <td>{{ $produit->id }}</td>
                                        <td>{{ $produit->designation }}</td>
                                        <td>
                                            <span class="badge bg-{{ $produit->qte_stock <= $produit->qte_alerte ? 'danger' : 'success' }}">
                                                {{ $produit->qte_stock }}
                                            </span>
                                        </td>
                                        <td>{{ $produit->qte_alerte }}</td>
                                        <td>{{ number_format($produit->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                                        @can('anesthesiste', \App\Models\Patient::class)
                                        <td>
                                            <a href="{{ route('pharmaceutique.cart', $produit->id) }}" 
                                               class="btn btn-sm btn-outline-success" 
                                               title="Ajouter à la facture">
                                                <i class="fas fa-plus-square"></i>
                                            </a>
                                        </td>
                                        @endcan
                                        @can('update', \App\Models\Produit::class)
                                        <td>
                                            <a href="{{ route('produits.edit',$produit->id)}}" 
                                               class="btn btn-sm btn-outline-primary" 
                                               title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <form action="{{ route('produits.destroy', $produit->id)}}" method="post" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-danger" 
                                                        onclick="return confirm('Supprimer ce produit ?')" 
                                                        title="Supprimer">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                        @endcan
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{-- Pagination --}}
                        <div class="mt-3">
                            {{ $produits->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="{{ asset('admin/js/main.js') }}"></script>



<!-- DataTables for interactivity -->
<!-- @push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        $('#produitsTable').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.11.5/i18n/fr_fr.json"
            },
            pageLength: 10,
            responsive: true
        });
    });
</script>
@endpush -->


@push('scripts')
<script>
    $(document).ready(function() {
        $('#produitsTable').DataTable({
            language: {
                url: "{{ asset('vendor/i18n/fr_fr.json') }}" // store the language file locally too
            },
            pageLength: 10,
            responsive: true,
            dom: 'Bfrtip', // enables buttons
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
</script>
@endpush
@endsection
