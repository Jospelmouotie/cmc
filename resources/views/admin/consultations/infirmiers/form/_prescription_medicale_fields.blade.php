
@php
    $horaires_selected = isset($prescription_medicale) 
        ? (json_decode($prescription_medicale->horaire, true) ?? []) 
        : (old('horaire') ?? []);
    
    $all_horaires = ['00H', '02H', '04H', '06H', '08H', '10H', '12H', '14H', '16H', '18H', '20H', '22H'];
@endphp

<div class="row mb-3">
    <div class="col-md-6">
        <label class="form-label"><b>Médicament & Forme :</b> <span class="text-danger">*</span></label>
        <input type="text"
               name="medicament"
               class="form-control @error('medicament') is-invalid @enderror"
               value="{{ old('medicament', (string) ($prescription_medicale->medicament ?? '')) }}"
               placeholder="Ex: Paracétamol 500mg comprimé"
               required>
        @error('medicament')
            <span class="invalid-feedback">{{ (string) $message }}</span>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label"><b>Posologie :</b> <span class="text-danger">*</span></label>
        <input type="text"
               name="posologie"
               class="form-control @error('posologie') is-invalid @enderror"
               value="{{ old('posologie', (string) ($prescription_medicale->posologie ?? '')) }}"
               placeholder="Ex: 1 comprimé 3 fois par jour"
               required>
        @error('posologie')
            <span class="invalid-feedback">{{ (string) $message }}</span>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-8">
        <label class="form-label"><b>Horaire d'administration :</b> <span class="text-danger">*</span></label>
        <small class="text-muted d-block mb-2">Sélectionnez au moins un horaire</small>
        
        <div class="row">
            @foreach($all_horaires as $horaire)
            <div class="col-md-3 col-4 mb-2">
                <div class="form-check">
                    <input type="checkbox" 
                           class="form-check-input" 
                           id="horaire_{{ $horaire }}" 
                           name="horaire[]" 
                           value="{{ $horaire }}"
                           {{ in_array($horaire, $horaires_selected) ? 'checked' : '' }}>
                    <label class="form-check-label" for="horaire_{{ $horaire }}">
                        {{ $horaire }}
                    </label>
                </div>
            </div>
            @endforeach
        </div>
        @error('horaire')
            <span class="text-danger small">{{ (string) $message }}</span>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label"><b>Voie d'administration :</b> <span class="text-danger">*</span></label>
        <select name="voie" class="form-control @error('voie') is-invalid @enderror" required>
            <option value="">-- Sélectionner --</option>
            <option value="PO" {{ old('voie', (string) ($prescription_medicale->voie ?? '')) == 'PO' ? 'selected' : '' }}>
                PO (Per Os - Orale)
            </option>
            <option value="IV" {{ old('voie', (string) ($prescription_medicale->voie ?? '')) == 'IV' ? 'selected' : '' }}>
                IV (Intraveineuse)
            </option>
            <option value="IM" {{ old('voie', (string) ($prescription_medicale->voie ?? '')) == 'IM' ? 'selected' : '' }}>
                IM (Intramusculaire)
            </option>
            <option value="SC" {{ old('voie', (string) ($prescription_medicale->voie ?? '')) == 'SC' ? 'selected' : '' }}>
                SC (Sous-cutanée)
            </option>
            <option value="Rectale" {{ old('voie', (string) ($prescription_medicale->voie ?? '')) == 'Rectale' ? 'selected' : '' }}>
                Rectale
            </option>
            <option value="Cutanée" {{ old('voie', (string) ($prescription_medicale->voie ?? '')) == 'Cutanée' ? 'selected' : '' }}>
                Cutanée
            </option>
            <option value="Inhalation" {{ old('voie', (string) ($prescription_medicale->voie ?? '')) == 'Inhalation' ? 'selected' : '' }}>
                Inhalation
            </option>
            <option value="Autre" {{ old('voie', (string) ($prescription_medicale->voie ?? '')) == 'Autre' ? 'selected' : '' }}>
                Autre
            </option>
        </select>
        @error('voie')
            <span class="invalid-feedback">{{ (string) $message }}</span>
        @enderror
    </div>
</div>