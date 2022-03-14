<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AcudientesUpdateFormRequest extends FormRequest
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
            'nom_acu_edit'  => 'required',
            'ape_acu_edit'  => 'required',
            'tid_acu_edit'  => 'required',
            'ide_acu_edit'  => 'required',
            'tel_acu_edit'  => 'required'
        ];
    }

    public function messages()
    {
        return [
            'nom_acu_edit.required' => 'El campo Nombres es obligatorio.',
            'ape_acu_edit.required' => 'El campo Apellidos es obligatorio.',
            'tid_acu_edit.required' => 'El campo Tipos identificación es obligatorio.',
            'ide_acu_edit.required' => 'El campo Identificación es obligatorio.',
            'tel_acu_edit.required' => 'El campo Teléfono es obligatorio.'
        ];
    }
}
