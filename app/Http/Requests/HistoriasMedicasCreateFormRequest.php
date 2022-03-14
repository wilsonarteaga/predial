<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HistoriasMedicasCreateFormRequest extends FormRequest
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
            'fec_hme'  => 'required',
            'num_hme'  => 'required',
            'mot_hme'  => 'required',
            'dif_hme'  => 'required',
            'ide_pac'  => 'required',
            'ide_fon'  => 'required'
        ];
    }

    public function messages()
    {
        return [
            'fec_hme.required' => 'El campo Fecha es obligatorio.',
            'num_hme.required' => 'El campo Número es obligatorio.',
            'mot_hme.required' => 'El campo Motivo es obligatorio.',
            'dif_hme.required' => 'El campo Dificultades es obligatorio.',
            'ide_pac.required' => 'El campo Paciente es obligatorio.',
            'ide_fon.required' => 'El campo Fonoaudiologo es obligatorio.',
        ];
    }
}
