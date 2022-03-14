<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JuegosUpdateFormRequest extends FormRequest
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
            'nom_jue_edit'  => 'required',
            'mod_jue_edit'  => 'required',
            'tic_jue_edit'  => 'required',
            'ale_jue_edit'  => 'required',
            'pun_jue_edit'  => 'required',
            'tipos_juegos_ide_tju_edit'  => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nom_jue_edit.required' => 'El campo Nombre juego es obligatorio.',
            'mod_jue_edit.required' => 'El campo Modo juego es obligatorio.',
            'tic_jue_edit.required' => 'El campo Tipo calificación juego es obligatorio.',
            'ale_jue_edit.required' => 'El campo Aletorio es obligatorio.',
            'pun_jue_edit.required' => 'El campo Puntaje es obligatorio.',
            'tipos_juegos_ide_tju_edit.required' => 'El campo Tipo juego es obligatorio.',
        ];
    }
}
