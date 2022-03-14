<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RubricasCreateFormRequest extends FormRequest
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
            'ide_jue'  => 'required',
            'val_rub'  => 'required',
            'con_rub'  => 'required',
        ];
    }

    public function messages()
    {
        return [
            'ide_jue.required' => 'El campo Juego es obligatorio.',
            'val_rub.required' => 'El campo Valor es obligatorio.',
            'con_rub.required' => 'El campo Concepto es obligatorio.',
        ];
    }
}
