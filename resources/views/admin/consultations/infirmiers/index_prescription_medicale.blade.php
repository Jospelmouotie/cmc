@extends('layouts.admin')

@section('title', 'CMCU | Prescriptions médicales')

@section('content')

<body>
    {{--<div class="se-pre-con"></div>--}}
    <div class="wrapper">
        @include('partials.side_bar')

        <!-- Page Content Holder -->
        @include('partials.header')
        <!--// top-bar -->
        @can('show', \App\Models\User::class)
        <div class="col-md-12  toppad  offset-md-0 ">
            <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-success float-end">
                <i class="fas fa-arrow-left"></i>  Retour au dossier patient
            </a>
        </div>
        <div class="container px-0">
            <h1 class="text-center">PRESCRIPTIONS MEDICALES</h1>
            
            <hr>
        </div>
        <div class="container">
            <div class="row">
                
                <div class="col-12 px-0">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="table-responsive">
                        <table id="myTable" class="table table-striped table-bordered table-hover dt-responsive display nowrap td-responsive" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>DATE</th>
                                    <th>MEDICAMENT</th>
                                    <th>POSOLOGIE</th>
                                    <th>Horaire</th>
                                    <th>VOIE</th> 
                                    <!--  -->
                                    <th>Administrations</th>
                                </tr>
                            <tbody>
                                @foreach ($fiche_prescription_medicale->prescription_medicales as $prescription_medicale)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($prescription_medicale->created_at)->format('d/m/Y - H:i') }}</td>
                                    <td>{{ $prescription_medicale->medicament }}</td>
                                    <td>{{ $prescription_medicale->posologie }}</td>
                                    <td>{{ implode(", ",json_decode($prescription_medicale->horaire)) }}</td>
                                    <td>{{ $prescription_medicale->voie }}</td>
                                    <td>
                                        <button title="Afficher la liste des soins administrés" class="btn btn_admin_prescription_medicale" data-bs-toggle="modal" data-bs-admin_list="{{ $prescription_medicale->adminPrescriptionMedicales}}" data-bs-target="#admin_prescription_medicale">Détails...</button>
                                        @can('infirmier', \App\Models\Patient::class)
                                        <button title="Saisir un nouveau soin" class="btn btn-primary btn-sm rounded-circle btn_admin_prescription_medicale_form" data-bs-toggle="modal" data-bs-prescription_medicale_id="{{ $prescription_medicale->id }}" data-bs-target="#admin_prescription_medicale_form"><i class="fas fa-plus"></i></button>
                                        @endcan
                                        @can('medecin', \App\Models\Patient::class)
                                        <a href="{{ route('prescription_medicale.edit', $prescription_medicale->id) }}?patient={{ $patient->id }}" class="btn btn-secondary btn-sm rounded-circle" title="Modifier la prescription"><i class="fas fa-edit"></i></a>
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @can('medecin', \App\Models\Patient::class)
                    <button type="button" class="btn btn-primary table_link_right" data-bs-toggle="modal" data-bs-target="#PrescriptionMedicale" data-bs-whatever="@mdo">
                        <i class="fas fa-plus"></i>
                        Nouveau enregistrement
                    </button>
                    @endcan
                </div>
            </div>
            <div class="row pt-4 mt-5 shadow mb-5 " style="background-color: rgba(0, 0, 0, 0.05)">
                <div class="col-2 ">
                    <img src="{{ asset('admin/images/important.png') }}" alt="Important!!!" width="100%">
                </div>
                <div class="col-10 text-center pt-4">
                    @can('medecin', \App\Models\Patient::class)
                    <div class="float-end">
                        <button title="Modifier" class="btn btn-secondary rounded-circle float-end" data-bs-toggle="modal" data-bs-target="#prescription_medicale_form"><i class="fas fa-edit"></i></button>
                    </div>
                    @endcan
                    <h3>{{ $patient->name }} {{ $patient->prenom }}</h3>
                    <p><strong>Allergies : </strong> {{$fiche_prescription_medicale->allergie }}</p>
                </div>


                <div class="col-12 mb-3">
                    <div class="row  p-3">
                        <div class="col-sm-4 ">
                            <div class="mx-auto p-3 border bg-white">
                                <h5>Régime</h5>
                                <br>
                                <p>{{$fiche_prescription_medicale->regime}}</p>
                            </div>

                        </div>
                        <div class="col-sm-4 ">
                            <div class="mx-auto p-3 border bg-white">
                                <h5>Consultations spécialisées</h5>
                                <br>
                                <p>{{$fiche_prescription_medicale->consultation_specialise}}</p>
                            </div>

                        </div>
                        <div class="col-sm-4 ">
                            <div class="mx-auto p-3 border bg-white">
                                <h5>Autres (Protocoles, Surveillance...)</h5>
                                <br>
                                <p>{{$fiche_prescription_medicale->protocole}}</p>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
    </div>
    @include('admin.consultations.infirmiers.form.elt_prescription_medicale_form')
    @include('admin.consultations.infirmiers.form.prescription_medicale_form')
    @include('admin.consultations.infirmiers.admin_prescription_medicale')
    @include('admin.consultations.infirmiers.form.admin_prescription_medicale_form')
    @endcan
</body>
@endsection
@section('script')

<script>
    // IMPORTANT : Attendre que jQuery soit chargé
    waitForjQuery(function() {
        
        
        $(document).ready(function() {
            
            
            infirmieres = @json($infirmieres);
            
            //  Gestion du bouton "Saisir un nouveau soin"
            $(document).on("click", ".btn_admin_prescription_medicale_form", function(e) {
                
                
                var prescription_medicale_id = $(this).data('bs-prescription_medicale_id');
                
                
                if (!prescription_medicale_id) {
                    console.error(' ID prescription non trouvé !');
                    return;
                }
                
                // Construire l'URL manuellement
                var url = '/admin/prescriptions-medicales/' + prescription_medicale_id + '/Admin-PM';
               
                
                // Définir l'action du formulaire
                $("#apm_form").attr('action', url);
                console.log(' Action du formulaire définie:', $("#apm_form").attr('action'));
                console.log(' Formulaire trouvé:', $("#apm_form").length > 0 ? 'OUI' : 'NON');
            });

            //  Gestion de l'affichage des administrations
            $(document).on("click", ".btn_admin_prescription_medicale", function() {
               
                
                let table_body = $('<tbody></tbody>');
                let data = $(this).data('bs-admin_list');

                $('#admin_prescription_medicale_table tbody').empty();
                
                if (!data || data.length === 0) {
                    console.log(' Aucune administration trouvée');
                    return;
                }
                
                $.each(data, function(index, value) {
                    let dmatin = value.matin == null ? '' : value.matin;
                    let dinfirmiere = infirmieres.find(element => element.id == value.user_id);
                    let ddate = value.created_at.substring(0, 10);
                    let dapre_midi = value.apre_midi == null ? '' : value.apre_midi;
                    let dsoir = value.soir == null ? '' : value.soir;
                    let dnuit = value.nuit == null ? '' : value.nuit;

                    table_body.append('<tr><td>' + ddate + '</td><td>' + (dinfirmiere ? dinfirmiere.name : 'N/A') + '</td><td>' + dmatin + '</td><td>' + dapre_midi + '</td><td>' + dsoir + '</td><td>' + dnuit + '</td></tr>');
                });
                
                $('#admin_prescription_medicale_table tbody').html(table_body.html());
            });

            // Gestion du modal "Informations Importantes"
            $("#prescription_medicale_form").on('show.bs.modal', function (event) {
                console.log('🔵 Modal "Informations Importantes" ouvert');
                
                $('#allergie').val('{{ $fiche_prescription_medicale->allergie ?? '' }}');
                $('#regime').val('{{ $fiche_prescription_medicale->regime ?? '' }}');
                $('#consultation_specialise').val('{{ $fiche_prescription_medicale->consultation_specialise ?? '' }}');
                $('#protocole').val('{{ $fiche_prescription_medicale->protocole ?? '' }}');
            });
            
            
        });
    });
</script>


<!-- <script>
    $(document).ready(function() {
        infirmieres = @json($infirmieres);
    });

    $(".btn_admin_prescription_medicale_form").on("click", function() {
        var prescription_medicale_id = $(this).data('prescription_medicale_id');
        let url = '{{ route("admin.prescription_medicale.store", ":id") }}';
        $("#apm_form").attr('action', url.replace(':id', prescription_medicale_id));
    });

    $(".btn_admin_prescription_medicale").on("click", function() {
        let table_body = $('<tbody></tbody>');
        let data = $(this).data('admin_list');
        
        $.each(data, function(index, value) {
            let dmatin = value.matin == null ? '' : value.matin;
            let dinfirmiere = infirmieres.find(element => element.id == value.user_id);
            let ddate = value.created_at.substring(0, 10);
            let dapre_midi = value.apre_midi == null ? '' : value.apre_midi;
            let dsoir = value.soir == null ? '' : value.soir;
            let dnuit = value.nuit == null ? '' : value.nuit;

            table_body.append('<tr><td>' + ddate + '</td><td>' + dinfirmiere.name + '</td><td>' + dmatin + '</td><td>' + dapre_midi + '</td><td>' + dsoir + '</td><td>' + dnuit + '</td></tr>');
        });
        
        $('#admin_prescription_medicale_table tbody').html(table_body.html());
    });

</script> -->



@endsection