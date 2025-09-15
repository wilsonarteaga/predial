<?php

namespace App\Http\Controllers;

use App\Models\QrValidation;
use Illuminate\Http\Request;
use Carbon\Carbon;

class QrValidationController extends Controller
{
    public function validateQr(Request $request, $token)
    {
        $qrValidation = QrValidation::where('token', $token)->first();

        if (!$qrValidation) {
            return view('qr.validation-result', [
                'status' => 'invalid',
                'message' => 'El código QR no es válido o no existe en nuestros registros.',
                'title' => 'Código QR Inválido'
            ]);
        }

        if ($qrValidation->is_validated) {
            return view('qr.validation-result', [
                'status' => 'already_used',
                'message' => 'Este código QR ya ha sido validado anteriormente. Para evitar el uso fraudulento de certificados copiados, cada QR solo puede validarse una vez.',
                'title' => 'PAZ Y SALVO Ya Validado',
                'validation_data' => [
                    'validated_at' => $qrValidation->validated_at->format('d/m/Y H:i:s'),
                    'certificado_numero' => $qrValidation->certificado_numero
                ]
            ]);
        }

        if ($qrValidation->isExpired()) {
            return view('qr.validation-result', [
                'status' => 'expired',
                'message' => 'Este PAZ Y SALVO ha expirado. Los códigos QR son válidos hasta el 31 de diciembre del año de expedición (' . $qrValidation->fecha_validez->format('d/m/Y') . ').',
                'title' => 'PAZ Y SALVO Expirado',
                'validation_data' => [
                    'fecha_validez' => $qrValidation->fecha_validez->format('d/m/Y'),
                    'certificado_numero' => $qrValidation->certificado_numero
                ]
            ]);
        }

        // Mark as validated
        $qrValidation->markAsValidated($request);

        return view('qr.validation-result', [
            'status' => 'valid',
            'message' => 'El PAZ Y SALVO es válido y auténtico. Este código QR ha sido marcado como validado y no podrá ser usado nuevamente.',
            'title' => 'PAZ Y SALVO Válido',
            'validation_data' => [
                'certificado_numero' => $qrValidation->certificado_numero,
                'propietario_principal' => $qrValidation->propietario_principal,
                'fecha_expedicion' => $qrValidation->fecha_expedicion->format('d/m/Y'),
                'fecha_validez' => $qrValidation->fecha_validez->format('d/m/Y'),
                'validated_at' => now()->format('d/m/Y H:i:s'),
                'predio' => $qrValidation->predio
            ]
        ]);
    }
}