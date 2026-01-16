<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConsultationAnesthesisteRequest extends FormRequest
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
            'anesthesi_salle' => 'required',
            'antecedent_traitement' => 'required',
            'examen_clinique' => 'required',
            'traitement_en_cours' => 'required',
            'risque' => 'required',
            'synthese_preop' => 'required',
            'technique_anesthesie' => 'required',
        ];
    }
}
