<div class="modal fade" id="FicheIntervention" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">FICHE D'INTERVENTION</h5>
                <button type="button" class="close" data-bs-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    @csrf
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <p>Nom et prénom :</p>
                                <p>Date de naissance :</p>
                                <label>Type d'intervention :</label> <input type="text" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <p>Opérateur :</p>
                                <p>Aide :</p>
                                <p>Anesthésie :</p>
                                <p>Salle :</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-3">
                                <p><b>Anesthésiste :</b></p><br>
                                <p><b>Position :</b></p>
                            </div>
                            <div class="col-md-3">
                                <input type="checkbox"> Locale<br>
                                <input type="checkbox"> Rachi-anesthésie<br>
                                <input type="checkbox"> Gynécologique
                            </div>
                            <div class="col-md-3">
                                <input type="checkbox"> Générale<br><br>
                                <input type="checkbox"> Décubitus
                            </div>
                        </div>
                    </div>
                    <br>
                    <table style="width:100%" class="table-bordered">
                        <tr>
                            <th class="text-center" colspan="6">MATERIELS ET CONSOMMABLES</th>
                        </tr>
                        <tr>
                            <td>Instillagel</td>
                            <td style="width: 10%"><input class="form-control" type="number"></td>
                            <td>Graine hartmann</td>
                            <td style="width: 10%"><input class="form-control" type="number"></td>
                            <td>Colonne endoscopie</td>
                            <td style="width: 10%"><input class="form-control" type="number"></td>
                        </tr>
                        <tr>
                            <td>Compresses</td>
                            <td style="width: 10%"><input class="form-control" type="number"></td>
                            <td>Poche à urines</td>
                            <td style="width: 10%"><input class="form-control" type="number"></td>
                            <td>Camera</td>
                            <td style="width: 10%"><input class="form-control" type="number"></td>
                        </tr>
                        <tr>
                            <td>Bétadine</td>
                            <td style="width: 10%"><input class="form-control" type="number"></td>
                            <td>Trousse d'irrigation</td>
                            <td style="width: 10%"><input class="form-control" type="number"></td>
                            <td>Resecteur</td>
                            <td style="width: 10%"><input class="form-control" type="number"></td>
                        </tr>
                        <tr>
                            <td>Seringue 10 cc</td>
                            <td style="width: 10%"><input class="form-control" type="number"></td>
                            <td>Champ opératoire</td>
                            <td style="width: 10%"><input class="form-control" type="number"></td>
                            <td>Lame d'uretrorome</td>
                            <td style="width: 10%"><input class="form-control" type="number"></td>
                        </tr>
                        <tr>
                            <td>Gants stériles</td>
                            <td style="width: 10%"><input class="form-control" type="number"></td>
                            <td>Optique 30%</td>
                            <td style="width: 10%"><input class="form-control" type="number"></td>
                            <td>Câble électrique</td>
                            <td style="width: 10%"><input class="form-control" type="number"></td>
                        </tr>
                        <tr>
                            <td>Sonde Dufour</td>
                            <td style="width: 10%"><input class="form-control" type="number"></td>
                            <td></td>
                            <td style="width: 10%"></td>
                            <td></td>
                            <td style="width: 10%"></td>
                        </tr>
                    </table>
                    <input type="hidden" value="{{ $patient->id }}" name="patient_id">
                    <button type="submit" class="btn btn-primary mt-2">Enegistrer</button>
                </form>
            </div>
        </div>
    </div>
</div>
