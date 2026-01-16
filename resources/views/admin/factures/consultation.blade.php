@extends('layouts.admin')

@section('title', 'CMCU | Bilan facure')

@section('content')

<body>
    {{--<div class="se-pre-con"></div>--}}
    <div class="wrapper">
        @include('partials.side_bar')

        <!-- Page Content Holder -->
        @include('partials.header')
        <!--// top-bar -->
        @can('view', \App\Models\User::class)
        <div class="container_fluid">
            <h1 class="text-center">FACTURES</h1>
            <hr>
            <div class="container pt-3">
                <!--  -->
                <div class="row">
                    <form action="{{ route('search.date') }}" method="post" class="w-100">
                        @csrf
                        <div class="d-flex align-items-end flex-wrap">
                            <div class="me-5">
                                <label for="start-date">Start Date</label>
                                <input type="date" id="start-date" name="start-date" pattern="\d{4}-\d{2}-\d{2}" class="form-control">
                            </div>

                            <div class="d-flex align-items-end" style="gap:.5rem;">
                                <div>
                                    <label for="end-date1">End Date</label>
                                    <input type="date" id="end-date1" name="end-date" pattern="\d{4}-\d{2}-\d{2}" class="form-control">
                                </div>
                                <div class="d-flex align-items-center">
                                    <button type="submit" class="btn btn-primary btn-sm mt-2">Search</button>
                                </div>
                            </div>
                        </div>

                        <!-- Error message display -->
                        <!-- @if($errors->any())
                            <div class="alert alert-danger mt-2">
                                @foreach($errors->all() as $error)
                                    <p class="mb-0">{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif -->
                    </form>
                </div>
                @if (isset($factureConsultations))
                <div class="col-lg-12">
                <p>Factures Du <strong>{{$startDate}} </strong>&nbsp;&nbsp;au&nbsp;&nbsp;<strong>{{$endDate}}</strong> </p><br>
                    <div class="table-responsive">
                        <i class="table_info">Les montants sont exprimés en <b> FCFA</b></i>
                        <table id="myTable" class="table table-hover table-bordered display" cellspacing="0" width="100%">
                            <thead>
                                <th>ID</th>
                                <th>ACTION</th>
                                <th>NUMERO</th>
                                <th>PATIENT</th>
                                <th>MOTIF</th>
                                <th>MONTANT</th>
                                <th style="white-space: nowrap">PART ASSURANCE</th>
                                <th style="white-space: nowrap">PART PATIENT</th>
                                <th>AVANCE</th>
                                <th>RESTE</th>
                                <th>Mode paiement</th>
                                <th>MEDECIN</th>
                                <th>DATE</th>
                                <th id="statut">STATUT</th>
                            </thead>
                            <tbody>
                                @foreach($factureConsultations as $facture)
                                <tr>
                                    <td>{{$facture->id}}</td>
                                    <td ><div class="d-inline-flex">
                                         <a class="btn btn-success btn-sm me-1" data-bs-placement="top" data-bs-toggle="tooltip" title="Imprimer la facture" href="{{ route('factures.consultation_pdf', $facture->id) }}"><i class="fas fa-print"></i></a>
                                        @can('update', $facture)
                                        <!-- Trigger the "edit_acture " modal with a button -->
                                        <button type="button" class="btn btn-sm btn-info me-1" data-bs-toggle="modal" title="Editer la facture" data-bs-target="#edit_facture_modal" data-id-facture="{{$facture->id}}" data-nom="{{ $facture->patient['name'] }}" data-montant="{{ $facture->montant }}" data-reste="{{ $facture->reste }}" data-mode_paiement="{{ $facture->mode_paiement }}" data-prise_en_charge="{{ $facture->patient['prise_en_charge'] }}"> <i class="fas fa-edit"></i></button>
                                        <form action="{{ route('factures.destroy', $facture->id) }}" method="post">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm btn-just-icon" data-bs-toggle="tooltip" title="Supprimer la facture" onclick="return confirm('Voulez-vous vraiment suprimer cette facture ?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endcan

                                    </div>
                                       

                                    </td>
                                    <td>{{$facture->numero}}</td>
                                    <td>{{$facture->patient['name'] }}</td>
                                    <td>{{$facture->details_motif ?? 'Consultation' }}</td>
                                    <td>{{$facture->montant }} </td>
                                    <td>{{$facture->assurancec }} </td>
                                    <td>{{$facture->assurec }} </td>
                                    <td>{{$facture->avance }} </td>
                                    <td>{{$facture->reste }} </td>
                                    <td>{{$facture->mode_paiement === 'bon de prise en charge' ? 'BPC':$facture->mode_paiement }}
                                            @foreach (preg_split("/[\/]{2} /", $facture->mode_paiement_info_sup,0,PREG_SPLIT_NO_EMPTY) as $info_sup)
                                            <br>
                                            <i>
                                                <small>
                                                    
                                                    {{ $info_sup}}
                                                </small>
                                            </i>
                                            @endforeach
                                         </td>
                                    <td>{{$facture->medecin_r }}</td>
                                    <td style="white-space: nowrap">{{$facture->created_at }}</td>
                                    <td>{{$facture->reste == 0 ? 'Soldée' : 'Non soldée' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <form class="mb-3 table_link_end" method="POST" action="{{ route('bilan_consultation.pdf') }}" title="Imprimer le bilan journalier" data-bs-toggle="tooltip">
                            @csrf
                            <div class="input-group mb-3">
                                <select name="day" class="form-control col-6" required>
                                    <option>Bien vouloir choisir une date</option>
                                    @foreach($lists as $list)
                                    <option value="{{ $list }}">{{ $list }}</option>
                                    @endforeach
                                </select>
                                <select name="service" class="form-control col-4" required>
                                    <option value="Tout" selected>Tous les services</option>
                                    <option value="Consultation">Consultation</option>
                                    <option value="Acte">Acte</option>
                                    <option value="Examen">Examen</option>
                                    <option value="Autre">Autre</option>
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-primary">Imprimer</button>
                                </div>
                            </div>
                        </form>
                        {{--{{ $factures->links() }}--}}
                    </div>
                </div>
                @endif 
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div id="edit_facture_modal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit_facture_modallabel"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="edit_facture_form" action="" method="post">
                    @csrf @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="montant" class="col-form-label text-md-end">Montant</label>
                                    <input name="montant" id="montant" class="form-control" value="" type="number" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="part_patient" class="col-form-label text-md-end">Part patient </label>
                                    <input name="part_patient" id="part_patient" class="form-control" type="number" autocomplete="off" min="0" placeholder="0" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="reste" class="col-form-label text-md-end" title="Somme des précédents versements du client">reste </label>
                                    <input name="reste" id="reste" class="form-control" value="" type="number" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="percu" class="col-form-label text-md-end" title="Montant perçu pour ce versement">montant versé <span class="text-danger">*</span></label>
                                    <input name="percu" id="percu" class="form-control" value="" type="number" placeholder="0" required>
                                </div>
                                <div class="mb-3 m_paiement">
                                    <label for="mode_paiement">Mode de paiement</label>
                                    <select name="mode_paiement" id="mode_paiement" class="form-control">

                                        <optgroup label="Monaie électronique">
                                            <option value="orange money">Orange Money</option>
                                            <option value="mtn mobile money">MTN Mobile Money</option>
                                        </optgroup>
                                        <optgroup label="Autres moyens">
                                            <option value="espèce">Espèce</option>
                                            <option value="chèque">Chèque</option>
                                            <option value="virement">Virement</option>
                                            <option value="bon de prise en charge">Bon de prise en charge</option>
                                            <option value="autre">Autre</option>
                                        </optgroup>
                                    </select>
                                </div>                    
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-info" data-placement="top" data-bs-toggle="tooltip" title="Enregistrer les modifications">Envoyer <i class="fas fa-send"></i></button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    @endcan

</body>

@endsection

@section('script')

<script>
// Wait for both DOM and jQuery to be ready
document.addEventListener('DOMContentLoaded', function() {
    // Ensure jQuery is loaded
    if (typeof $ === 'undefined') {
        console.error('jQuery is not loaded!');
        return;
    }
    
    // Wait for jQuery to be fully ready
    $(document).ready(function() {
        console.log('jQuery version:', $.fn.jquery);
        
        // DataTables column adjustment
        $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        
        // Edit facture modal handler
        $('#edit_facture_modal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id_facture = button.data('id-facture');
            var mode_paiement = button.data('mode_paiement');
            var montant_facture = button.data('montant');
            var reste = button.data('reste');
            var prise_en_charge = button.data('prise_en_charge');
            var modal = $(this);
            
            $('#edit_facture_modallabel').text("Nouveau versement");
            $('#montant').val(montant_facture);
            $("#mode_paiement").val(mode_paiement);
            $('#reste').val(reste);
            
            if (isNaN(prise_en_charge)) {
                $('#montant').attr('data-prise_en_charge', 0);
                $('#part_patient').val(montant_facture);
            } else {
                $('#montant').attr('data-prise_en_charge', prise_en_charge);
                $('#part_patient').val(montant_facture * (100 - prise_en_charge) / 100);
            }
            
            $('#edit_facture_form').attr("action", "{{ url('admin/factures-consultation') }}" + "/" + id_facture);
        });
        
        // Montant change handler
        $('#montant').on('change', function(event) {
            var PEC = $(this).data('prise_en_charge');
            var montant = $(this).val();
            $('#part_patient').val(montant * (100 - PEC) / 100);
        });
        
        // Form validation for date range
        const form = document.querySelector('form[action="{{ route('search.date') }}"]');
        if (form) {
            const startDateInput = document.getElementById('start-date');
            const endDateInput = document.getElementById('end-date1');
            
            if (startDateInput && endDateInput) {
                const errorMessage = document.createElement('div');
                errorMessage.style.color = 'red';
                errorMessage.style.marginTop = '10px';
                errorMessage.className = 'date-error-message';
                
                // Insert after the form or in a specific location
                if (!form.querySelector('.date-error-message')) {
                    form.appendChild(errorMessage);
                }
                
                form.addEventListener('submit', function(event) {
                    const startDate = new Date(startDateInput.value);
                    const endDate = new Date(endDateInput.value);
                    
                    if (startDate >= endDate) {
                        errorMessage.textContent = 'Start date must be before end date.';
                        event.preventDefault();
                    } else {
                        errorMessage.textContent = '';
                    }
                });
            }
        }
        
        console.log('All consultation page scripts initialized successfully');
    });
});
</script>

@endsection




















