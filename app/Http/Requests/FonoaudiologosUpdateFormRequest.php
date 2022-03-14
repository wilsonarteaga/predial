<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FonoaudiologosUpdateFormRequest extends FormRequest
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
            'usuarios_ide_usu_edit'  => 'required',
            'num_fon_edit'  => 'required'
        ];
    }

    public function messages()
    {
        return [
            'usuarios_ide_usu_edit.required' => 'El campo Usuario es obligatorio.',
            'num_fon_edit.required' => 'El campo Número de registro fonoaudiologo es obligatorio.',
        ];
    }
}
