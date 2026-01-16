<div class="modal fade" id="PrescriptionMedicale" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nouvelle prescription</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <table class="table">
                                    <tbody>
                                        <form action="{{ route('prescription_medicale.store', $fiche_prescription_medicale->id) }}" method="post">
                                            @csrf
                                            <span class="text-danger">{{ $patient->name }} {{ $patient->prenom }}</span>
                                            <tr>
                                                <td>
                                                    <label> <b>Médicament & Forme :</b></label>
                                                    <input type="text" name="medicament" class="form-control" required>
                                                </td>
                                                <td>
                                                    <label> <b>Posologie :</b></label>
                                                    <input type="text" name="posologie" class="form-control" required>
                                                </td>

                                            </tr>

                                            <tr>
                                                <td>
                                                    <label> <b>Horaire d'administration :</b></label><br>
                                                    <!-- <input type="number" name="horaire" class="form-control col-md-6" required> -->
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label" for="00h">
                                                            <input type="checkbox" class="form-check-input" id="00h" name="horaire[]" value="00H">00H
                                                        </label>
                                                    </div>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label" for="02h">
                                                            <input type="checkbox" class="form-check-input" id="02h" name="horaire[]" value="02H">02H
                                                        </label>
                                                    </div>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label" for="04h">
                                                            <input type="checkbox" class="form-check-input" id="04h" name="horaire[]" value="04H">04H
                                                        </label>
                                                    </div>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label" for="06h">
                                                            <input type="checkbox" class="form-check-input" id="06h" name="horaire[]" value="06H">06H
                                                        </label>
                                                    </div>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label" for="08h">
                                                            <input type="checkbox" class="form-check-input" id="08h" name="horaire[]" value="08H">08H
                                                        </label>
                                                    </div>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label" for="10h">
                                                            <input type="checkbox" class="form-check-input" id="10h" name="horaire[]" value="10H">10H
                                                        </label>
                                                    </div>
                                                    <br>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label" for="12h">
                                                            <input type="checkbox" class="form-check-input" id="12h" name="horaire[]" value="12H">12H
                                                        </label>
                                                    </div>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label" for="14h">
                                                            <input type="checkbox" class="form-check-input" id="14h" name="horaire[]" value="14H">14H
                                                        </label>
                                                    </div>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label" for="16h">
                                                            <input type="checkbox" class="form-check-input" id="16h" name="horaire[]" value="16H">16H
                                                        </label>
                                                    </div>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label" for="18h">
                                                            <input type="checkbox" class="form-check-input" id="18h" name="horaire[]" value="18H">18H
                                                        </label>
                                                    </div>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label" for="20h">
                                                            <input type="checkbox" class="form-check-input" id="20h" name="horaire[]" value="20H">20H
                                                        </label>
                                                    </div>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label" for="22h">
                                                            <input type="checkbox" class="form-check-input" id="22h" name="horaire[]" value="22H">22H
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <label> <b>Voie :</b></label>
                                                    <input type="text" name="voie" class="form-control" required>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td  colspan="2"><input type="submit" class="btn btn-primary" value="Enregistrer"></td>
                                            </tr>
                                            <input type="hidden" name="fiche_prescription_medicale_id" value="{{ $fiche_prescription_medicale->id }}">
                                        </form>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>