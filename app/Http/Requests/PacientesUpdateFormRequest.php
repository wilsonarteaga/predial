<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PacientesUpdateFormRequest extends FormRequest
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
            'nom_pac_edit'  => 'required',
            'ape_pac_edit'  => 'required',
            'tid_pac_edit'  => 'required',
            'ide_pac_edit'  => 'required',
            'sex_pac_edit'  => 'required',
            'fec_pac_edit'  => 'required',
            // 'acudientes_ide_acu_edit'  => 'required'
        ];
    }

    public function messages()
    {
        return [
            'nom_pac_edit.required' => 'El campo Nombres es obligatorio.',
            'ape_pac_edit.required' => 'El campo Apellidos es obligatorio.',
            'tid_pac_edit.required' => 'El campo Tipos identificación es obligatorio.',
            'ide_pac_edit.required' => 'El campo Identificación es obligatorio.',
            'sex_pac_edit.required' => 'El campo Género es obligatorio.',
            'fec_pac_edit.required' => 'El campo Fecha nacimiento es obligatorio.',
            // 'acudientes_ide_acu_edit.required' => 'El campo Acudiente es obligatorio.',
        ];
    }
}
