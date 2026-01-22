<div class="modal fade" id="VisiteAnesthesiste" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">VISITE PRE-ANESTHESIQUE</h5>
                <button type="button" class="close" data-bs-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('visite_preanesthesique.store') }}" method="post">
                    @csrf
                    <div class="container">
                        <div class="col-md-10  toppad">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <td>
                                                <h5 class="text-primary"><strong>PATIENT</strong></h5>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td><b>Nom du patient :</b></td>
                                            <td>
                                                <input type="text" value="{{ $patient->name }}" name="nom_patient" class="form-control" disabled>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Prénom du patient :</b></td>
                                            <td>
                                                <input type="text" value="{{ $patient->prenom }}" name="prenom_patient" class="form-control" disabled>
                                            </td>
                                        </tr>
                                        @foreach ($patient->dossiers as $dossier)
                                            <tr>
                                                <td><b>Sexe :</b></td>
                                                <td>
                                                    <input type="text" value="{{ $dossier->sexe }}" name="sexe_patient" class="form-control" disabled>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td><b>Date :</b> <span class="text-danger">*</span></td>
                                            <td>
                                                <input type="date" value="{{ Carbon\Carbon::now()->ToDateString() }}" class="form-control" name="date_visite" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>VPA / Eléménts nouveaux (MAR) :</b> <span class="text-danger">*</span></td>
                                            <td>
                                                <textarea name="element_nouveaux" class="form-control" id="vpa" cols="55" rows="10">{{ old('element_nouveaux') }}</textarea>
                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>
                                    <button type="submit" class="btn btn-primary">Ajouter au dossier</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <input type="hidden" value="{{ $patient->id }}" name="patient_id">
                </form>
            </div>
        </div>
    </div>
</div>
