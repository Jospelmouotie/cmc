<div class="modal fade" id="FicheInterventionAnesthesiste" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">FICHE D'INTERVENTION</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('fiche_intervention.store') }}" method="post">
                    @csrf
                    <div class="container-fluid">
                        <div class="col-md-10 mx-auto">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr>
                                                <td><h5 class="text-primary fw-bold">PATIENT</h5></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Nom du patient :</strong></td>
                                                <td>
                                                    <input type="text" value="{{ $patient->name }}" name="nom_patient" class="form-control">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Prénom du patient :</strong></td>
                                                <td>
                                                    <input type="text" value="{{ $patient->prenom }}" name="prenom_patient" class="form-control">
                                                </td>
                                            </tr>
                                            @foreach ($patient->dossiers as $dossier)
                                                <tr>
                                                    <td><strong>Sexe :</strong></td>
                                                    <td>
                                                        <input type="text" value="{{ $dossier->sexe }}" name="sexe_patient" class="form-control">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Date de naissance :</strong></td>
                                                    <td>
                                                        <input type="date" value="{{ $dossier->date_naissance }}" name="date_naiss_patient" class="form-control">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Téléphone :</strong></td>
                                                    <td>
                                                        <input type="number" value="{{ $dossier->portable_2 }}" name="portable_patient" class="form-control">
                                                    </td>
                                                </tr>
                                            @endforeach

                                            <tr>
                                                <td><h5 class="text-primary fw-bold">INTERVENTION</h5></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Type :</strong> <span class="text-danger">*</span></td>
                                                <td>
                                                    <input type="text" class="form-control" name="type_intervention" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Durée :</strong> <span class="text-danger">*</span></td>
                                                <td>
                                                    <input type="time" class="form-control w-auto" name="dure_intervention" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Position du patient :</strong> <span class="text-danger">*</span></td>
                                                <td>
                                                    <div class="form-check mb-2">
                                                        <input type="radio" name="position_patient[]" value="Décubitus" class="form-check-input" id="decubitus">
                                                        <label class="form-check-label" for="decubitus">Décubitus</label>
                                                        <div class="ms-4">
                                                            <div class="form-check">
                                                                <input type="radio" name="decubitus[]" value="Latéral" class="form-check-input" id="lateral">
                                                                <label class="form-check-label" for="lateral">Latéral</label>
                                                                <div class="ms-4">
                                                                    <div class="form-check">
                                                                        <input type="checkbox" name="laterale[]" value="Droite" class="form-check-input" id="laterale_droite">
                                                                        <label class="form-check-label" for="laterale_droite">Droite</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input type="checkbox" name="laterale[]" value="Gauche" class="form-check-input" id="laterale_gauche">
                                                                        <label class="form-check-label" for="laterale_gauche">Gauche</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="radio" name="decubitus[]" value="Dorsal" class="form-check-input" id="dorsal">
                                                                <label class="form-check-label" for="dorsal">Dorsal</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="radio" name="decubitus[]" value="Ventral" class="form-check-input" id="ventral">
                                                                <label class="form-check-label" for="ventral">Ventral</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-check mb-2">
                                                        <input type="radio" name="position_patient[]" value="Lithotomie" class="form-check-input" id="lithotomie">
                                                        <label class="form-check-label" for="lithotomie">Lithotomie</label>
                                                    </div>

                                                    <div class="form-check mb-2">
                                                        <input type="radio" name="position_patient[]" value="Lombotomie" class="form-check-input" id="lombotomie">
                                                        <label class="form-check-label" for="lombotomie">Lombotomie</label>
                                                        <div class="ms-4">
                                                            <div class="form-check">
                                                                <input type="checkbox" name="lombotomie[]" value="Droite" class="form-check-input" id="lombotomie_droite">
                                                                <label class="form-check-label" for="lombotomie_droite">Droite</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="checkbox" name="lombotomie[]" value="Gauche" class="form-check-input" id="lombotomie_gauche">
                                                                <label class="form-check-label" for="lombotomie_gauche">Gauche</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-check mb-2">
                                                        <input type="radio" name="position_patient[]" value="Trendelenburg" class="form-check-input" id="trendelenburg">
                                                        <label class="form-check-label" for="trendelenburg">Trendelenburg</label>
                                                    </div>

                                                    <div class="mt-2">
                                                        <label for="position_autre">Autre :</label>
                                                        <input type="text" class="form-control mt-1" name="position_patient[]" id="position_autre">
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td><strong>Date intervention :</strong> <span class="text-danger">*</span></td>
                                                <td>
                                                    <input class="form-control" name="date_intervention" type="date" value="{{ old('date_intervention') }}" required>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td><strong>Chirurgien :</strong> <span class="text-danger">*</span></td>
                                                <td>
                                                    <!-- ✅ Use form-select for selects in Bootstrap 5 -->
                                                    <select name="medecin" id="medecin" class="form-select" required>
                                                        <option value="">Choisir le médecin</option>
                                                        @foreach($medecin as $m)
                                                            <option value="{{ $m->name }} {{ $m->prenom }}">{{ $m->name }} {{ $m->prenom }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td><strong>Aide opératoire :</strong> <span class="text-danger">*</span></td>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="aide_op[]" value="Oui" id="aide_oui">
                                                        <label class="form-check-label" for="aide_oui">Oui</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="aide_op[]" value="Non" id="aide_non">
                                                        <label class="form-check-label" for="aide_non">Non</label>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td><strong>Hospitalisation :</strong></td>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="hospitalisation" value="Hospitalisation" id="hosp_oui">
                                                        <label class="form-check-label" for="hosp_oui">Hospitalisation</label>
                                                    </div>
                                                    <!-- ✅ Replace inline style with d-inline-block and w-auto -->
                                                    <input type="text" name="heure" placeholder="Heure" class="form-control mt-1 w-auto d-inline-block">
                                                </td>
                                            </tr>

                                            <tr>
                                                <td><strong>Ambulatoire :</strong></td>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="ambulatoire" value="Ambulatoire" id="amb_oui">
                                                        <label class="form-check-label" for="amb_oui">Ambulatoire</label>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td><strong>Anesthésie :</strong> <span class="text-danger">*</span></td>
                                                <td>
                                                    @foreach(['AL', 'AG', 'LR', 'RA', 'PD', 'ALR'] as $type)
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="anesthesie[]" value="{{ $type }}" id="anesth_{{ $type }}">
                                                            <label class="form-check-label" for="anesth_{{ $type }}">{{ $type }}</label>
                                                        </div>
                                                    @endforeach
                                                </td>
                                            </tr>

                                            <tr>
                                                <td><strong>RECOMMENDATION(S) :</strong></td>
                                                <td>
                                                    <textarea name="recommendation" class="form-control" rows="5">{{ old('recommendation') }}</textarea>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <button type="submit" class="btn btn-primary">Ajouter au dossier</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" value="{{ $patient->id }}" name="patient_id">
                </form>
            </div>
        </div>
    </div>
</div>