<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DossierRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'patient_id'=> 'required',
            'sexe'=> 'required',
            'date_naissance'=> 'required',
            'lieu_naissance'=> '',
            'personne_confiance'=> '',
            'tel_personne_confiance'=> '',
            'portable_1'=> '',
        ];
    }
}
