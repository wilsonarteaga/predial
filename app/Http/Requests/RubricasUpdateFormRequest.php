<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RubricasUpdateFormRequest extends FormRequest
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
            'juegos_ide_jue_edit'  => 'required',
            'val_rub_edit'  => 'required',
            'con_rub_edit'  => 'required',
        ];
    }

    public function messages()
    {
        return [
            'juegos_ide_jue_edit.required' => 'El campo Juego es obligatorio.',
            'val_rub_edit.required' => 'El campo Valor es obligatorio.',
            'con_rub_edit.required' => 'El campo Concepto es obligatorio.',
        ];
    }
}
