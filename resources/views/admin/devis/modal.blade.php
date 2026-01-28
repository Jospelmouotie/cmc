<style>
    #autocomplete-suggestions {
        position: absolute;
        z-index: 2100;
        max-height: 250px;
        overflow-y: auto;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        border-radius: 4px;
        background: white;
        display: none;
    }

    .suggestion-item {
        cursor: pointer;
        padding: 8px 12px;
        border-bottom: 1px solid #eee;
    }

    .suggestion-item:hover {
        background-color: #f8f9fa;
        color: #0d6efd;
    }

    .procedure-row,
    .product-row {
        transition: all 0.2s;
        border-radius: 5px;
    }

    .procedure-row:hover,
    .product-row:hover {
        background-color: rgba(13, 110, 253, 0.05);
    }

    .nav-tabs .nav-link {
        color: #6c757d;
        font-weight: 500;
    }

    .nav-tabs .nav-link.active {
        color: #0d6efd;
        border-bottom: 3px solid #0d6efd;
    }
</style>

<div class="modal fade" id="devisModal" tabindex="-1" aria-labelledby="devisModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-fullscreen-lg-down">
        <div class="modal-content border-0">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="devisModalLabel">
                    <i class="fas fa-file-invoice-dollar me-2"></i>
                    <span id="modal-title-text">Nouveau Devis</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body bg-light p-3">
                <form id="devis_form" action="{{ route('devis.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="devi_id" id="devi_id">

                    <div class="card mb-3 shadow-sm border-0">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-lg-4 col-md-6">
                                    <label class="form-label fw-bold small text-uppercase">Patient <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select select2" id="patient_id" name="patient_id" required>
                                        <option value="">Sélectionnez un patient</option>
                                        @foreach ($patients as $patient)
                                            <option value="{{ $patient->id }}"
                                                data-medecin="{{ $patient->medecin_r }}">
                                                {{ $patient->name }} {{ $patient->prenom }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label fw-bold small text-uppercase">Désignation du devis <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="nom_devis" class="form-control" id="nom_devis"
                                        placeholder="Ex: Chirurgie Genou" required>
                                </div>

                                <div class="col-lg-2 col-md-6">
                                    <label class="form-label fw-bold small text-uppercase">Médecin Référent</label>
                                    <input type="text" id="medecin_r_display" class="form-control bg-light"
                                        placeholder="Automatique" readonly>
                                </div>

                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label fw-bold small text-uppercase">Admission <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select class="form-select" id="acces_devis" name="acces_devis" required>
                                            <option value="acte">Acte externe</option>
                                            <option value="bloc">Bloc opératoire</option>
                                        </select>
                                        <button type="button" class="btn btn-info text-white"
                                            id="import_patient_products" title="Importer consommables">
                                            <i class="fas fa-file-import"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white p-0">
                            <ul class="nav nav-tabs nav-fill" id="devisTabs" role="tablist">
                                <li class="nav-item">
                                    <button class="nav-link active py-3" id="procedures-tab" data-bs-toggle="tab"
                                        data-bs-target="#procedures" type="button">
                                        <i class="fas fa-hand-holding-medical me-2"></i>ACTES
                                        <span class="badge bg-primary ms-1" id="procedures_count">0</span>
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link py-3" id="products-tab" data-bs-toggle="tab"
                                        data-bs-target="#products" type="button">
                                        <i class="fas fa-box-open me-2"></i>CONSOMMABLES
                                        <span class="badge bg-success ms-1" id="products_count">0</span>
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link py-3" id="hospitalization-tab" data-bs-toggle="tab"
                                        data-bs-target="#hospitalization" type="button">
                                        <i class="fas fa-bed me-2"></i>SÉJOUR / HOSP.
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <div class="card-body tab-content p-3" id="devisTabsContent">
                            <div class="tab-pane fade show active" id="procedures">
                                <div class="d-none d-md-flex row fw-bold text-muted small mb-2 px-2">
                                    <div class="col-md-6">Libellé de l'acte</div>
                                    <div class="col-md-2 text-center">Quantité</div>
                                    <div class="col-md-2 text-end">Prix Unit.</div>
                                    <div class="col-md-2 text-end">Sous-total</div>
                                </div>
                                <div id="procedures_container" class="mb-3"></div>
                                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill"
                                    id="ajouter_procedure">
                                    <i class="fa fa-plus-circle me-1"></i> Ajouter un acte
                                </button>
                            </div>

                            <div class="tab-pane fade" id="products">
                                <div class="d-none d-md-flex row fw-bold text-muted small mb-2 px-2">
                                    <div class="col-md-5">Rechercher un produit</div>
                                    <div class="col-md-2 text-center">Stock</div>
                                    <div class="col-md-1 text-center">Qté</div>
                                    <div class="col-md-2 text-end">Prix Unit.</div>
                                    <div class="col-md-2 text-end">Total</div>
                                </div>
                                <div id="products_container" class="mb-3"></div>
                                <button type="button" class="btn btn-outline-success btn-sm rounded-pill"
                                    id="ajouter_product">
                                    <i class="fa fa-plus-circle me-1"></i> Ajouter un produit
                                </button>
                            </div>

                            <div class="tab-pane fade" id="hospitalization">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="list-group">
                                            <div
                                                class="list-group-item d-flex justify-content-between align-items-center bg-light fw-bold">
                                                Désignation <span>Qté x Prix Unit.</span>
                                            </div>
                                            <div class="list-group-item border-0 px-0">
                                                <div class="row g-2 align-items-center">
                                                    <div class="col-md-5 ps-3">Chambre (Nuitées)</div>
                                                    <div class="col-md-3"><input type="number" name="nbr_chambre"
                                                            id="nbr_chambre" class="form-control form-control-sm"
                                                            value="0"></div>
                                                    <div class="col-md-4 text-end pe-3 fw-bold"><span
                                                            id="prix_chambre">0</span> F</div>
                                                    <input type="hidden" name="pu_chambre" id="pu_chambre"
                                                        value="30000">
                                                </div>
                                            </div>
                                            <div class="list-group-item border-0 px-0">
                                                <div class="row g-2 align-items-center">
                                                    <div class="col-md-5 ps-3">Visite Médecin</div>
                                                    <div class="col-md-3"><input type="number" name="nbr_visite"
                                                            id="nbr_visite" class="form-control form-control-sm"
                                                            value="0"></div>
                                                    <div class="col-md-4 text-end pe-3 fw-bold"><span
                                                            id="prix_visite">0</span> F</div>
                                                    <input type="hidden" name="pu_visite" id="pu_visite"
                                                        value="10000">
                                                </div>
                                            </div>
                                            <div class="list-group-item border-0 px-0">
                                                <div class="row g-2 align-items-center">
                                                    <div class="col-md-5 ps-3">Soins (AMI-JOUR)</div>
                                                    <div class="col-md-3"><input type="number" name="nbr_ami_jour"
                                                            id="nbr_ami_jour" class="form-control form-control-sm"
                                                            value="0"></div>
                                                    <div class="col-md-4 text-end pe-3 fw-bold"><span
                                                            id="prix_ami_jour">0</span> F</div>
                                                    <input type="hidden" name="pu_ami_jour" id="pu_ami_jour"
                                                        value="9000">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="col-md-6 border-start d-flex flex-column justify-content-center align-items-center">
                                        <h6 class="text-muted text-uppercase">Total Séjour</h6>
                                        <h2 class="text-info"><span id="total_hospitalisation">0</span>
                                            <small>FCFA</small></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3 bg-dark text-white border-0 shadow">
                        <div class="card-body py-3">
                            <div class="row align-items-center g-3 text-center text-md-start">
                                <div class="col-6 col-md-3">
                                    <small class="text-white-50">Total Actes:</small>
                                    <div class="h5 mb-0" id="grand_total_procedures">0 F</div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <small class="text-white-50">Total Produits:</small>
                                    <div class="h5 mb-0" id="grand_total_products">0 F</div>
                                </div>
                                <div class="col-12 col-md-6 text-md-end">
                                    <h3 class="mb-0 text-warning">Total Général: <span id="total_general">0</span>
                                        FCFA</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer bg-white shadow-sm">
                <button type="button" class="btn btn-light px-4 border" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-success px-5 fw-bold" id="devis_save">
                    <i class="fas fa-save me-2"></i>ENREGISTRER LE DEVIS
                </button>
            </div>
        </div>
    </div>
</div>

<div id="autocomplete-suggestions"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let procedureIndex = 0;
        let productIndex = 0;
        const suggestionsBox = document.getElementById('autocomplete-suggestions');

        // --- AUTO-COMPLÉTION MÉDECIN ---
        $('#patient_id').on('change', function() {
            const medecin = $(this).find(':selected').data('medecin');
            $('#medecin_r_display').val(medecin || 'Non spécifié');
        });

        // --- AJOUTER UN ACTE ---
        document.getElementById('ajouter_procedure').addEventListener('click', function() {
            const container = document.getElementById('procedures_container');
            const html = `
            <div class="row g-2 mb-2 align-items-center border-bottom pb-2 mx-0 procedure-row bg-white shadow-sm p-1">
                <div class="col-md-6">
                    <input type="text" name="ligneDevi[proc_${procedureIndex}][element]" class="form-control form-control-sm border-0 bg-light" placeholder="Désignation de l'acte" required>
                    <input type="hidden" name="ligneDevi[proc_${procedureIndex}][type]" value="procedure">
                </div>
                <div class="col-3 col-md-2">
                    <input type="number" name="ligneDevi[proc_${procedureIndex}][quantite]" class="form-control form-control-sm text-center qty-input" value="1" min="1">
                </div>
                <div class="col-4 col-md-2">
                    <input type="number" name="ligneDevi[proc_${procedureIndex}][prix_u]" class="form-control form-control-sm text-end price-input" placeholder="0">
                </div>
                <div class="col-3 col-md-1 text-end fw-bold subtotal-line text-primary">0 F</div>
                <div class="col-2 col-md-1 text-center">
                    <button type="button" class="btn btn-link text-danger remove-line p-0"><i class="fas fa-trash-alt"></i></button>
                </div>
            </div>`;
            container.insertAdjacentHTML('beforeend', html);
            procedureIndex++;
            updateCounts();
        });

        // --- AJOUTER UN PRODUIT ---
        document.getElementById('ajouter_product').addEventListener('click', function() {
            const container = document.getElementById('products_container');
            const html = `
            <div class="row g-2 mb-2 align-items-center border-bottom pb-2 mx-0 product-row bg-white shadow-sm p-1">
                <div class="col-md-5 position-relative">
                    <input type="text" class="form-control form-control-sm autocomplete-product border-0 bg-light" placeholder="Rechercher consommable..." autocomplete="off" required>
                    <input type="hidden" name="ligneDevi[p_${productIndex}][produit_id]" class="product-id-hidden">
                    <input type="hidden" name="ligneDevi[p_${productIndex}][element]" class="product-name-hidden">
                    <input type="hidden" name="ligneDevi[p_${productIndex}][type]" value="material">
                </div>
                <div class="col-md-2 text-center">
                    <span class="badge bg-light text-dark stock-badge">Stock: -</span>
                </div>
                <div class="col-3 col-md-1">
                    <input type="number" name="ligneDevi[p_${productIndex}][quantite]" class="form-control form-control-sm text-center qty-input" value="1" min="1">
                </div>
                <div class="col-4 col-md-2">
                    <input type="number" name="ligneDevi[p_${productIndex}][prix_u]" class="form-control form-control-sm text-end price-input" readonly placeholder="0">
                </div>
                <div class="col-3 col-md-1 text-end fw-bold subtotal-line text-success">0 F</div>
                <div class="col-2 col-md-1 text-center">
                    <button type="button" class="btn btn-link text-danger remove-line p-0"><i class="fas fa-trash-alt"></i></button>
                </div>
            </div>`;
            container.insertAdjacentHTML('beforeend', html);
            productIndex++;
            updateCounts();
        });

        // --- LOGIQUE AUTOCOMPLETE AJAX ---
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('autocomplete-product')) {
                const input = e.target;
                const query = input.value;
                const parentRow = input.closest('.product-row');

                if (query.length < 2) {
                    suggestionsBox.style.display = 'none';
                    return;
                }

                fetch(`{{ route('api.produits.search') }}?q=${query}`)
                    .then(res => res.json())
                    .then(data => {
                        suggestionsBox.innerHTML = '';
                        if (data.length > 0) {
                            const rect = input.getBoundingClientRect();
                            suggestionsBox.style.cssText =
                                `display:block; top:${rect.bottom + window.scrollY}px; left:${rect.left}px; width:${rect.width}px;`;

                            data.forEach(item => {
                                const div = document.createElement('div');
                                div.className = 'suggestion-item';
                                div.innerHTML =
                                    `<div><strong>${item.designation}</strong></div><small class="text-muted">Prix: ${item.prix_unitaire} F | Stock: ${item.qte_stock}</small>`;
                                div.onclick = function() {
                                    input.value = item.designation;
                                    parentRow.querySelector('.product-id-hidden')
                                        .value = item.id;
                                    parentRow.querySelector('.product-name-hidden')
                                        .value = item.designation;
                                    parentRow.querySelector('.price-input').value = item
                                        .prix_unitaire;
                                    parentRow.querySelector('.stock-badge')
                                        .textContent = `Stock: ${item.qte_stock}`;
                                    parentRow.querySelector('.stock-badge').className =
                                        item.qte_stock > 0 ? 'badge bg-success' :
                                        'badge bg-danger';
                                    suggestionsBox.style.display = 'none';
                                    calculateAll();
                                };
                                suggestionsBox.appendChild(div);
                            });
                        } else {
                            suggestionsBox.style.display = 'none';
                        }
                    });
            }
        });

        // --- CALCULS ---
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('qty-input') || e.target.classList.contains(
                'price-input') || ['nbr_chambre', 'nbr_visite', 'nbr_ami_jour'].includes(e.target.id)) {
                calculateAll();
            }
        });

        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-line')) {
                e.target.closest('.row').remove();
                calculateAll();
                updateCounts();
            }
            if (!e.target.closest('.autocomplete-product')) suggestionsBox.style.display = 'none';
        });

        function calculateAll() {
            let totalProc = 0,
                totalProd = 0,
                totalHosp = 0;

            document.querySelectorAll('.procedure-row').forEach(row => {
                const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
                const price = parseFloat(row.querySelector('.price-input').value) || 0;
                const sub = qty * price;
                row.querySelector('.subtotal-line').textContent = sub.toLocaleString() + ' F';
                totalProc += sub;
            });

            document.querySelectorAll('.product-row').forEach(row => {
                const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
                const price = parseFloat(row.querySelector('.price-input').value) || 0;
                const sub = qty * price;
                row.querySelector('.subtotal-line').textContent = sub.toLocaleString() + ' F';
                totalProd += sub;
            });

            ['chambre', 'visite', 'ami_jour'].forEach(id => {
                const nbr = parseFloat(document.getElementById('nbr_' + id).value) || 0;
                const pu = parseFloat(document.getElementById('pu_' + id).value) || 0;
                const res = nbr * pu;
                document.getElementById('prix_' + id).textContent = res.toLocaleString();
                totalHosp += res;
            });

            document.getElementById('grand_total_procedures').textContent = totalProc.toLocaleString() + ' F';
            document.getElementById('grand_total_products').textContent = totalProd.toLocaleString() + ' F';
            document.getElementById('total_hospitalisation').textContent = totalHosp.toLocaleString();
            document.getElementById('total_general').textContent = (totalProc + totalProd + totalHosp)
                .toLocaleString();
        }

        function updateCounts() {
            document.getElementById('procedures_count').textContent = document.querySelectorAll(
                '.procedure-row').length;
            document.getElementById('products_count').textContent = document.querySelectorAll('.product-row')
                .length;
        }

        // --- ENREGISTREMENT ---
        document.getElementById('devis_save').addEventListener('click', function() {
            const form = document.getElementById('devis_form');
            if (form.checkValidity()) {
                form.submit();
            } else {
                form.reportValidity();
            }
        });
    });
</script>
