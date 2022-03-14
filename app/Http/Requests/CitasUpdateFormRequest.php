<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CitasUpdateFormRequest extends FormRequest
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
            'fec_cit_edit'  => 'required',
            'hor_cit_edit'  => 'required',
            'fer_cit_edit'  => 'required',
            'hrc_cit_edit'  => 'required',
            'est_cit_edit'  => 'required',
            'pacientes_ide_pac_edit'  => 'required',
            'fonoaudiologos_ide_fon_edit'  => 'required'
        ];
    }

    public function messages()
    {
        return [
            'fec_cit_edit.required' => 'El campo Fecha cita es obligatorio.',
            'hor_cit_edit.required' => 'El campo Hora cita es obligatorio.',
            'fer_cit_edit.required' => 'El campo Fecha registro es obligatorio.',
            'hrc_cit_edit.required' => 'El campo Hora registro es obligatorio.',
            'est_cit_edit.required' => 'El campo Estado es obligatorio.',
            'pacientes_ide_pac_edit.required' => 'El campo Paciente es obligatorio.',
            'fonoaudiologos_ide_fon_edit.required' => 'El campo Fonoaudiologo es obligatorio.',
        ];
    }
}
