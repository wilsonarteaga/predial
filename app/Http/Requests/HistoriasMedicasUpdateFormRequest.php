<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HistoriasMedicasUpdateFormRequest extends FormRequest
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
            'fec_hme_edit'  => 'required',
            'num_hme_edit'  => 'required',
            'mot_hme_edit'  => 'required',
            'dif_hme_edit'  => 'required',
            'pacientes_ide_pac_edit'  => 'required',
            'fonoaudiologos_ide_fon_edit'  => 'required'
        ];
    }

    public function messages()
    {
        return [
            'fec_hme_edit.required' => 'El campo Fecha es obligatorio.',
            'num_hme_edit.required' => 'El campo Número es obligatorio.',
            'mot_hme_edit.required' => 'El campo Motivo es obligatorio.',
            'dif_hme_edit.required' => 'El campo Dificultades es obligatorio.',
            'pacientes_ide_pac_edit.required' => 'El campo Paciente es obligatorio.',
            'fonoaudiologos_ide_fon_edit.required' => 'El campo Fonoaudiologo es obligatorio.',
        ];
    }
}
