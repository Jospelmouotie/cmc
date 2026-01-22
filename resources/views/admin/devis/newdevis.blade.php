@extends('layouts.admin')

@section('title', 'CMCU | Liste des devis')

@section('content')

<style>
    /* Typeahead/Autocomplete Styles */
    .tt-menu {
        width: 100%;
        margin: 2px 0;
        padding: 8px 0;
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 4px;
        max-height: 300px;
        overflow-y: auto;
        box-shadow: 0 5px 10px rgba(0, 0, 0, .2);
        z-index: 1050;
    }

    .tt-suggestion {
        padding: 8px 12px;
        cursor: pointer;
        font-size: 14px;
    }

    .tt-suggestion:hover,
    .tt-suggestion.tt-cursor {
        background-color: #0097cf;
        color: #fff;
    }

    .tt-suggestion .produit-nom {
        font-weight: 500;
    }

    .tt-suggestion .produit-categorie {
        font-size: 11px;
        color: #666;
        margin-left: 8px;
    }

    .tt-suggestion:hover .produit-categorie {
        color: #fff;
    }

    .autocomplete-wrapper {
        position: relative;
    }
</style>

<body>
    <div class="wrapper">
        @include('partials.side_bar')
        @include('partials.header')

        @can('create', \App\Models\Patient::class)
        <div class="container">
            <h1 class="text-center">LISTE DES DEVIS</h1>
        </div>
        <hr>
        
        <div class="container pt-3">
            <div class="row">
                <div class="col-sm-12 panneau_d_affichage">
                    <div class="table-responsive">
                        @include('partials.flash')
                        <table id="myTable" class="table table-bordered table-hover w-100">
                            <thead>
                                <tr>
                                    <th>NOM</th>
                                    <th>CODE</th>
                                    <th>TYPE</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($devis as $devi)
                                <tr>
                                    <td>{{ $devi->nom}}</td>
                                    <td>{{ $devi->code }}</td>
                                    <td><span class="badge bg-{{ $devi->acces === 'acte' ? 'info' : 'primary' }}">{{ strtoupper($devi->acces) }}</span></td>
                                    <td>
                                        @can('print', \App\Models\Devi::class)
                                        <button type="button" 
                                            data-devi='@json($devi)' 
                                            data-champ_patient="" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#imprimer_devis" 
                                            data-title="Impression devis - {{ $devi->nom }}" 
                                            data-texte="Vous pouvez effectuer des modifications si nécessaire." 
                                            class="btn btn-sm btn-info me-1" 
                                            title="Attribuer le devis à un patient">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @can('create', \App\Models\Devi::class)
        <div class="text-center table_link_right">
            <button type="button" 
                data-bs-toggle="modal" 
                data-bs-target="#imprimer_devis" 
                data-title="Nouveau devis" 
                data-texte="Créez un nouveau devis personnalisé" 
                class="btn btn-primary me-1" 
                title="Ajouter un nouveau devis" 
                data-champ_patient="d-none">
                <i class="fas fa-plus"></i> Nouveau
            </button>
        </div>
        @endcan

    </div>

    <!-- Modal Devis -->
    <div class="modal fade" id="imprimer_devis" tabindex="-1" aria-labelledby="imprimerDevisLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="imprimerDevisLabel"></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div>
                        <p class="text-success description my-2"></p>
                        <form id="devis_form" action="" method="POST">
                            @csrf
                            
                            <!-- Patient Selection -->
                            <div class="row">
                                <div class="col-sm-4 champ_patient">
                                    <label for="patient" class="form-label">Nom du patient :</label>
                                    <select class="form-select" id="patient" name="patient">
                                        @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}">{{ $patient->name.' '.$patient->prenom }}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" class="form-control d-none" id="patient_input" name="patient">
                                    <br>
                                </div>
                                <div class="col-sm-4 d-flex align-items-center">
                                    <div class="form-check ms-4">
                                        <input class="form-check-input" type="checkbox" id="saisir_nom" value="">
                                        <label class="form-check-label" for="saisir_nom">Saisir le nom</label>
                                    </div>
                                </div>
                                <div class="col-sm-4"></div>
                            </div>

                            <!-- Devis Information -->
                            <div class="row nom_devis">
                                @can('update', \App\Models\Devi::class)
                                <div class="col-4 mb-3">
                                    <label for="nom_devis" class="form-label">Devis de :</label>
                                    <input type="text" name="nom_devis" class="form-control" id="nom_devis" required>
                                </div>
                                <div class="col-4 mb-3">
                                    <label for="code_devis" class="form-label">Code :</label>
                                    <input type="text" name="code_devis" class="form-control" id="code_devis">
                                </div>
                                <div class="col-4 mb-3">
                                    <label for="acces_devis" class="form-label">Type :</label>
                                    <select class="form-select" id="acces_devis" name="acces_devis">
                                        <option value="acte">Acte</option>
                                        <option value="bloc">Bloc</option>
                                    </select>
                                </div>
                                @elsecan('print', \App\Models\Devi::class)
                                <div class="col-8 mb-3">
                                    <label for="nom_devis" class="form-label">Devis de :</label>
                                    <input type="text" name="nom_devis" class="form-control" id="nom_devis" required>
                                </div>
                                <div class="col-4 mb-3">
                                    <label for="code_devis" class="form-label">Code :</label>
                                    <input type="text" name="code_devis" class="form-control" id="code_devis">
                                </div>
                                @endcan
                            </div>

                            <!-- Line Items Header -->
                            <div class="container">
                                <div class="row my-2">
                                    <div class="col-sm-1 text-center" style="background-color:lavender;">
                                        <small>#</small>
                                    </div>
                                    <div class="col-sm-4" style="background-color:lavenderblush;">
                                        <strong>Élément</strong>
                                    </div>
                                    <div class="col-sm-2" style="background-color:lavender;">
                                        <strong>Quantité</strong>
                                    </div>
                                    <div class="col-sm-2" style="background-color:lavenderblush;">
                                        <strong>Prix U.</strong>
                                    </div>
                                    <div class="col-sm-2" style="background-color:lavender;">
                                        <strong>Prix</strong>
                                    </div>
                                    <div class="col-sm-1 text-center p-0" style="background-color:lavenderblush;">
                                        <strong>Sup</strong>
                                    </div>
                                </div>

                                <!-- Add Line Button -->
                                <div class="row my-2 ajouter_ligne">
                                    <div class="col-sm-12 text-center">
                                        <button type="button" class="btn text-primary btn-outline-info float-start">
                                            <i class="fa fa-plus-circle"></i> Ajouter une ligne
                                        </button>
                                        <p class="float-end total1 text-danger">Total 1: <strong>0</strong> FCFA</p>
                                    </div>
                                </div>

                                <!-- Hospitalization Section -->
                                <div class="row">
                                    <div class="col-12 ps-0 mt-2">
                                        <div class="form-check ms-4">
                                            <input class="form-check-input" type="checkbox" id="hospitalisation" value="">
                                            <label class="form-check-label text-primary" for="hospitalisation">
                                                <strong>Hospitalisation</strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row my-2 hospitalisation d-none">
                                    <div class="col-sm-1 justify-content-center d-flex align-items-center" style="background-color:lavender;">
                                        <small>1</small>
                                    </div>
                                    <div class="col-sm-4" style="background-color:lavenderblush;">
                                        <input type="text" class="form-control element" value="Chambre" readonly>
                                    </div>
                                    <div class="col-sm-2" style="background-color:lavender;">
                                        <input type="number" name="nbr_chambre" id="nbr_chambre" class="form-control" value="0" min="0">
                                    </div>
                                    <div class="col-sm-2" style="background-color:lavenderblush;">
                                        <input type="number" name="pu_chambre" class="form-control" id="pu_chambre" value="30000" required min="0">
                                    </div>
                                    <div class="col-sm-2" style="background-color:lavender;">
                                        <input type="number" id="chambre" name="chambre" value="0" class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-1 p-0 d-flex align-items-center" style="background-color:lavenderblush;"></div>
                                </div>

                                <div class="row hospitalisation d-none my-2">
                                    <div class="col-sm-1 justify-content-center d-flex align-items-center" style="background-color:lavender;">
                                        <small>2</small>
                                    </div>
                                    <div class="col-sm-4" style="background-color:lavenderblush;">
                                        <input type="text" class="form-control element" readonly value="Visite">
                                    </div>
                                    <div class="col-sm-2" style="background-color:lavender;">
                                        <input type="number" id="nbr_visite" name="nbr_visite" class="form-control" value="0" min="0">
                                    </div>
                                    <div class="col-sm-2" style="background-color:lavenderblush;">
                                        <input type="number" name="pu_visite" class="form-control" id="pu_visite" value="10000" required min="0">
                                    </div>
                                    <div class="col-sm-2" style="background-color:lavender;">
                                        <input type="number" name="visite" id="visite" value="0" class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-1 p-0 d-flex align-items-center" style="background-color:lavenderblush;"></div>
                                </div>

                                <div class="row hospitalisation d-none my-2">
                                    <div class="col-sm-1 justify-content-center d-flex align-items-center" style="background-color:lavender;">
                                        <small>3</small>
                                    </div>
                                    <div class="col-sm-4" style="background-color:lavenderblush;">
                                        <input type="text" class="form-control element" value="AMI-JOUR (750*12)" readonly>
                                    </div>
                                    <div class="col-sm-2" style="background-color:lavender;">
                                        <input type="number" id="nbr_ami_jour" name="nbr_ami_jour" class="form-control" value="0" min="0">
                                    </div>
                                    <div class="col-sm-2" style="background-color:lavenderblush;">
                                        <input type="number" name="pu_ami_jour" class="form-control" id="pu_ami_jour" value="9000" required min="0">
                                    </div>
                                    <div class="col-sm-2" style="background-color:lavender;">
                                        <input type="number" id="ami_jour" name="ami_jour" value="0" class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-1 p-0 d-flex align-items-center" style="background-color:lavenderblush;"></div>
                                </div>

                                <div class="row hospitalisation d-none my-2">
                                    <div class="col-sm-12 d-flex align-items-center justify-content-end">
                                        <p class="float-end total2 text-danger">Total 2: <strong>0</strong> FCFA</p>
                                    </div>
                                </div>

                                <!-- Grand Total -->
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <p class="float-end total text-primary"><strong>Total : <span>0</span> FCFA</strong></p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer px-0">
                    <div class="col-12">
                        @can('update', \App\Models\Devi::class)
                        <button type="button" class="btn btn-info devis_save">
                            <i class="fas fa-save"></i> Enregistrer
                        </button>
                        @endcan
                        <button type="button" class="btn btn-danger float-end" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i> Annuler
                        </button>
                        <button type="button" class="btn btn-primary float-end mx-3 devis_export">
                            <i class="fas fa-file-pdf"></i> Exporter PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endcan
</body>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
<script src="{{ asset('admin/js/devis/convert_chiffre_lettre.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (!window.jQuery) {
        console.error('jQuery is not available');
        return;
    }

    const $ = window.jQuery;

    // ==========================================
    // AUTOCOMPLETE SETUP (Typeahead.js)
    // ==========================================
    
    /**
     * Initialize autocomplete for a given element input field
     */
    function initAutocomplete($input) {
        // Destroy existing typeahead if any
        if ($input.data('ttTypeahead')) {
            $input.typeahead('destroy');
        }

        // Initialize Typeahead with Bloodhound engine
        const produitsEngine = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('nom'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: '{{ route("devis.autocomplete") }}?query=%QUERY',
                wildcard: '%QUERY',
                transform: function(response) {
                    return response;
                }
            }
        });

        $input.typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            name: 'produits',
            display: 'nom',
            source: produitsEngine,
            limit: 15,
            templates: {
                empty: '<div class="tt-suggestion">Aucun produit trouvé</div>',
                suggestion: function(data) {
                    return '<div>' +
                        '<span class="produit-nom">' + data.nom + '</span>' +
                        '<span class="produit-categorie">(' + (data.categorie || 'Autre') + ')</span>' +
                        '</div>';
                }
            }
        }).on('typeahead:select', function(ev, suggestion) {
            // When a product is selected, optionally fill the price
            const $row = $(this).closest('.ligne');
            if (suggestion.prix_reference && suggestion.prix_reference > 0) {
                $row.find('.prix_u').val(suggestion.prix_reference);
                calculateLineTotal($row);
            }
        });
    }

    // ==========================================
    // LINE ITEM MANAGEMENT
    // ==========================================

    /**
     * Renumber all line items
     */
    function numeroLigne() {
        $(".ligne").each(function (index) {
            $(this).find('div>small').text(index + 1);
            $(this).find('div>.element').attr('name', 'ligneDevi[' + index + '][element]');
            $(this).find('div>.quantite').attr('name', 'ligneDevi[' + index + '][quantite]');
            $(this).find('div>.prix_u').attr('name', 'ligneDevi[' + index + '][prix_u]');
        });
    }

    /**
     * Calculate total for a single line
     */
    function calculateLineTotal($row) {
        const quantite = parseInt($row.find('.quantite').val() || 0);
        const prix_u = parseInt($row.find('.prix_u').val() || 0);
        $row.find('.prix').val(quantite * prix_u);
        total(); // Recalculate grand total
    }

    /**
     * Calculate total of all line items (Total 1)
     */
    function total() {
        let total = 0;
        $(".ligne").each(function () {
            total += parseInt($(this).find('div>.prix').val() || 0);
        });
        $('#imprimer_devis').find('.total1>strong').text(total);
        totaux(); // Update grand total
    }

    /**
     * Calculate hospitalization total (Total 2)
     */
    function total2(nbr_chambre, pu_chambre, nbr_visite, pu_visite, nbr_ami_jour, pu_ami_jour) {
        const prix_chambre = parseInt(nbr_chambre || 0) * parseInt(pu_chambre || 0);
        const prix_visite = parseInt(nbr_visite || 0) * parseInt(pu_visite || 0);
        const prix_ami_jour = parseInt(nbr_ami_jour || 0) * parseInt(pu_ami_jour || 0);
        
        $('#chambre').val(prix_chambre);
        $('#visite').val(prix_visite);
        $('#ami_jour').val(prix_ami_jour);
        
        return prix_chambre + prix_visite + prix_ami_jour;
    }

    /**
     * Calculate grand total (Total 1 + Total 2)
     */
    function totaux() {
        const total1 = parseInt($('.total1>strong').text() || 0);
        const total2 = parseInt($('.total2>strong').text() || 0);
        $(".total>span").text(total1 + total2);
    }

    // ==========================================
    // MODAL HANDLING
    // ==========================================

    $("#imprimer_devis").on('show.bs.modal', function (e) {
        $(".ligne").remove(); // Clear previous lines
        $('.ajouter_ligne').find('button').removeClass('d-none');
        
        $(this).find('.description').text($(e.relatedTarget).data('texte'));
        $(this).find('.modal-title').text($(e.relatedTarget).data('title'));
        $(this).find('.champ_patient').parent().addClass($(e.relatedTarget).data('champ_patient'));
        
        let devi = $(e.relatedTarget).data('devi');

        let dnone = " d-none ";
        let ro = true;

        @can('update', \App\Models\Devi::class)
        dnone = "";
        ro = false;
        @endcan

        if (devi) { // EDIT MODE
            if (devi.acces === 'acte') {
                dnone = "";
                ro = false;
            }

            // Load existing line items
            devi.ligne_devis.forEach(ligneDevi => {
                $(".ajouter_ligne").before(
                    '<div class="row ligne my-2">' +
                    '<div class="col-sm-1 justify-content-center d-flex align-items-center" style="background-color:lavender;"><small></small></div>' +
                    '<div class="col-sm-4 autocomplete-wrapper" style="background-color:lavenderblush;">' +
                        '<input type="text" name="" class="form-control element typeahead" value="' + ligneDevi.element + '" ' + (ro ? 'readonly' : '') + '>' +
                    '</div>' +
                    '<div class="col-sm-2" style="background-color:lavender;">' +
                        '<input type="number" name="" class="form-control quantite" value="' + ligneDevi.quantite + '" min="0" ' + (ro ? 'readonly' : '') + '>' +
                    '</div>' +
                    '<div class="col-sm-2" style="background-color:lavenderblush;">' +
                        '<input type="number" name="" class="form-control prix_u" value="' + ligneDevi.prix_u + '" min="0" ' + (ro ? 'readonly' : '') + '>' +
                    '</div>' +
                    '<div class="col-sm-2" style="background-color:lavender;">' +
                        '<input type="number" class="form-control prix" value="' + (ligneDevi.quantite * ligneDevi.prix_u) + '" readonly>' +
                    '</div>' +