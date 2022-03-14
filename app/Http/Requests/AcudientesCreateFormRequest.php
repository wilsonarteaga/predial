<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AcudientesCreateFormRequest extends FormRequest
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
            'nom_acu'  => 'required',
            'ape_acu'  => 'required',
            'tid_acu'  => 'required',
            'ide_acu'  => 'required|unique:acudientes,ide_acu',
            'tel_acu'  => 'required'
        ];
    }

    public function messages()
    {
        return [
            'nom_acu.required' => 'El campo Nombres es obligatorio.',
            'ape_acu.required' => 'El campo Apellidos es obligatorio.',
            'tid_acu.required' => 'El campo Tipos identificación es obligatorio.',
            'ide_acu.required' => 'El campo Identificación es obligatorio.',
            'tel_acu.required' => 'El campo Teléfono es obligatorio.',
            'ide_acu.unique'   => 'La identificación ya existe.'
        ];
    }
}
