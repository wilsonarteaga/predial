<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JuegosCreateFormRequest extends FormRequest
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
            'nom_jue'  => 'required',
            'mod_jue'  => 'required',
            'tic_jue'  => 'required',
            'ale_jue'  => 'required',
            'pun_jue'  => 'required',
            'ide_tju'  => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nom_jue.required' => 'El campo Nombre juego es obligatorio.',
            'mod_jue.required' => 'El campo Modo juego es obligatorio.',
            'tic_jue.required' => 'El campo Tipo calificación juego es obligatorio.',
            'ale_jue.required' => 'El campo Aleatorio es obligatorio.',
            'pun_jue.required' => 'El campo Puntaje es obligatorio.',
            'ide_tju.required' => 'El campo Tipo juego es obligatorio.',
        ];
    }
}
