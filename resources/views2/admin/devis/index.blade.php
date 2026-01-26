@extends('layouts.admin')

@section('title', 'CMCU | Liste des devis')

@section('content')

<body>
    {{--<div class="se-pre-con"></div>--}}
    <div class="wrapper">
        @include('partials.side_bar')

        <!-- Page Content Holder -->
        @include('partials.header')
        <!--// top-bar -->
        @can('create', \App\Models\Patient::class)
        <div class="container">
            <h1 class="text-center">LISTE DES DEVIS</h1>
        </div>
        <hr>
        <div class="container pt-3">
            <div class="row">
                <div class="col-sm-12 panneau_d_affichage">
                    <div class="table-responsive">
                        <!--  -->
                        <table id="myTable" class="table table-bordered table-hover w-100">
                            <thead>
                                <tr>
                                    <th>NOM</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($devis as $devi)
                                <tr>
                                    <td>{{ $devi->nom}}</td>
                                    <td>
                                        @can('print', \App\Models\Devi::class)
                                        <button type="button" 
                                        data-devi='@json($devi)' 
                                        data-champ_patient="" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#imprimer_devis" 
                                        data-title="Impression devis ..." 
                                        data-texte="Vous pouvez effectuez des modifications si nécessaire." 
                                        class="btn btn-primary btn-sm me-1" 
                                        title="Attribuer le devis à un patient">
                                            <i class="fas fa-eye"></i></button>
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
            <button type="button" data-bs-toggle="modal" data-bs-target="#imprimer_devis" data-title="Nouveau devis ..." data-texte="" class="btn btn-primary me-1" title="Vous allez ajouter un nouveau devis" data-champ_patient="d-none">Nouveau</button>
        </div>
        @endcan

    </div>
    <!-- The Modal -->
    <div class="modal fade" id="imprimer_devis" tabindex="-1" aria-labelledby="imprimerDevisLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" id="imprimerDevisLabel"></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>


                <!-- Modal body -->
                <div class="modal-body">
                    <div>
                        <p class="text-success description my-2"></p>
                        <form id="devis_form" action="" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-sm-4 champ_patient">
                                    <label for="patient" class="form-label">Nom du patient :</label>
                                    <select class="form-select" id="patient" name="patient">
                                        @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}">{{ $patient->name.' '.$patient->prenom }}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" class="form-control d-none" id="patient_input">
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
                            <div class="row nom_devis">
                                @can('update', \App\Models\Devi::class)
                                <div class="col-4 mb-3">
                                    <label for="nom_devis" class="form-label">Devis de :</label>
                                    <input type="text" name="nom_devis" class="form-control" id="nom_devis" required>
                                </div>
                                <div class="col-4 mb-3">
                                    <label for="code_devis" class="form-label">Code :</label>
                                    <input type="text" name="code_devis" class="form-control" id="code_devis" required>
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
                                    <input type="text" name="code_devis" class="form-control" id="code_devis" required>
                                </div>
                                @endcan
                            </div>
                            <div class="container">
                                <div class="row my-2">
                                    <div class="col-sm-1 text-center" style="background-color:lavender;">
                                        <small>#</small>
                                    </div>
                                    <div class="col-sm-4" style="background-color:lavenderblush;">
                                        <strong>Elément</strong>
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
                                <div class="row my-2 ajouter_ligne">
                                    <div class="col-sm-12 text-center">
                                        <button type="button" class="btn text-primary btn-outline-info float-start">
                                            <i class="fa fa-plus-circle"></i>
                                        </button>
                                        <p class="float-end total1 text-danger">Total 1: <strong>0</strong> FCFA</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 ps-0 mt-2">
                                        <div class="form-check ms-4">
                                            <input class="form-check-input" type="checkbox" id="hospitalisation" value="">
                                            <label class="form-check-label text-primary" for="hospitalisation">Hospitalisation</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row my-2 hospitalisation d-none">
                                    <div class="col-sm-1 justify-content-center d-flex align-items-center" style="background-color:lavender;">
                                        <small>1</small>
                                    </div>
                                    <div class="col-sm-4" style="background-color:lavenderblush;">
                                        <input type="text" name="" class="form-control element" value="Chambre" readonly>
                                    </div>
                                    <div class="col-sm-2" style="background-color:lavender;">
                                        <input type="number" name="nbr_chambre" id="nbr_chambre" class="form-control" value=0>
                                    </div>
                                    <div class="col-sm-2" style="background-color:lavenderblush;">
                                        <input type="number" name="pu_chambre" class="form-control" id="pu_chambre" value=30000 required>
                                    </div>
                                    <div class="col-sm-2" style="background-color:lavender;">
                                        <input type="number" id="chambre" name="chambre" value=0 class="form-control">
                                    </div>
                                    <div class="col-sm-1 p-0 d-flex align-items-center" style="background-color:lavenderblush;">
                                       
                                    </div>
                                </div>
                                <div class="row hospitalisation d-none my-2">
                                    <div class="col-sm-1 justify-content-center d-flex align-items-center" style="background-color:lavender;">
                                        <small>2</small>
                                    </div> 
                                    <div class="col-sm-4" style="background-color:lavenderblush;">
                                        <input type="text" name="" class="form-control element" readonly value="Visite">
                                    </div>
                                    <div class="col-sm-2" style="background-color:lavender;">
                                        <input type="number" id="nbr_visite" name="nbr_visite" class="form-control" value=0>
                                    </div>
                                    <div class="col-sm-2" style="background-color:lavenderblush;">
                                        <input type="number" name="pu_visite" class="form-control" id="pu_visite" value=10000 required>
                                    </div>
                                    <div class="col-sm-2" style="background-color:lavender;">
                                        <input type="number" name="visite" id="visite" value=0 class="form-control">
                                    </div>
                                    <div class="col-sm-1 p-0 d-flex align-items-center" style="background-color:lavenderblush;">
                                       
                                    </div>
                                </div>
                                <div class="row hospitalisation d-none my-2">
                                    <div class="col-sm-1 justify-content-center d-flex align-items-center" style="background-color:lavender;">
                                        <small>3</small>
                                    </div>
                                    <div class="col-sm-4" style="background-color:lavenderblush;">
                                        <input type="text" name="" class="form-control element" value="AMI-JOUR (750*12)" readonly>
                                    </div>
                                    <div class="col-sm-2" style="background-color:lavender;">
                                        <input type="number" id="nbr_ami_jour" name="nbr_ami_jour" class="form-control" value=0>
                                    </div>
                                    <div class="col-sm-2" style="background-color:lavenderblush;">
                                        <input type="number" name="pu_ami_jour" class="form-control" id="pu_ami_jour" value=9000 required>
                                    </div>
                                    <div class="col-sm-2" style="background-color:lavender;">
                                        <input type="number" id="ami_jour" name="ami_jour" value=0 class="form-control">
                                    </div>
                                    <div class="col-sm-1 p-0 d-flex align-items-center" style="background-color:lavenderblush;">
                                        
                                    </div>
                                </div>
                                <div class="row hospitalisation d-none my-2">
                                    <div class="col-sm-12 d-flex align-items-center justify-content-end">
                                        <p class="float-end total2 text-danger">Total 2: <strong>0</strong> FCFA</p>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <p class="float-end total">Total : <strong>0</strong> FCFA</p>
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
                        <button type="submit" class="btn btn-info devis_save" data-bs-dismiss="modal">Enregistrer</button>
                        @endcan
                        <button type="button" class="btn btn-danger float-end" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary float-end mx-3 devis_export" data-bs-dismiss="modal">Exporter</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endcan
</body>
@endsection

@section('script')
<script src="{{ asset('admin/js/devis/convert_chiffre_lettre.js') }}"></script>
<script>
    /**
     * Devis-specific JavaScript - runs after admin.blade.php has initialized DataTables
     */
    document.addEventListener('DOMContentLoaded', function () {
        // Wait for jQuery to be available
        if (!window.jQuery) {
            console.error('jQuery is not available for devis page scripts.');
            return;
        }

        const $ = window.jQuery;

        // CRITICAL: Do NOT initialize DataTables here - it's already done in admin.blade.php
        // We only add devis-specific functionality here

        // numerotation des lignes de devis
        function numeroLigne() {
            $(".ligne").each(function (index) {
                $(this).find('div>small').text(index);
                $(this).find('div>.element').attr('name', 'ligneDevi[' + index + '][element]');
                $(this).find('div>.quantite').attr('name', 'ligneDevi[' + index + '][quantite]');
                $(this).find('div>.prix_u').attr('name', 'ligneDevi[' + index + '][prix_u]');
            });
        }

        //calcul du total du devis
        function total() {
            let total = 0;
            $(".ligne").each(function () {
                total += parseInt($(this).find('div>.prix').val() || 0);
            });
            $('#imprimer_devis').find('.total1>strong').text(total);
            // Recalculate grand total (total1 + total2)
            totaux();
        }

        function total2(nbr_chambre, pu_chambre, nbr_visite, pu_visite, nbr_ami_jour, pu_ami_jour) {
            const prix_chambre = parseInt(nbr_chambre || 0) * parseInt(pu_chambre || 0);
            const prix_visite = parseInt(nbr_visite || 0) * parseInt(pu_visite || 0);
            const prix_ami_jour = parseInt(nbr_ami_jour || 0) * parseInt(pu_ami_jour || 0);
            $('#chambre').val(prix_chambre);
            $('#visite').val(prix_visite);
            $('#ami_jour').val(prix_ami_jour);
            return prix_chambre + prix_visite + prix_ami_jour;
        }

        function totaux() {
            $(".total>strong").text(
                parseInt($('.total2>strong').text() || 0) +
                parseInt($(".total1>strong").text() || 0)
            );
        }

        // Initial numbering
        numeroLigne();

        // Gestion de l'ouverture du modal (création / édition / impression)
        $("#imprimer_devis").on('show.bs.modal', function (e) {
            $(".ligne").remove(); // supprime les lignes chargées précédemment dans le formulaire du modal
            $('.ajouter_ligne').find('button').removeClass('d-none');
            $(this).find('.description').text($(e.relatedTarget).data('texte'));
            $(this).find('.modal-title').text($(e.relatedTarget).data('title'));
            $(this).find('.champ_patient').parent().addClass($(e.relatedTarget).data('champ_patient')); // rend le champ nom du patient visible ou pas
            let devi = $(e.relatedTarget).data('devi'); // charge le devis à imprimer ou modifier (vide si création d'un nouveau)

            // rendre les devis non modifiables
            let dnone = " d-none ";
            let ro = true;
            // Le gestionnaire et l'admin modifient tous les devis
            @can('update', \App\Models\Devi::class)
            dnone = "";
            ro = false;
            @endcan

            if (devi) { // modification (click sur le bouton dans la colonne "action")

                // Gestionnaire, secretaire et admin peuvent modifier les devis de type "acte"
                if (devi.acces === 'acte') {
                    dnone = "";
                    ro = false;
                }

                // Chargement des éléments du dévis selectionné dans le formulaire du modal
                devi.ligne_devis.forEach(ligneDevi => {
                    $(".ajouter_ligne").before(
                        '<div class="row ligne my-2">' +
                        ' <div class="col-sm-1 justify-content-center d-flex align-items-center" style="background-color:lavender;">' +
                        '<small></small>' +
                        ' </div>' +
                        ' <div class="col-sm-4" style="background-color:lavenderblush;">' +
                        '<input type="text" name="" class="form-control element" value="' + ligneDevi.element + '"  >' +
                        '</div>' +
                        '<div class="col-sm-2" style="background-color:lavender;">' +
                        ' <input type="number" name="" class="form-control quantite" value="' + ligneDevi.quantite + '" >' +
                        '</div>' +
                        '<div class="col-sm-2" style="background-color:lavenderblush;">' +
                        '<input type="number" name="" class="form-control prix_u" value="' + ligneDevi.prix_u + '" >' +
                        '</div>' +
                        '<div class="col-sm-2" style="background-color:lavender;">' +
                        '<input type="number" name="" class="form-control prix"  value="' + (ligneDevi.quantite * ligneDevi.prix_u) + '">' +
                        ' </div>' +
                        ' <div class="col-sm-1 p-0 d-flex align-items-center" style="background-color:lavenderblush;">' +
                        '<button class="btn  retirer_ligne m-auto  ' + dnone + ' text-danger"><i class="fa fa-minus-circle"></i></button>' +
                        '</div>' +
                        '</div>'
                    );
                });

                $('#hospitalisation').parent('.row').addClass(dnone);
                $('.ajouter_ligne').find('button').addClass(dnone);
                $('#nom_devis').val(devi.nom);
                $('#acces_devis').val(devi.acces);
                $('#code_devis').val(devi.code);
                $('#nbr_chambre').val(devi.nbr_chambre);
                $('#nbr_visite').val(devi.nbr_visite);
                $('#nbr_ami_jour').val(devi.nbr_ami_jour);
                $('#pu_chambre').val(devi.pu_chambre);
                $('#pu_ami_jour').val(devi.pu_ami_jour);
                $('#pu_visite').val(devi.pu_visite);
                $('.hospitalisation').find('input').attr("readonly", ro);

                // calcul total 2
                $('.total2>strong').text(
                    total2(
                        $("#nbr_chambre").val(),
                        $("#pu_chambre").val(),
                        $("#nbr_visite").val(),
                        $("#pu_visite").val(),
                        $("#nbr_ami_jour").val(),
                        $("#pu_ami_jour").val()
                    )
                );
                totaux();

                if (devi.nbr_chambre > 0) {
                    $('#hospitalisation').prop('checked', true);
                    $('.hospitalisation').removeClass('d-none');
                } else {
                    $('#hospitalisation').prop('checked', false);
                    $('.hospitalisation').addClass('d-none');
                }

                $('#nom_devis').attr("readonly", ro);
                $('#code_devis').attr("readonly", ro);
                $('.ligne').find('input').attr("readonly", ro);
                $('#devis_form').attr('action', "{{ asset('admin/devis/edit/') }}/" + devi.id);
                $('.devis_export').removeClass('d-none');
                $('.champ_patient>select').attr('required', 'required');
                numeroLigne();
                total();
            } else {
                // Création d'un nouveau devis
                $('#devis_form').attr('action', "{{ route('devis.store') }}");
                $('.devis_export').addClass('d-none');
                $('#nom_devis').val('');
                $('#code_devis').val('');
                $('#nbr_visite').val(0);
                $('#nbr_ami_jour').val(0);
                $('#nbr_chambre').val(0);
                $('#visite').val(0);
                $('#ami_jour').val(0);
                $('#chambre').val(0);
                $('#pu_chambre').val(30000);
                $('#pu_ami_jour').val(9000);
                $('#pu_visite').val(10000);
                $(".total2>strong").text('0');
                $(".total1>strong").text('0');
                $(".total>strong").text('0');
                $('#hospitalisation').prop('checked', false);
                $('.hospitalisation').addClass('d-none');
            }
        });

        $("#imprimer_devis").on('hide.bs.modal', function () {
            $(this).find('.champ_patient').parent().removeClass('d-none');
        });

        // ajout d'une nouvelle ligne devis
        $(".ajouter_ligne>div>button").on('click', function () {
            $(".ajouter_ligne").before(
                '<div class="row ligne my-2">' +
                ' <div class="col-sm-1 justify-content-center d-flex align-items-center" style="background-color:lavender;">' +
                '<small>#</small>' +
                ' </div>' +
                ' <div class="col-sm-4" style="background-color:lavenderblush;">' +
                '<input type="text" name="" class="form-control element">' +
                '</div>' +
                '<div class="col-sm-2" style="background-color:lavender;">' +
                ' <input type="number" name="" class="form-control quantite" value=0>' +
                '</div>' +
                '<div class="col-sm-2" style="background-color:lavenderblush;">' +
                '<input type="number" name="" class="form-control prix_u" value=0>' +
                '</div>' +
                '<div class="col-sm-2" style="background-color:lavender;">' +
                '<input type="number" name="" value=0 class="form-control prix">' +
                ' </div>' +
                ' <div class="col-sm-1 p-0 d-flex align-items-center" style="background-color:lavenderblush;">' +
                '<button class="btn  retirer_ligne m-auto text-danger"><i class="fa fa-minus-circle"></i></button>' +
                '</div>' +
                '</div>'
            );

            numeroLigne();
        });

        $("body").on('change', ".prix_u", function () {
            let qte = $(this).closest('.ligne').find('.quantite').val();
            let prix_u = $(this).val();
            $(this).closest('.ligne').find('.prix').val(qte * prix_u);
            total();
            totaux();
        });

        $("body").on('change', ".quantite", function () {
            let prix_u = $(this).closest('.ligne').find('.prix_u').val();
            let qte = $(this).val();
            $(this).closest('.ligne').find('.prix').val(qte * prix_u);
            total();
            totaux();
        });

        $("body").on('click', '.retirer_ligne', function (e) {
            e.preventDefault();
            $(this).closest('.ligne').remove();
            numeroLigne();
            total();
            totaux();
        });

        // permutation entre selection d'un nom et saisi d'un nouveau nom
        $('#saisir_nom').on('click', function () {
            if ($("#saisir_nom:checked").length) {
                $('.champ_patient>input').attr({
                    'required': true,
                    'name': 'patient'
                });
                $('.champ_patient>select').attr({
                    'required': false,
                    'name': ''
                });
                $('.champ_patient>input').removeClass("d-none");
                $('.champ_patient>select').addClass("d-none");
            } else {
                $('.champ_patient>input').attr({
                    'required': false,
                    'name': ''
                });
                $('.champ_patient>select').attr({
                    'required': true,
                    'name': 'patient'
                });
                $('.champ_patient>input').addClass("d-none");
                $('.champ_patient>select').removeClass("d-none");
            }
        });

        // soumission - edition
        $(".devis_save").on("click", function (e) {
            e.preventDefault();
            $('#devis_form').submit();
        });

        // soumission - impression
        $(".devis_export").on("click", function (e) {
            e.preventDefault();
            $('#devis_form')
                .attr('action', "{{ asset('admin/devis/export/') }}/" + NumberToLetter(parseInt($('.total>strong').text() || 0)))
                .submit();
        });

        // hospitalisation
        $('#hospitalisation').on('click', function () {
            if ($("#hospitalisation:checked").length) {
                $(".hospitalisation").removeClass('d-none');
            } else {
                $(".hospitalisation").addClass('d-none');
            }
        });

        $("body").on('change', "#nbr_chambre, #nbr_visite, #nbr_ami_jour, #pu_chambre , #pu_visite, #pu_ami_jour", function () {
            let nbr_chambre = $('#nbr_chambre').val();
            let nbr_visite = $('#nbr_visite').val();
            let nbr_ami_jour = $('#nbr_ami_jour').val();
            let pu_chambre = $('#pu_chambre').val();
            let pu_visite = $("#pu_visite").val();
            let pu_ami_jour = $("#pu_ami_jour").val();
            $('.total2>strong').text(total2(nbr_chambre, pu_chambre, nbr_visite, pu_visite, nbr_ami_jour, pu_ami_jour));
            totaux();
        });
    });
</script>
@stop




















