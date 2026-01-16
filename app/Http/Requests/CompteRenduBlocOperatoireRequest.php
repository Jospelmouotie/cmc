<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompteRenduBlocOperatoireRequest extends FormRequest
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
            'chirurgien'=> 'required',
            'anesthesiste'=> 'required',
            'date_intervention'=> 'required',
            'dure_intervention'=> 'required',
            'compte_rendu_o'=> 'required',
            'conclusion'=> 'required',
        ];
    }
}
