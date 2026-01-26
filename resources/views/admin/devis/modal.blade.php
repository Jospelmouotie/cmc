
<!-- Enhanced Main Devis Modal with Products -->
<div class="modal fade" id="devisModal" tabindex="-1" aria-labelledby="devisModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="devisModalLabel"></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="devis_form" action="{{ route('devis.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="devi_id" id="devi_id">
                    
                    <!-- Patient Selection -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="patient_id" class="form-label">Patient <span class="text-danger">*</span></label>
                            <select class="form-select" id="patient_id" name="patient_id" required>
                                <option value="">Sélectionnez un patient</option>
                                @foreach($patients as $patient)
                                <option value="{{ $patient->id }}" data-medecin="{{ $patient->medecin_r }}">
                                    {{ $patient->name }} {{ $patient->prenom }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-3">
                            <label for="nom_devis" class="form-label">Nom du devis <span class="text-danger">*</span></label>
                            <input type="text" name="nom_devis" class="form-control" id="nom_devis" required>
                        </div>
                        
                        <div class="col-md-3">
                            <label for="code_devis" class="form-label">Code</label>
                            <input type="text" name="code_devis" class="form-control" id="code_devis">
                            <small class="text-muted">Auto-généré si vide</small>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="acces_devis" class="form-label">Type <span class="text-danger">*</span></label>
                            <select class="form-select" id="acces_devis" name="acces_devis" required>
                                <option value="acte">Acte</option>
                                <option value="bloc">Bloc</option>
                            </select>
                        </div>
                        <div class="col-md-6 align-self-end">
                            <button type="button" class="btn btn-info btn-sm" id="import_patient_products">
                                <i class="fas fa-download me-1"></i>Importer les produits consommés
                            </button>
                        </div>
                    </div>

                    <!-- Tabs for Procedures and Products -->
                    <ul class="nav nav-tabs mb-3" id="devisTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="procedures-tab" data-bs-toggle="tab" data-bs-target="#procedures" type="button" role="tab">
                                <i class="fas fa-stethoscope me-1"></i>Elements <span class="badge bg-primary ms-2" id="procedures_count">0</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="products-tab" data-bs-toggle="tab" data-bs-target="#products" type="button" role="tab">
                                <i class="fas fa-pills me-1"></i>Produits <span class="badge bg-success ms-2" id="products_count">0</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="hospitalization-tab" data-bs-toggle="tab" data-bs-target="#hospitalization" type="button" role="tab">
                                <i class="fas fa-bed me-1"></i>Hospitalisation
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="devisTabsContent">
                        <!-- Procedures Tab -->
                        <div class="tab-pane fade show active" id="procedures" role="tabpanel">
                            <div class="container border rounded p-3 mb-3">
                                <div class="row mb-2">
                                    <div class="col-sm-1 text-center bg-light py-2"><small>#</small></div>
                                    <div class="col-sm-4 bg-light py-2"><strong>Élément</strong></div>
                                    <div class="col-sm-2 bg-light py-2"><strong>Quantité</strong></div>
                                    <div class="col-sm-2 bg-light py-2"><strong>Prix U.</strong></div>
                                    <div class="col-sm-2 bg-light py-2"><strong>Total</strong></div>
                                    <div class="col-sm-1 text-center bg-light py-2"><strong>Action</strong></div>
                                </div>
                                
                                <div id="procedures_container">
                                    <!-- Dynamic procedure lines -->
                                </div>
                                
                                <div class="row my-3">
                                    <div class="col-sm-12">
                                        <button type="button" class="btn btn-outline-info btn-sm" id="ajouter_procedure">
                                            <i class="fa fa-plus-circle"></i> Ajouter une procédure
                                        </button>
                                        <div class="float-end">
                                            <strong class="text-primary">Sous-total ELEMENTS: <span id="total_procedures">0</span> FCFA</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Products Tab -->
                        <div class="tab-pane fade" id="products" role="tabpanel">
                            <div class="container border rounded p-3 mb-3">
                                <div class="row mb-2">
                                    <div class="col-sm-1 text-center bg-light py-2"><small>#</small></div>
                                    <div class="col-sm-3 bg-light py-2"><strong>Produit</strong></div>
                                    <div class="col-sm-2 bg-light py-2"><strong>Type</strong></div>
                                    <div class="col-sm-1 bg-light py-2"><strong>Stock</strong></div>
                                    <div class="col-sm-1 bg-light py-2"><strong>Qté</strong></div>
                                    <div class="col-sm-2 bg-light py-2"><strong>Prix U.</strong></div>
                                    <div class="col-sm-1 bg-light py-2"><strong>Total</strong></div>
                                    <div class="col-sm-1 text-center bg-light py-2"><strong>Action</strong></div>
                                </div>
                                
                                <div id="products_container">
                                    <!-- Dynamic product lines -->
                                </div>
                                
                                <div class="row my-3">
                                    <div class="col-sm-12">
                                        <button type="button" class="btn btn-outline-success btn-sm" id="ajouter_product">
                                            <i class="fa fa-plus-circle"></i> Ajouter un produit
                                        </button>
                                        <div class="float-end">
                                            <strong class="text-success">Sous-total produits: <span id="total_products">0</span> FCFA</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hospitalization Tab -->
                        <div class="tab-pane fade" id="hospitalization" role="tabpanel">
                            <div class="container border rounded p-3 mb-3">
                                <div class="row mb-2">
                                    <div class="col-sm-1 text-center bg-light py-2"><small>#</small></div>
                                    <div class="col-sm-5 bg-light py-2"><strong>Type</strong></div>
                                    <div class="col-sm-2 bg-light py-2"><strong>Quantité</strong></div>
                                    <div class="col-sm-2 bg-light py-2"><strong>Prix U.</strong></div>
                                    <div class="col-sm-2 bg-light py-2"><strong>Total</strong></div>
                                </div>
                                
                                <div class="row mb-2">
                                    <div class="col-sm-1 text-center align-self-center"><small>1</small></div>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control-plaintext" value="Chambre" readonly>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="number" name="nbr_chambre" id="nbr_chambre" class="form-control" value="0" min="0">
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="number" name="pu_chambre" class="form-control" id="pu_chambre" value="30000" min="0">
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" id="prix_chambre" class="form-control" value="0" readonly>
                                    </div>
                                </div>
                                
                                <div class="row mb-2">
                                    <div class="col-sm-1 text-center align-self-center"><small>2</small></div>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control-plaintext" value="Visite" readonly>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="number" id="nbr_visite" name="nbr_visite" class="form-control" value="0" min="0">
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="number" name="pu_visite" class="form-control" id="pu_visite" value="10000" min="0">
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" id="prix_visite" class="form-control" value="0" readonly>
                                    </div>
                                </div>
                                
                                <div class="row mb-2">
                                    <div class="col-sm-1 text-center align-self-center"><small>3</small></div>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control-plaintext" value="AMI-JOUR (750*12)" readonly>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="number" id="nbr_ami_jour" name="nbr_ami_jour" class="form-control" value="0" min="0">
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="number" name="pu_ami_jour" class="form-control" id="pu_ami_jour" value="9000" min="0">
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" id="prix_ami_jour" class="form-control" value="0" readonly>
                                    </div>
                                </div>
                                
                                <div class="row mt-2 pt-2 border-top">
                                    <div class="col-sm-12 text-end">
                                        <strong class="text-info">Sous-total hospitalisation: <span id="total_hospitalisation">0</span> FCFA</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Grand Total -->
                    <div class="row mt-3 pt-3 border-top">
                        <div class="col-12">
                            <div class="alert alert-success mb-0">
                                <div class="row">
                                    <div class="col-md-4">
                                        <small>Procédures:</small><br>
                                        <strong><span id="grand_total_procedures">0</span> FCFA</strong>
                                    </div>
                                    <div class="col-md-4">
                                        <small>Produits:</small><br>
                                        <strong><span id="grand_total_products">0</span> FCFA</strong>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <h5 class="mb-0">Total Général: <span id="total_general">0</span> FCFA</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                @can('update', \App\Models\Devi::class)
                <button type="button" class="btn btn-info" id="devis_save">Enregistrer</button>
                @endcan
                <button type="button" class="btn btn-primary" id="devis_export">Exporter PDF</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<!-- Autocomplete suggestions container -->
<div id="autocomplete-suggestions" class="list-group position-absolute" style="z-index: 9999; display: none; max-height: 300px; overflow-y: auto;"></div>