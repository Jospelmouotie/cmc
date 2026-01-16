<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConsultationRequest extends FormRequest
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
            'patient_id' => 'required',
            'diagnostic'=> 'required',
            'interrogatoire'=> 'required',
            'antecedent_m'=> '',
            'antecedent_c'=> '',
            'allergie'=> '',
            'groupe'=> '',
            'proposition'=> 'required',
            'examen_c'=> 'required',
            'examen_p'=> 'required',
            //'devis_p'=> '',
            'motif_c'=> 'required',
            'medecin_r'=> 'required',
            'acte'=> '',
            'date_intervention'=> '',
            'type_intervention'=> '',
            'proposition_therapeutique'=> 'required',
        ];
    }
}
