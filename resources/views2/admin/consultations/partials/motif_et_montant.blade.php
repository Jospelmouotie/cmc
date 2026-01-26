<tbody id="editMotifMontform" style="display: none;">
    <form action="{{ route('patients.motif_montant.update', $patient->id) }}" method="POST">
        @csrf @method('PUT')
        <tr>
            <td>
                <label for="name" class="col-form-label text-md-right">Nom & prénom du patient :</label>
            </td>
            <td>
                <div class="input-group">
                    <input name="name" class="form-control" value="{{ old('name') ?? $patient->name}}" type="text" placeholder="name">
                    <input name="prenom" class="form-control" value="{{ old('prenom') ?? $patient->prenom}}" type="text" placeholder="prenom">
                </div>

            </td>
        </tr>
        <tr>
            <td>
                <b>Médecin :</b> <span class="text-danger">*</span>


            </td>
            <td>
                <select class="form-control" name="medecin_r" id="medecin_r" required>
                    <option value="medecin_r"> Nom du médecin</option>
                    @foreach ($medecin as $user)
                    <option value="{{ $user->name }} {{ $user->prenom }}" {{ old('medecin_r', $patient->medecin_r) ==   $user->name.' '.$user->prenom ? 'selected' : '' }}>{{ $user->name }} {{ $user->prenom }}
                    </option>
                    @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <label for="motif" class="col-form-label text-md-right">Motif : <span class="text-danger">*</span></label>
            </td>
            <td>
                <select class="form-control" name="motif" id="motif" onchange="new_ckChange(this)">
                    <option {{ old('motif', $patient->motif) ==  'Consultation' ? 'selected' : '' }}>Consultation</option>
                    <option {{ old('motif', $patient->motif) ==  'Acte' ? 'selected' : '' }}>Acte</option>
                    <option {{ old('motif', $patient->motif) ==  'Examen' ? 'selected' : '' }}>Examen</option>
                    <option {{ old('motif', $patient->motif) ==  'Autres' ? 'selected' : '' }}>Autres</option>
                </select>
            </td>
        </tr>

        <tr>
            <td>
                <label for="details_motif" id="label_details_motif" class="col-form-label text-md-right">Détails motif : <span class="text-danger">*</span></label>
            </td>
            <td>
                <input name="details_motif" id="details_motif" class="form-control" value="{{ old('details_motif') ?? $patient->details_motif}}" type="text" placeholder="Précisez le motif">
            </td>
        </tr>


        <tr>
            <td>
                <label for="montant" class="col-form-label text-md-right">Montant :<span class="text-danger">*</span></label>
            </td>
            <td>
                <input name="montant" class="form-control" value="{{ old('montant') ?? $patient->montant}}" type="number" placeholder="montant">
            </td>
        </tr>
        <tr>
            <td>
                <label for="assurance" class="col-form-label text-md-right">Assurance</label>
            </td>
            <td>
                <input name="assurance" class="form-control" value="{{ old('assurance') ?? $patient->assurance }}" type="text" placeholder=" nom de l'assurance si le patient est assuré">
            </td>
        </tr>
        <tr>
            <td>
                <label for="avance" class="col-form-label text-md-right">Avance :<span class="text-danger">*</span></label>
            </td>
            <td>
                <input name="avance" class="form-control" value="{{ old('avance') ?? $patient->avance}}" type="number" placeholder="avance">
            </td>
        </tr>
        <tr>
            <td>
                <label for="numero_assurance" class="col-form-label text-md-right">Numéro d'assurance</label>
            </td>
            <td>
                <input name="numero_assurance" class="form-control" value="{{ old('numero_assurance') ?? $patient->numero_assurance }}" type="text" placeholder="Numéro d'assurance si le patient est assuré">
            </td>
        </tr>
        <tr>
            <td>
                <label for=" prise_en_charge" class="col-form-label text-md-right"> Taux de Prise en Charge : <span class="text-danger"></span></label>
            </td>
            <td>
                <div class="input-group mb-3">
                    <select class="form-control" name="prise_en_charge" id="prise_en_charge" required>
                        @foreach(range(0, 100) as $taux)
                        <option {{ old('prise_en_charge', $patient->prise_en_charge) ==  $taux ? 'selected' : '' }}>{{$taux}}</option>
                        @endforeach
                    </select>
                    <div class="input-group-append">
                        <span class="input-group-text" id="basic-addon2"> % </span>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td><label for="mode_paiement">Moyen de paiement</label></td>
            <td>
                <div class="form-group">
                    <select name="mode_paiement" id="mode_paiement" class="form-control">
                        <optgroup label="Monaie électronique">
                            <option {{ old('mode_paiement', $patient->mode_paiement) ==  'orange money' ? 'selected' : '' }} value="orange money">Orange Money</option>
                            <option {{ old('mode_paiement', $patient->mode_paiement) ==  'mtn mobile money' ? 'selected' : '' }} value="mtn mobile money">MTN Mobile Money</option>
                        </optgroup>
                        <optgroup label="Autres moyens">
                            <option {{ old('mode_paiement', $patient->mode_paiement) ==  'espèce' ? 'selected' : '' }} value="espèce">Espèce</option>
                            <option {{ old('mode_paiement', $patient->mode_paiement) ==  'chèque' ? 'selected' : '' }} value="chèque">Chèque</option>
                            <option {{ old('mode_paiement', $patient->mode_paiement) ==  'virement' ? 'selected' : '' }} value="virement">Virement</option>
                            <option {{ old('mode_paiement', $patient->mode_paiement) ==  'bon de prise en charge' ? 'selected' : '' }} value="bon de prise en charge">Bon de prise en charge</option>
                            <option {{ old('mode_paiement', $patient->mode_paiement) ==  'autre' ? 'selected' : '' }} value="autre">Autre</option>
                        </optgroup>
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </td>
            <td></td>
        </tr>

    </form>
</tbody>
@section('script')
<script>
    function new_ckChange(ckType) {

        var motif = document.getElementById('motif');
        var choix = motif[motif.selectedIndex].value;
        if (choix == 'Consultation') {
            document.getElementById("label_details_motif").innerHTML = 'Détail motif <span class="text-danger">*</span>';
            document.getElementById("details_motif").value = "Consultation";
        } else {
            document.getElementById("details_motif").value = "";
        }
        if (choix == 'Acte' || choix == 'Examen') {
            document.getElementById("label_details_motif").innerHTML = 'Type ' + choix.toLowerCase() + ' <span class="text-danger">*</span>';
        }
        if (choix == 'Autres') {
            document.getElementById("label_details_motif").innerHTML = 'Détails motif <span class="text-danger">*</span>';
        }

    }
</script>
@endsection