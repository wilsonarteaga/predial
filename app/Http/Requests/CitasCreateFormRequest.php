<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CitasCreateFormRequest extends FormRequest
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
            'fec_cit'  => 'required',
            'hor_cit'  => 'required',
            'fer_cit'  => 'required',
            'hrc_cit'  => 'required',
            'ide_pac'  => 'required',
            'ide_fon'  => 'required'
        ];
    }

    public function messages()
    {
        return [
            'fec_cit.required' => 'El campo Fecha cita es obligatorio.',
            'hor_cit.required' => 'El campo Hora cita es obligatorio.',
            'fer_cit.required' => 'El campo Fecha registro es obligatorio.',
            'hrc_cit.required' => 'El campo Hora registro es obligatorio.',
            'ide_pac.required' => 'El campo Paciente es obligatorio.',
            'ide_fon.required' => 'El campo Fonoaudiologo es obligatorio.',
        ];
    }
}
