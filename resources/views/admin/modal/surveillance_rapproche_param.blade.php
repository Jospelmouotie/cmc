<div class="modal fade" id="SurveillancePre" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">SURVEILLANCE RAPPROCHEE PRE-OPERATOIRE</h5>
                <button type="button" class="close" data-bs-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('surveillance_rapproche_param') }}" method="post">
                    @csrf
                    <div class="container">
                        <div class="col-md-10  toppad">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <td>
                                                <label for=""><b>PATIENT :</b></label>
                                                <input type="text" class="form-control" name="nom_patient" value="{{ $patient->name }} {{ $patient->prenom }}" disabled="disabled">
                                            </td>
                                            <td>
                                                <label><b>Période :</b> <span class="text-danger">*</span></label>
                                                <select name="periode" class="form-control" required>
                                                    <option value=""><b>Période :</b></option>
                                                    <option value="preoperatoire">Pré-opératoire</option>
                                                    <option value="postoperatoire">Post-opératoire</option>
                                                </select>
                                            </td>
                                        </tr>


                                        <tr>
                                            <td style="width: 50%;">
                                                <label for=""><b>DATE :</b></label>
                                                <input type="date" class="form-control" name="date" value="{{ old('date', Carbon\Carbon::now()->ToDateString()) }}">
                                            </td>
                                            <td style="width: 50%;">
                                                <label for=""><b>HEURE :</b></label>
                                                <input type="time" class="form-control" name="heure" value="{{ old('heure') }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label for=""><b>T.A :</b> <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="ta" value="{{ old('ta') }}">
                                            </td>
                                            <td>
                                                <label for=""><b>F.R :</b> <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" name="fr" value="{{ old('fr') }}">
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <label for=""><b>SPO2 :</b> <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" name="spo2" value="{{ old('spo2') }}">
                                            </td>
                                            <td>
                                                <label for=""><b>T° :</b> <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" name="temperature" min="0" step="any" value="{{ old('temperature') }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label for=""><b>DIURESE</b> <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="diurese" value="{{ old('diurese') }}">
                                            </td>
                                            <td>
                                                <label for=""><b>POULS :</b> <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" name="pouls" value="{{ old('pouls') }}">
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <label for=""><b>CONSCIENCE :</b> <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="conscience" value="{{ old('conscience') }}">
                                            </td>
                                            <td>
                                                <label for=""><b>DOULEUR :</b> <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="douleur" value="{{ old('douleur') }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 1000px;">
                                                <label for=""><b>OBSERVATIONS / PLAINTES</b> <span class="text-danger">*</span></label>
                                                <textarea class="form-control" name="observation_plainte" cols="100" rows="3">{{ old('observation_plainte') }}</textarea>
                                            </td>
                                            <td></td>
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
