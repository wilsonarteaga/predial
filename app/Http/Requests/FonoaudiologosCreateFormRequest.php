<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FonoaudiologosCreateFormRequest extends FormRequest
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
            'ide_usu'  => 'required',
            'num_fon'  => 'required'
        ];
    }

    public function messages()
    {
        return [
            'ide_usu.required' => 'El campo Usuario es obligatorio.',
            'num_fon.required' => 'El campo Número de registro fonoaudiologo es obligatorio.',
        ];
    }
}
