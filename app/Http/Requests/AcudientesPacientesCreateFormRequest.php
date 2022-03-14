<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AcudientesPacientesCreateFormRequest extends FormRequest
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
            'ide_pac'  => 'required',
            'ide_acu'  => 'required',
            'ide_tac'  => 'required',
            'pre_paa'  => 'required'
        ];
    }

    public function messages()
    {
        return [
            'ide_pac.required' => 'El campo Paciente es obligatorio.',
            'ide_acu.required' => 'El campo Acudiente es obligatorio.',
            'ide_tac.required' => 'El campo Tipo acudiente es obligatorio.',
            'pre_paa.required' => 'El campo Conocimiento es obligatorio.',
        ];
    }
}
