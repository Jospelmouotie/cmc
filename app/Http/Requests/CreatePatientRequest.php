<?php

namespace App\Http\Requests;

use App\Models\Patient;
use Illuminate\Foundation\Http\FormRequest;

class CreatePatientRequest extends FormRequest
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
            'name'=> 'required',
            'assurance'=> '',
            'numero_assurance'=> '',
            'prise_en_charge'=> '',
            'motif'=> '',
            'numero_dossier'=> '',
        ];
    }
}
