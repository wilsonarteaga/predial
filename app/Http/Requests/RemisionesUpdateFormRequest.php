<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RemisionesUpdateFormRequest extends FormRequest
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
            'mot_rem_edit'  => 'required',
            'don_rem_edit'  => 'required',
            'pacientes_ide_pac_edit'  => 'required',
            'fonoaudiologos_ide_fon_edit'  => 'required'
        ];
    }

    public function messages()
    {
        return [
            'mot_rem_edit.required' => 'El campo Motivo es obligatorio.',
            'don_rem_edit.required' => 'El campo Lugar de remisión es obligatorio.',
            'pacientes_ide_pac_edit.required' => 'El campo Paciente es obligatorio.',
            'fonoaudiologos_ide_fon_edit.required' => 'El campo Fonoaudiologo es obligatorio.',
        ];
    }
}
