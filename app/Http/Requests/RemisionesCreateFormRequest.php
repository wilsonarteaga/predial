<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RemisionesCreateFormRequest extends FormRequest
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
            'mot_rem'  => 'required',
            'don_rem'  => 'required',
            'ide_pac'  => 'required',
            'ide_fon'  => 'required'
        ];
    }

    public function messages()
    {
        return [
            'mot_rem.required' => 'El campo Motivo es obligatorio.',
            'don_rem.required' => 'El campo Lugar de remisión es obligatorio.',
            'ide_pac.required' => 'El campo Paciente es obligatorio.',
            'ide_fon.required' => 'El campo Fonoaudiologo es obligatorio.',
        ];
    }
}
