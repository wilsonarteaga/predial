<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuariosCreateFormRequest extends FormRequest
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
            'nom_usu'  => 'required',
            'ape_usu'  => 'required',
            'tid_usu'  => 'required',
            'ide_usu'  => 'required|unique:usuarios,ide_usu',
            'cor_usu'  => 'required|email|unique:usuarios,cor_usu',
            'fec_usu'  => 'required',
            'tel_usu'  => 'required',
            'dir_usu'  => 'required',
            'con_usu'  => 'required|string|min:6|confirmed',
            'con_usu_confirmation' => 'required|same:con_usu',
            'ide_tip'  => 'required',
            'est_usu'  => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nom_usu.required' => 'El campo Nombres es obligatorio.',
            'ape_usu.required' => 'El campo Apellidos es obligatorio.',
            'tid_usu.required' => 'El campo Tipos identificación es obligatorio.',
            'ide_usu.required' => 'El campo Identificación es obligatorio.',
            'cor_usu.required' => 'El campo Correo electrónico es obligatorio.',
            'cor_usu.unique'   => 'El correo electrónico ya existe.',
            'cor_usu.email'    => 'El correo electrónico es inválido.',
            'fec_usu.required' => 'El campo Fecha nacimiento es obligatorio.',
            'tel_usu.required' => 'El campo Teléfono es obligatorio.',
            'dir_usu.required' => 'El campo Dirección es obligatorio.',
            'ide_usu.unique'   => 'La identificación ya existe.',
            'con_usu.required' => 'El campo Nueva contraseña es obligatorio.',
            'con_usu.min'      => 'La nueva contraseña es muy corta.',
            'con_usu_confirmation.required' => 'El campo Repita la nueva contraseña es obligatorio.',
            'con_usu.confirmed' => 'La confirmación de contraseña es erronea.',
            'con_usu_confirmation.same' => 'La confirmación de contraseña es erronea.',
            'ide_tip.required' => 'El campo Tipo usuario es obligatorio.',
            'est_usu.required' => 'El campo Estado es obligatorio.',
        ];
    }
}
