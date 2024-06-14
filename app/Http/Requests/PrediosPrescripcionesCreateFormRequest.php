<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrediosPrescripcionesCreateFormRequest extends FormRequest
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
            'id_predio' => 'required',
            'prescribe_desde' => 'required',
            'prescribe_hasta' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'id_predio.required' => 'El campo código predio es obligatorio.',
            'prescribe_desde.required' => 'El campo prescribe desde es obligatorio.',
            'prescribe_hasta.required' => 'El campo prescribe hasta es obligatorio.'
        ];
    }
}
