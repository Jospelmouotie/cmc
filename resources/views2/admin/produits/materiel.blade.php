@extends('layouts.admin')

@section('title', 'CMCU | Liste des produits matériels')

@section('content')
<div class="wrapper">
    @include('partials.side_bar')
    @include('partials.header')

    <div class="container-fluid py-4">

        <!-- Page Title -->
        <div class="row mb-4">
            <div class="col text-center">
                <h1 class="fw-bold text-primary">🛠️ Liste des Produits Matériels</h1>
                <hr class="w-25 mx-auto">
            </div>
        </div>

        <!-- Stats Card -->
        <div class="row justify-content-end mb-4">
            <div class="col-md-3">
                <div class="card shadow-sm border-0 bg-danger text-white text-center">
                    <div class="card-body">
                        <h5 class="card-title">Total Produits</h5>
                        <h2 class="fw-bold">{{ $materielCount }}</h2>
                    </div>
                </div>
            </div>
        </div>

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
                                        <th>Catégorie</th>
                                        <th>Stock</th>
                                        <th>Alerte</th>
                                        <th>Prix Unitaire</th>
                                        <th>Éditer</th>
                                        <th>Supprimer</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($produits as $produit)
                                    <tr>
                                        <td>{{ $produit->id }}</td>
                                        <td>{{ $produit->designation }}</td>
                                        <td>{{ $produit->categorie }}</td>
                                        <td>
                                            <span class="badge bg-{{ $produit->qte_stock <= $produit->qte_alerte ? 'danger' : 'success' }}">
                                                {{ $produit->qte_stock }}
                                            </span>
                                        </td>
                                        <td>{{ $produit->qte_alerte }}</td>
                                        <td>{{ number_format($produit->prix_unitaire, 0, ',', ' ') }} FCFA</td>
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
