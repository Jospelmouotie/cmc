@extends('layouts.admin')
@section('title', 'CMCU | Liste des produits pharmaceutique')
@section('content')

<body>
    <div class="wrapper">
        @include('partials.side_bar')
        @include('partials.header')

        <div class="container">
            <h2 class="text-center">FACTURATION</h2>
            <div class="row">
                <div class="col-md-12 col-lg-10 offset-md-1">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Quantité</th>
                                <th>Prix unitaire</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Reduire</th>
                                <th class="text-center">Ajouter</th>
                                <th class="text-center">Supprimer</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (Session::has('cart'))
                                @foreach($produits as $produit)
                                <tr data-product-id="{{ $produit['item']['id'] }}">
                                    <td class="col-md-8 col-lg-6">
                                        <div class="media-body">
                                            <p>{{ $produit['item']['designation'] }}</p>
                                        </div>
                                    </td>
                                    <td class="col-md-1 col-lg-1" style="text-align: center">
                                        <input type="number" class="form-control quantity-input" min="1"
                                            value="{{ $produit['quantite'] }}"
                                            data-product-id="{{ $produit['item']['id'] }}"
                                            data-old-qty="{{ $produit['quantite'] }}">
                                    </td>
                                    <td class="col-md-1 col-lg-1 text-center">
                                        <strong>{{ $produit['prix_unitaire'] }}</strong>
                                    </td>
                                    <td class="col-md-1 col-lg-1 text-center item-total">
                                        <strong>{{ $produit['quantite'] * $produit['prix_unitaire'] }}</strong>
                                    </td>
                                    <td>
                                        <a href="{{ route('facturation.reduire', ['id' => $produit['item']['id']]) }}"
                                           class="btn btn-primary quantity-action" title="Reduire la quantité">
                                            <i class="fas fa-minus"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('pharmaceutique.cart', $produit['item']['id']) }}"
                                           class="btn btn-success quantity-action" title="Ajouter la quantité">
                                            <i class="fas fa-plus-square"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('facturation.supprimer', ['id' => $produit['item']['id']]) }}"
                                           class="btn btn-danger quantity-action" title="Supprimer le produit">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="5"></td>
                                    <td><h3>Total</h3></td>
                                    <td class="text-end">
                                        <h3><strong class="grand-total">{{ $totalPrix }}</strong></h3>
                                    </td>
                                </tr>
                        </tbody>
                    </table>

                    <form action="{{ route('pharmacie.pdf') }}" method="post" class="mb-3" id="form-imprimer">
                        @csrf
                        <div class="form-group">
                            <label for="patient"><b>Nom du patient :</b></label>
                            <select name="patient" id="patient" class="form-control col-md-5 mb-2" required>
                                <option value="">Choisir un patient</option>
                                @foreach ($patient as $patients)
                                    <option value="{{ $patients->name }}">{{ $patients->name }} {{ $patients->prenom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-3">
                            <a href="{{ route('produits.pharmaceutique') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Ajouter des produits
                            </a>
                           <form action="{{ route('produits.store') }}" method="POST">
    @csrf
    <input type="hidden" name="patient_id" id="patient_id_field">
    <input type="hidden" name="mode_paiement" value="Espèces">

    <button type="submit" class="btn btn-primary">
        <i class="fa fa-print"></i> Valider et Générer le PDF
    </button>
</form>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log("🚀 Script de facturation chargé");

        const patientSelect = document.getElementById('patient');

        // 1. Gestion du Patient (LocalStorage)
        const savedPatient = localStorage.getItem('selectedPatient');
        if (savedPatient && patientSelect) {
            console.log("📍 Restauration du patient :", savedPatient);
            patientSelect.value = savedPatient;
        }

        if (patientSelect) {
            patientSelect.addEventListener('change', function() {
                console.log("💾 Patient sélectionné :", this.value);
                localStorage.setItem('selectedPatient', this.value);
            });
        }

        // 2. Changement manuel de quantité (Input)
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('change', function() {
                const productId = this.dataset.productId;
                const newQty = parseInt(this.value) || 1;
                const oldQty = parseInt(this.dataset.oldQty) || 1;

                console.log(`🔢 Changement quantité produit [${productId}]: ${oldQty} -> ${newQty}`);

                if (newQty < 1) {
                    this.value = 1;
                    return;
                }
                updateQuantity(productId, newQty, oldQty, this);
            });
        });

        // 3. Boutons + / - / Supprimer (AJAX)
        document.querySelectorAll('.quantity-action').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const url = this.href;
                console.log("📡 Envoi requête bouton vers :", url);

                fetch(url, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    console.log("✅ Réponse reçue (bouton) :", data);
                    if (data.success || data.items) {
                        updateCartDisplay(data);
                    } else {
                        console.warn("⚠️ Erreur backend :", data.message);
                        alert(data.message || 'Erreur lors de la mise à jour');
                    }
                })
                .catch(error => {
                    console.error('❌ Erreur AJAX bouton:', error);
                    window.location.href = url; // Fallback
                });
            });
        });

        // Fonction pour mettre à jour la quantité via Input
        function updateQuantity(productId, newQty, oldQty, inputElement) {
            const diff = newQty - oldQty;
            const url = diff > 0
                ? `/admin/pharmaceutiques/${productId}`
                : `/admin/reduire/${productId}`;

            console.log(`🔄 Synchronisation de la différence (${diff}) via : ${url}`);

            const requests = Math.abs(diff);
            let completed = 0;

            for (let i = 0; i < requests; i++) {
                fetch(url, {
                    method: 'GET',
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                })
                .then(response => response.json())
                .then(data => {
                    completed++;
                    if (completed === requests) {
                        console.log("🏁 Toutes les requêtes de quantité terminées");
                        updateCartDisplay(data);
                        inputElement.dataset.oldQty = newQty;
                    }
                })
                .catch(err => console.error("❌ Erreur boucle quantité:", err));
            }
        }

        // Mise à jour du DOM sans recharger la page
        function updateCartDisplay(data) {
            console.log("🖥️ Mise à jour de l'affichage HTML...");

            if (data.cartEmpty) {
                console.log("🛒 Panier vide, rechargement...");
                window.location.reload();
                return;
            }

            // Mise à jour des lignes
            Object.keys(data.items).forEach(id => {
                const item = data.items[id];
                const row = document.querySelector(`tr[data-product-id="${id}"]`);

                if (row) {
                    const qtyInput = row.querySelector('.quantity-input');
                    const itemTotal = row.querySelector('.item-total strong');

                    if (qtyInput) qtyInput.value = item.qty;
                    if (itemTotal) itemTotal.textContent = item.price;
                }
            });

            // Totaux Généraux
            if (document.querySelector('.grand-total')) {
                document.querySelector('.grand-total').textContent = data.totalPrix;
            }

            // Mise à jour du badge dans le header
            const badge = document.querySelector('.badge p');
            if (badge) {
                badge.textContent = data.totalQte;
                console.log("🏷️ Badge total mis à jour :", data.totalQte);
            }
        }
    });
    </script>
</body>
@endsection
