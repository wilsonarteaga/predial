<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AniosCreateFormRequest extends FormRequest
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
            'anio'  => 'required',
            'id_estado'  => 'required',
            'meses_amnistia'  => 'required'
        ];
    }

    public function messages()
    {
        return [
            'anio.required' => 'El campo año es obligatorio.',
            'id_estado.required' => 'El campo estado es obligatorio.',
            'meses_amnistia.required' => 'El campo meses amnistia es obligatorio.'
        ];
    }
}
