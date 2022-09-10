<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrediosExoneracionesCreateFormRequest extends FormRequest
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
            'id_predio' => 'required',
            'id_concepto_predio' => 'required',
            'exoneracion_desde' => 'required|numeric|lte:exoneracion_hasta|min:'.(date('Y')).'|max:'.(date('Y')+50),
            'exoneracion_hasta' => 'required|numeric|gte:exoneracion_desde|min:'.(date('Y')).'|max:'.(date('Y')+50),
            'escritura' => 'required|size:10',
            'matricula' => 'required|size:11',
            'certificado_libertad' => 'required|size:10'
        ];
    }

    public function messages()
    {
        return [
            'id_predio.required' => 'El campo codigo predio es obligatorio.',
            'id_concepto_predio.required' => 'El campo concepto predio es obligatorio.',
            'exoneracion_desde.required' => 'El campo exoneración desde es obligatorio.',
            'exoneracion_desde.min' => 'Mínimo año permitido :min',
            'exoneracion_desde.max' => 'Máximo año permitido :max',
            'exoneracion_desde.lte' => 'Exoneración desde debe ser menor o igual a Exoneración hasta.',
            'exoneracion_hasta.required' => 'El campo exoneración hasta es obligatorio.',
            'exoneracion_hasta.min' => 'Mínimo año permitido :min',
            'exoneracion_hasta.max' => 'Máximo año permitido :max',
            'exoneracion_hasta.gte' => 'Exoneración hasta debe ser mayor o igual a Exoneración desde.',
            'escritura.required' => 'El campo escritura es obligatorio.',
            'escritura.size' => 'El campo escritura debe contener :size digitos.',
            'matricula.required' => 'El campo matricula es obligatorio.',
            'matricula.size' => 'El campo matricula debe contener :size digitos.',
            'certificado_libertad.required' => 'El campo certificado de libertad es obligatorio.',
            'certificado_libertad.size' => 'El campo certificado de libertad debe contener :size digitos.'
        ];
    }
}
