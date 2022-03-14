<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AcudientesPacientesUpdateFormRequest extends FormRequest
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
            'pacientes_ide_pac_edit'  => 'required',
            'acudientes_ide_acu_edit'  => 'required',
            'tipos_acudientes_ide_tac_edit'  => 'required',
            'pre_paa_edit'  => 'required'
        ];
    }

    public function messages()
    {
        return [
            'pacientes_ide_pac_edit.required' => 'El campo Paciente es obligatorio.',
            'acudientes_ide_acu_edit.required' => 'El campo Acudiente es obligatorio.',
            'tipos_acudientes_ide_tac_edit.required' => 'El campo Tipo acudiente es obligatorio.',
            'pre_paa_edit.required' => 'El campo Conocimiento es obligatorio.',
        ];
    }
}
