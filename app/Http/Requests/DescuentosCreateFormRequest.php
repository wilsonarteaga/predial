<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DescuentosCreateFormRequest extends FormRequest
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
            'anio'  => 'required',
            'fecha_limite'  => 'required',
            'porcentaje'  => 'required|max:100'
        ];
    }

    public function messages()
    {
        return [
            'anio.required' => 'El campo año es obligatorio.',
            'fecha_limite.required' => 'El campo fecha limite es obligatorio.',
            'porcentaje.required' => 'El campo porcentaje es obligatorio.',
            'porcentaje.max' => 'Valor máximo :max.'
        ];
    }
}
