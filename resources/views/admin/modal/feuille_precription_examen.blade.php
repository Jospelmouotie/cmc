<div class="modal fade" id="ordonanceModal" tabindex="-1" role="dialog" aria-labelledby="ordonanceModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div> 
            <div class="modal-body">
                <ul class="nav nav-tabs">
                    <li><a data-bs-toggle="tab" class="btn btn-primary" href="#menu1">BIOLOGIES</a></li>
                    <li><a data-bs-toggle="tab" class="btn btn-primary ms-2"  href="#menu2">IMAGERIES</a></li>
                </ul>
                <div class="tab-content">
            <!--   <div id="home" class="tab-pane fade in active">
-                    </div>
-                    <form id="menu1" class="tab-pane fade" action="{{ route('prescriptions.store') }}" method="POST">-->
                    <form id="menu1" class="tab-pane fade in active show" action="{{ route('prescriptions.store') }}" method="POST">
                        <h3 class="text-center mb-4">BIOLOGIE</h3>
                        @csrf
                        @include('admin.consultations.partials.feuille_examen_biologie')
                        <input type="hidden" value="{{ $patient->id }}" name="patient_id">
                        <button type="button" class="btn btn-secondary btn-md mt-2" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit"class="btn btn-primary btn-md mt-2">Enregistrer</button>
                    </form>

                    <form id="menu2" class="tab-pane fade" action="{{ route('imageries.store') }}" method="post">
                        <h3 class="text-center mb-4">IMAGERIE</h3>
                        @csrf
                        @include('admin.consultations.partials.feuille_examen_imagerie')
                        <input type="hidden" value="{{ $patient->id }}" name="patient_id">
                        <button type="button" class="btn btn-secondary btn-md mt-2" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit"class="btn btn-primary btn-md mt-2">Enregistrer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
