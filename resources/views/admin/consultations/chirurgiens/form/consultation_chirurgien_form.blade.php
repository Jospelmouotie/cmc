
@if($consultation->id)
    <form method="POST" action="{{ route('consultation_chirurgien.update', $consultation->id) }}" class="form-horizontal form-label-left">
        @csrf
        @method('PUT')
@else
    <form method="POST" action="{{ route('consultation_chirurgien.store') }}" class="form-horizontal form-label-left">
        @csrf
@endif

<tr>
    <td>
        <h5 class="text-primary"><strong>CONSULTATION</strong></h5>
    </td>
    <td></td>
</tr>
<tr> 
    <td><b>Médecin de référence :</b> <span class="text-danger">*</span></td>
    <td>
        <input type="text" class="form-control splitLines" name="medecin_r" id="medecin_r" value="{{ old('medecin_r', $consultation->medecin_r ?? Auth::user()->name . ' ' . Auth::user()->prenom) }}">
    </td>
</tr>
<tr>
    <td><b>Motif de consultation :</b> <span class="text-danger">*</span></td>
    <td><textarea name="motif_c" class="form-control splitLines" rows="4" required>{{ old('motif_c', $consultation->motif_c ?? '') }}</textarea></td>
</tr>
<tr>
    <td><b>Interrogatoire :</b> <span class="text-danger">*</span></td>
    <td><textarea name="interrogatoire" class="form-control splitLines" rows="5" required>{{ old('interrogatoire', $consultation->interrogatoire ?? '') }}</textarea></td>
</tr>
<tr>
    <td><b>Antécédents médicaux :</b></td>
    <td><textarea name="antecedent_m" class="form-control splitLines" rows="3">{{ old('antecedent_m', $consultation->antecedent_m ?? '') }}</textarea></td>
</tr>
<tr>
    <td><b>Antécédents chirurgicaux :</b></td>
    <td><textarea name="antecedent_c" class="form-control splitLines" rows="3">{{ old('antecedent_c', $consultation->antecedent_c ?? '') }}</textarea></td>
</tr>
<tr>
    <td><b>Allergies :</b></td>
    <td><textarea name="allergie" class="form-control splitLines" rows="3">{{ old('allergie', $consultation->allergie ?? '') }}</textarea></td>
</tr>
<tr>
    <td><b>Goupe sanguin du patient :</b></td>
    <td>
        <select class="form-control col-md-5" name="groupe" id="groupe">
            <option value="">Groupes sanguins</option>
            @foreach(['O-', 'O+', 'B-', 'B+', 'A-', 'A+', 'AB-', 'AB+'] as $group)
                <option value="{{ $group }}" {{ old('groupe', $consultation->groupe ?? '') == $group ? 'selected' : '' }}>{{ $group }}</option>
            @endforeach
        </select>
    </td>
</tr>
<tr>
    <td>
        <h5 class="text-primary"><strong>EXAMENS</strong></h5>
    </td>
    <td></td>
</tr>
<tr>
    <td><input type="hidden" name="patient_id" value="{{ $patient->id }}" class="form-control"></td>
    <td></td>
</tr>
<tr>
    <td><b>Examens physiques :</b> <span class="text-danger">*</span></td>
    <td><textarea name="examen_p" class="form-control splitLines" rows="4" required>{{ old('examen_p', $consultation->examen_p ?? '') }}</textarea></td>
</tr>
<tr>
    <td><b>Examens compléméntaires:</b> <span class="text-danger">*</span></td>
    <td><textarea name="examen_c" class="form-control splitLines" rows="4" required>{{ old('examen_c', $consultation->examen_c ?? '') }}</textarea></td>
</tr>
<tr>
    <td><b>Diagnostic médical :</b> <span class="text-danger">*</span></td>
    <td><textarea name="diagnostic" class="form-control splitLines" rows="4" required>{{ old('diagnostic', $consultation->diagnostic ?? '') }}</textarea></td>
</tr>
<tr>
    <td><b>Proposition thérapeutique :</b> <span class="text-danger">*</span></td>
    <td><textarea name="proposition_therapeutique" class="form-control splitLines" rows="4" required>{{ old('proposition_therapeutique', $consultation->proposition_therapeutique ?? '') }}</textarea></td>
</tr>
<tr>
    <td><b>Proposition de suivi :</b> <span class="text-danger">*</span></td>
    <td class="form-group small">
        @php
            $propositions = is_string($consultation->proposition ?? '') ? explode(',', $consultation->proposition) : [];
        @endphp
        <div class="form-check">
            <input class="form-check-input" onClick="ckChange(this)" type="checkbox" name="proposition[]" id="decision1" value="Hospitalisation" {{ in_array('Hospitalisation', old('proposition', $propositions)) ? 'checked' : '' }}> Hospitalisation
        </div>
        <div class="form-check">
            <input class="form-check-input" onClick="ckChange(this)" type="checkbox" name="proposition[]" id="decision2" value="Intervention chirurgicale" {{ in_array('Intervention chirurgicale', old('proposition', $propositions)) ? 'checked' : '' }}> Intervention chirurgicale
        </div>
        <div class="form-check">
            <input class="form-check-input" onClick="ckChange(this)" type="checkbox" name="proposition[]" id="decision3" value="Consultation" {{ in_array('Consultation', old('proposition', $propositions)) ? 'checked' : '' }}> Consultation
        </div>
        <div class="form-check">
            <input class="form-check-input" onClick="ckChange(this)" type="checkbox" name="proposition[]" id="decision4" value="Actes à réaliser" {{ in_array('Actes à réaliser', old('proposition', $propositions)) ? 'checked' : '' }}> Actes à réaliser
        </div>
        <div class="form-check">
            <input class="form-check-input" onClick="ckChange(this)" type="checkbox" name="proposition[]" id="decision5" value="Consultation d'anesthésiste" {{ in_array("Consultation d'anesthésiste", old('proposition', $propositions)) ? 'checked' : '' }}> Consultation d'anesthésiste
        </div>
    </td>
</tr>
<tr id="type_intervention" style='display:none;'>
    <td><b>Type d'intervention :</b></td>
    <td><textarea name="type_intervention" class="form-control splitLines" rows="4">{{ old('type_intervention', $consultation->type_intervention ?? '') }}</textarea></td>
</tr>
<tr>
    <td><b>Date intervention :</b></td>
    <td><input type="date" name="date_intervention" value="{{ old('date_intervention', $consultation->date_intervention ?? '') }}" class="form-control col-md-5"></td>
</tr>
<tr id="type_acte" style='display:none;'>
    <td><b>Type d'actes à réaliser :</b></td>
    <td>
        @php
            $actes = is_string($consultation->acte ?? '') ? explode(',', $consultation->acte) : [];
        @endphp
        <div class="form-check">
            <input type="checkbox" name="acte[]" value="Echographie de l'arbre urinaire" {{ in_array("Echographie de l'arbre urinaire", old('acte', $actes)) ? 'checked' : '' }}> Echographie de l'arbre urinaire
        </div>
        <div class="form-check">
            <input type="checkbox" name="acte[]" value="Cystoscopie" {{ in_array('Cystoscopie', old('acte', $actes)) ? 'checked' : '' }}> Cystoscopie
        </div>
        <div class="form-check">
            <input type="checkbox" name="acte[]" value="Biopsie prostatique" {{ in_array('Biopsie prostatique', old('acte', $actes)) ? 'checked' : '' }}> Biopsie prostatique
        </div>
        <div class="form-check">
            <input type="checkbox" name="acte[]" value="Débitimétrie" {{ in_array('Débitimétrie', old('acte', $actes)) ? 'checked' : '' }}> Débitimétrie
        </div>
        <div class="form-check">
            <input type="checkbox" name="acte[]" value="Echographie prostatique sous rectale" {{ in_array('Echographie prostatique sous rectale', old('acte', $actes)) ? 'checked' : '' }}> Echographie prostatique sous rectale
        </div>
    </td>
</tr>
<tr id="anesthesiste" style='display:none;'>
    <td><b>Date consultation anesthésiste :</b></td>
    <td><input type="date" name="date_consultation_anesthesiste" value="{{ old('date_consultation_anesthesiste', $consultation->date_consultation_anesthesiste ?? '') }}" class="form-control col-md-6"></td>
</tr>
<tr>
    <td></td>
    <td></td>
</tr>
<tr id="consultation" style='display:none;'>
    <td><b>Date de consultation :</b></td>
    <td><input type="date" name="date_consultation" value="{{ old('date_consultation', $consultation->date_consultation ?? '') }}" class="form-control col-md-6"></td>
</tr>
<tr>
    <td>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </td>
    <td></td>
</tr>
</form>