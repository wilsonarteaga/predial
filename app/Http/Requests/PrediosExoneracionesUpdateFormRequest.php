<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrediosExoneracionesUpdateFormRequest extends FormRequest
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
            //'id_predio_edit' => 'required',
            'id_concepto_predio_edit' => 'required',
            'exoneracion_desde_edit' => 'required|numeric|lte:exoneracion_hasta_edit|min:'.(date('Y')).'|max:'.(date('Y')+50),
            'exoneracion_hasta_edit' => 'required|numeric|gte:exoneracion_desde_edit|min:'.(date('Y')).'|max:'.(date('Y')+50),
            'escritura_edit' => 'required|size:10',
            'matricula_edit' => 'required|size:11',
            'certificado_libertad_edit' => 'required|size:10'
        ];
    }

    public function messages()
    {
        return [
            //'id_predio_edit.required' => 'El campo código predio es obligatorio.',
            'id_concepto_predio_edit.required' => 'El campo concepto predio es obligatorio.',
            'exoneracion_desde_edit.required' => 'El campo exoneración desde es obligatorio.',
            'exoneracion_desde_edit.min' => 'Mínimo año permitido :min',
            'exoneracion_desde_edit.max' => 'Máximo año permitido :max',
            'exoneracion_desde_edit.lte' => 'Exoneración desde debe ser menor o igual a Exoneración hasta.',
            'exoneracion_hasta_edit.required' => 'El campo exoneración hasta es obligatorio.',
            'exoneracion_hasta_edit.min' => 'Mínimo año permitido :min',
            'exoneracion_hasta_edit.max' => 'Máximo año permitido :max',
            'exoneracion_hasta_edit.gte' => 'Exoneración hasta debe ser mayor o igual a Exoneración desde.',
            'escritura_edit.required' => 'El campo escritura es obligatorio.',
            'escritura_edit.size' => 'El campo escritura debe contener :size digitos.',
            'matricula_edit.required' => 'El campo matricula es obligatorio.',
            'matricula_edit.size' => 'El campo matricula debe contener :size digitos.',
            'certificado_libertad_edit.required' => 'El campo certificado de libertad es obligatorio.',
            'certificado_libertad_edit.size' => 'El campo certificado de libertad debe contener :size digitos.'
        ];
    }
}
