<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SoinsRequest extends FormRequest
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
            'content'=> 'required|max:255',
            'contexte'=> 'required|max:255'
        ];
    }
}
