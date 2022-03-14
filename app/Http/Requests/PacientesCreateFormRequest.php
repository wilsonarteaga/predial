<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PacientesCreateFormRequest extends FormRequest
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
            'nom_pac'  => 'required',
            'ape_pac'  => 'required',
            'tid_pac'  => 'required',
            'ide_pac'  => 'required|unique:pacientes',
            'sex_pac'  => 'required',
            'fec_pac'  => 'required',
            //'ide_acu'  => 'required',
            //'ide_tac'  => 'required',
            //'pre_paa'  => 'required'
        ];
    }

    public function messages()
    {
        return [
            'nom_pac.required' => 'El campo Nombres es obligatorio.',
            'ape_pac.required' => 'El campo Apellidos es obligatorio.',
            'tid_pac.required' => 'El campo Tipos identificación es obligatorio.',
            'ide_pac.required' => 'El campo Identificación es obligatorio.',
            'sex_pac.required' => 'El campo Género es obligatorio.',
            'fec_pac.required' => 'El campo Fecha nacimiento es obligatorio.',
            //'ide_acu.required' => 'El campo Acudiente es obligatorio.',
            //'ide_tac.required' => 'El campo Tipo acudiente es obligatorio.',
            //'pre_paa.required' => 'El campo Conocimiento es obligatorio.',
            'ide_pac.unique'   => 'La identificación ya existe.',
        ];
    }
}
