<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuariosUpdateFormRequest extends FormRequest
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
            'nom_usu_edit'  => 'required',
            'ape_usu_edit'  => 'required',
            'tid_usu_edit'  => 'required',
            'ide_usu_edit'  => 'required',
            'cor_usu_edit'  => 'required|email|unique:usuarios,cor_usu,'. $this->ide_usu_edit . ',ide_usu',
            'fec_usu_edit'  => 'required',
            'tel_usu_edit'  => 'required',
            'dir_usu_edit'  => 'required',
            'con_usu_edit'  => 'required|string|min:6|confirmed',
            'con_usu_edit_confirmation' => 'required|same:con_usu_edit',
            'tipos_usuarios_ide_tip_edit'  => 'required',
            'est_usu_edit'  => 'required',
        ];
    }

    public function  messages() {
        return [
            'nom_usu_edit.required' => 'El campo Nombres es obligatorio.',
            'ape_usu_edit.required' => 'El campo Apellidos es obligatorio.',
            'tid_usu_edit.required' => 'El campo Tipos identificación es obligatorio.',
            'ide_usu_edit.required' => 'El campo Identificación es obligatorio.',
            'cor_usu_edit.required' => 'El campo Correo electrónico es obligatorio.',
            'cor_usu_edit.email'   => 'El correo electrónico es inválido.',
            'cor_usu_edit.unique'   => 'El correo electrónico ya existe.',
            'fec_usu_edit.required' => 'El campo Fecha nacimiento es obligatorio.',
            'tel_usu_edit.required' => 'El campo Teléfono es obligatorio.',
            'dir_usu_edit.required' => 'El campo Dirección es obligatorio.',
            'con_usu_edit.required' => 'El campo Nueva contraseña es obligatorio.',
            'con_usu_edit.min'      => 'La nueva contraseña es muy corta.',
            'con_usu_edit_confirmation.required' => 'El campo Repita la nueva contraseña es obligatorio.',
            'con_usu_edit.confirmed' => 'La confirmación de contraseña es erronea.',
            'con_usu_edit_confirmation.same' => 'La confirmación de contraseña es erronea.',
            'tipos_usuarios_ide_tip_edit.required' => 'El campo Tipo usuario es obligatorio.',
            'est_usu_edit.required' => 'El campo Estado es obligatorio.',
        ];
    }
}
