<?php

namespace App\Http\Controllers;

use App\Models\ArchivoAsobancaria;
use App\Models\Banco;
use App\Models\Pago;
use App\Models\PredioPago;
use App\Models\Predio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use Carbon\Carbon;

class UploadController extends Controller
{
    public function uploadFileAsobancaria(Request $request) {
        if($request->file()) {
            $name = time().'_'.$request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('uploads', $name, 'public');
            $realPath = join(DIRECTORY_SEPARATOR, array(Storage::path('public'), $filePath));

            if(file_exists($realPath)) {
                $count_pagos = 0;
                $count_pagos_saved = 0;
                $count_pagos_not_saved = 0;
                $control_archivo_registros = 0;
                $control_archivo_recaudo = 0;
                $fecha_pago = '';
                $banco_archivo = '';
                $paquete_archivo = '';
                $pagos_ya_realizados = [];
                $pagos_no_realizados = [];
                $facturas_inexistentes = [];
                $objBancoArchivo = new Banco;

                // Abrir el archivo para leerlo linea a linea y guardar los pagos 1 a 1
                $getFile = fopen($realPath, "r");
                $linea = 1;
                $formato_correcto = true;
                while(!feof($getFile)) {
                    $line = fgets($getFile);
                    $tipo_registro = substr($line, 0, 2);
                    if ($linea == 1 && $tipo_registro != '01' && strlen($line) != 55) {
                        $formato_correcto = false;
                        break;
                    }
                    $linea++;
                    switch ($tipo_registro) {
                        case '01':
                            /*
                                - Registro de encabezado de archivo
                                    Tipo registro: 2
                                    Nit: 10
                                    Fecha: 8
                                    Banco: 3
                                    Numero cuenta: 17
                                    Fecha archivo: 8
                                    Hora: 4
                                    Modificador: 1
                                    Tipo cuenta: 2
                            */
                            $fecha_pago = substr($line, 12, 8);
                            $banco_archivo = substr($line, 20, 3);
                            $objBancoArchivo = DB::table('bancos')
                                                ->select('bancos.id')
                                                ->where('bancos.codigo', $banco_archivo)
                                                ->first();
                            break;
                        case '05':
                            /*
                                - Registro de encabezado de lote
                                    Tipo registro: 2
                                    Código del servicio recaudado: 13 ... EAN-13, o NIT
                                    Lote: 4
                            */
                            $paquete_archivo = substr($line, 15, 4);
                            break;
                        case '06':
                            $count_pagos += 1;
                            /*
                                - Registro de detalle
                                    Tipo de registro: 2
                                    Referencia principal del usuario: 48
                                    Valor recaudado: 14
                                    Procedencia de pago: 2
                                    Medios de pago: 2
                                    No. de Operación: 6
                                    No. de Autorización: 6
                                    Código de la entidad financiera debitada: 3
                                    Código de sucursal: 4
                                    Secuencia: 7
                            */
                            $numero_recibo = intval(substr($line, 2, 48));

                            $objPago = DB::table('pagos')
                                                ->where('numero_recibo', strval($numero_recibo))
                                                ->first();

                            if($objPago == null) {
                                $objPredioPago = DB::table('predios_pagos')
                                                    ->where('factura_pago', strval($numero_recibo))
                                                    ->first();

                                if($objPredioPago != null) {
                                    $valor_facturado = floatval(substr($line, 50, 12) . ',' . substr($line, 62, 2));
                                    $banco_factura = substr($line, 80, 3);
                                    $objBancoFactura = DB::table('bancos')
                                                        ->select('bancos.id')
                                                        ->where('bancos.codigo', $banco_factura)
                                                        ->first();

                                    // Guardar informacion de pago
                                    $pago = new Pago;
                                    $pago->fecha_pago = Carbon::createFromFormat("Ymd", $fecha_pago)->format('Y-m-d');
                                    $pago->numero_recibo = $numero_recibo;
                                    $pago->id_predio = $objPredioPago->id_predio;
                                    $pago->valor_facturado = $valor_facturado;
                                    $pago->anio_pago = $objPredioPago->ultimo_anio;
                                    $pago->fecha_factura = Carbon::createFromFormat("Y-m-d H:i:s.u", $objPredioPago->fecha_emision)->format('Y-m-d');
                                    $pago->id_banco_factura = $objBancoFactura->id;
                                    $pago->id_banco_archivo = $objBancoArchivo->id;
                                    $pago->paquete_archivo = substr($paquete_archivo, 2);
                                    $pago->origen = 'A';
                                    $saved_pago = $pago->save();

                                    if($saved_pago) {
                                        // Actualizar informacion de predio pago
                                        $pp = new PredioPago;
                                        $pp = PredioPago::find($objPredioPago->id);
                                        $pp->valor_pago = $valor_facturado;
                                        $pp->fecha_pago = Carbon::createFromFormat("Ymd", $fecha_pago)->format('Y-m-d');
                                        $pp->id_banco = $objBancoFactura->id;
                                        $pp->pagado = -1;
                                        $saved_predio_pago = $pp->save();
                                        if($saved_predio_pago) {
                                            // Actualizar ultimo anio pago en la tabla predios
                                            $predio = new Predio;
                                            $predio = Predio::find($pago->id_predio);
                                            $predio->ultimo_anio_pago = $objPredioPago->ultimo_anio;
                                            $predio->save();
                                            $count_pagos_saved += 1;
                                        }
                                        else {
                                            // ROLLBACK PAGO
                                            $count_pagos_not_saved += 1;
                                            $pago->delete();
                                        }
                                    }
                                    else {
                                        $count_pagos_not_saved += 1;
                                        array_push($pagos_no_realizados, $numero_recibo);
                                    }
                                }
                                else {
                                    $count_pagos_not_saved += 1;
                                    array_push($facturas_inexistentes, $numero_recibo);
                                }
                            }
                            else {
                                array_push($pagos_ya_realizados, $numero_recibo);
                            }

                            break;
                        case '08':
                            /*
                                - Registro de control de lote
                                    Tipo registro: 2
                                    Total registros en lote: 9
                                    Valor total recaudado en lote: 18
                                    Número de lote: 4
                            */
                            break;
                        case '09':
                            /*
                                - Registro de control de archivo
                                    Tipo registro: 2
                                    Total registros recaudados en archivo: 9
                                    Valor total recaudado en archivo: 18
                            */
                            $control_archivo_registros = floatval(substr($line, 2, 9));
                            $control_archivo_recaudo = floatval(substr($line, 11, 16) . ',' . substr($line, 27, 2));
                            break;
                        default:
                            // code to be executed if $tipo_registro is different from all labels
                            break;
                    }
                }
                fclose($getFile);

                unlink($realPath);
                //Storage::disk('public')->delete('uploads/' . $name);
                // File::delete($realPath);

                if($formato_correcto) {
                    $descripcion = '';
                    $complemento = '';
                    $error = false;
                    if ($count_pagos_not_saved > 0) {
                        $error = true;
                        $descripcion = '<br />No se pudo guardar toda la informaci&oacute;n.<br />Registros en archivo asobancaria: <b>' . $count_pagos . '</b><br />Registros guardados: <b>' . $count_pagos_saved . '</b>';

                        if(count($pagos_ya_realizados) > 0) {
                            $descripcion = $descripcion . '<br />Pagos ya registrados previamente: <b>' .
                                            count($pagos_ya_realizados) . '</b>';
                            $complemento = $complemento . '<br />Lista de pagos ya registrados: ' . implode(', ', $pagos_ya_realizados);
                        }
                        if(count($pagos_no_realizados) > 0) {
                            $descripcion = $descripcion . '<br />Pagos no registrados: <b>' .
                                            count($pagos_no_realizados) . '</b>';
                            $complemento = $complemento . '<br />Lista de facturas no registradas: ' . implode(', ', $pagos_no_realizados);
                        }
                        if(count($facturas_inexistentes) > 0) {
                            $descripcion = $descripcion . '<br />Facturas inexistentes: <b>' .
                                            count($facturas_inexistentes) . '</b>';
                            $complemento = $complemento . '<br />Lista de facturas inexistentes: ' . implode(', ', $facturas_inexistentes);
                        }
                    }
                    else {
                        if($count_pagos_saved > 0) {
                            $descripcion = '<br />La informaci&oacute;n se guard&oacute; satisfactoriamente.<br />Registros en archivo asobancaria: <b>' . $count_pagos . '</b><br />Cantidad de pagos registrados: <b>' . $count_pagos_saved . '</b>';
                        }
                        else {
                            $descripcion = '<br />No se realiz&oacute; ninguna acci&oacute;n.<br />Registros en archivo asobancaria: <b>' . $count_pagos . '</b>';
                        }
                        if(count($pagos_ya_realizados) > 0) {
                            $descripcion = $descripcion . '<br />Pagos ya registrados previamente: <b>' .
                                            count($pagos_ya_realizados) . '</b>';
                            $complemento = $complemento . '<br />Lista de pagos ya registrados: ' . implode(', ', $pagos_ya_realizados);
                        }
                    }

                    if($count_pagos_saved > 0) {
                        $file = new ArchivoAsobancaria;
                        $file->id_usuario = $request->session()->get('userid');
                        $file->path = $filePath;
                        $file->name = $name;
                        $file->type = $request->file->getClientMimeType();
                        $file->size = $request->file->getSize();
                        $file->total_registros = $count_pagos;
                        $file->total_guardados = $count_pagos_saved;
                        $file->total_existentes = count($pagos_ya_realizados);
                        $file->total_fallidos = $count_pagos_not_saved;
                        $file->descripcion = $descripcion . $complemento;
                        $file->control_archivo_registros = $control_archivo_registros;
                        $file->control_archivo_recaudo = $control_archivo_recaudo;
                        $file->save();
                    }

                    return response()->json([
                        'message'  => $descripcion,
                        'error'    => $error
                    ]);
                }
                else {
                    return response()->json([
                        'message' => '<br />Formato de archivo asobancaria incorrecto. Verifique que el archivo cargado cumpla con el est&aacute;ndar o solicite un nuevo archivo a la entidad financiera correspondiente.',
                        'error'    => true
                    ]);
                }
            }
            else {
                return response()->json([
                    'message' => 'Error cargando el archivo.',
                    'error'    => true
                ]);
            }
        }
    }
}
