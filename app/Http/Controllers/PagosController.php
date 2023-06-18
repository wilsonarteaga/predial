<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PagosCreateFormRequest;
use App\Http\Requests\PagosUpdateFormRequest;
use App\Models\Pago;
use App\Models\Opcion;
use App\Models\PredioPago;
use App\Models\Predio;
use App\Models\PagosAud;

use Carbon\Carbon;

class PagosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id) {
        if (!$request->session()->exists('userid')) {
            return redirect('/');
        }
        $opcion = Opcion::where('id','=', base64_decode($id))->first();

        // $predios = DB::table('predios')
        //                     ->select('predios.id', 'predios.codigo_predio')
        //                     ->get();

        $bancos = DB::table('bancos')
                            ->select('bancos.id', 'bancos.codigo', 'bancos.asobancaria', 'bancos.nombre')
                            ->get();

        // $pagos = DB::table('pagos')->join('bancos', function ($join) {
        //             $join->on('pagos.id_banco_factura', '=', 'bancos.id');
        //         })
        //         ->select('pagos.*', 'bancos.nombre as banco')
        //         ->get();

        // $pagos = DB::table('pagos')->join('bancos', function ($join) use($request){
        //             $join->on('pagos.id_banco_factura', '=', 'bancos.id')
        //            ->where ('pagos.fecha_pago','=',$request->fecha_pago)
        //            ->where('pagos.id_banco_factura','=',$request->id_banco);
        //         })
        //         ->select('pagos.*', 'bancos.nombre as banco')
        //         ->get();

        $tab_current = 'li-section-bar-1';
        if ($request->has('page')) {
            $tab_current = 'li-section-bar-2';
        }

         //$request->session()->put('search', '1');

        $current_time = Carbon::now()->timestamp;

        return view('pagos.create', ['opcion' => $opcion,
                                    //'pagos' => $pagos,
                                    //'predios' => $predios,
                                    'bancos' => $bancos,
                                    'current_time' => $current_time,
                                    'tab_current' => $tab_current]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PagosCreateFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PagosCreateFormRequest $request) {
        if (!$request->session()->exists('userid')) {
            return redirect('/');
        }

        $tab_current = 'li-section-bar-1';

        DB::beginTransaction();
        try {
            // Verificar si el registro ya existe
            $max_pago = DB::table('predios_pagos')
                                ->selectRaw("MAX(predios_pagos.ultimo_anio) as ultimo_anio")
                                ->where('predios_pagos.factura_pago', $request->numero_recibo)
                                ->where('predios_pagos.pagado', 0)
                                ->first();

            $predios_pago = DB::table('predios_pagos')
                                ->selectRaw("predios_pagos.primer_fecha, predios_pagos.segunda_fecha, predios_pagos.tercera_fecha")
                                ->where('predios_pagos.factura_pago', $request->numero_recibo)
                                ->where('predios_pagos.pagado', 0)
                                ->where('predios_pagos.ultimo_anio', $max_pago->ultimo_anio)
                                ->first();

            if($predios_pago != null) {
                $pago = new Pago();
                $pago->fecha_pago = $request->fecha_pago;
                $pago->codigo_barras = $request->filled('codigo_barras') ? $request->codigo_barras : NULL;
                $pago->numero_recibo = $request->numero_recibo;
                $pago->id_predio = $request->id_predio;
                $pago->valor_facturado = $request->valor_facturado;
                $pago->anio_pago = $request->anio_pago;
                $pago->fecha_factura = $request->fecha_factura;
                $pago->id_banco_factura = $request->id_banco_factura;
                $pago->id_banco_archivo = $request->filled('id_banco_archivo') ? $request->id_banco_archivo : NULL;
                $pago->paquete_archivo = $request->filled('paquete_archivo') ? $request->paquete_archivo : NULL;
                $pago->origen = 'M';
                $pago->save();

                // if($query) {
                    $updated = PredioPago::where('factura_pago', $request->numero_recibo)
                                            ->where('pagado', 0)
                                            ->update([
                                                'fecha_pago' => $request->fecha_pago,
                                                'valor_pago' => DB::raw("CASE WHEN CONVERT(datetime, '" . $request->fecha_pago . " 00:00:00.000') <= CONVERT(datetime, '" . $predios_pago->primer_fecha . "') THEN total_calculo WHEN CONVERT(datetime, '" . $request->fecha_pago . " 00:00:00.000') <= CONVERT(datetime, '" . $predios_pago->segunda_fecha . "') THEN total_dos WHEN CONVERT(datetime, '" . $request->fecha_pago . " 00:00:00.000') <= CONVERT(datetime, '" . $predios_pago->tercera_fecha . "') THEN total_tres ELSE total_calculo END"),
                                                'id_banco' => $request->id_banco_factura,
                                                'pagado' => -1
                                            ]);

                    // if($updated > 0) {

                        // Actualizar ultimo anio pago en la tabla predios
                        $predio = new Predio;
                        $predio = Predio::find($pago->id_predio);
                        $predio->ultimo_anio_pago = $request->anio_pago;
                        $predio->save();

                        DB::commit();

                        return back()->with(['success' => 'La informaci&oacute;n se guard&oacute; satisfactoriamente.', 'tab_current' => $tab_current]);
                    // }
                    // else {
                    //     $pago->delete();
                    //     return back()->with(['fail' => 'No se pudo guardar la informaci&oacute;n de asociaci&oacute;n predio - pago. Intente nuevamente.', 'tab_current' => $tab_current]);
                    // }
                // }
                // else {
                //     return back()->with(['fail' => 'No se pudo guardar la informaci&oacute;n del pago. Intente nuevamente.', 'tab_current' => $tab_current]);
                // }
            }
            else {
                return back()->with(['fail' => 'No existe informaci&oacute;n de asociaci&oacute;n predio - pago. Intente nuevamente.', 'tab_current' => $tab_current]);
            }
        }
        catch(\Exception $e) {
          DB::rollback();
          return back()->with(['fail' => $e->getMessage(), 'tab_current' => $tab_current]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PagosUpdateFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(PagosUpdateFormRequest $request) {
        if (!$request->session()->exists('userid')) {
            return redirect('/');
        }

        $pago = new Pago();
        $pago = Pago::find($request->id_edit);
        $pago->fecha_pago = $request->fecha_pago_edit;
        $pago->codigo_barras = $request->codigo_barras_edit;
        $pago->numero_recibo = $request->numero_recibo_edit;
        $pago->id_predio = $request->id_predio_edit;
        $pago->valor_facturado = $request->valor_facturado_edit;
        $pago->anio_pago = $request->anio_pago_edit;
        $pago->fecha_factura = $request->fecha_factura_edit;
        $pago->id_banco_factura = $request->id_banco_factura_edit;
        $pago->id_banco_archivo = $request->filled('id_banco_archivo_edit') ? $request->id_banco_archivo_edit : NULL;
        $pago->paquete_archivo = $request->filled('paquete_archivo_edit') ? $request->paquete_archivo_edit : NULL;
        $query = $pago->save();
        $tab_current = 'li-section-bar-2';

        if($query) {
            return back()->with(['success' => 'La informaci&oacute;n se actualiz&oacute; satisfactoriamente.', 'tab_current' => $tab_current]);
        }
        else {
            return back()->with(['fail' => 'No se pudo actualizar la informaci&oacute;n. Intente nuevamente.', 'tab_current' => $tab_current]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request) {
        if (!$request->session()->exists('userid')) {
            return redirect('/');
        }

        $countPagos = DB::table('pagos')
                            ->select(DB::raw('count(*) as cm_count')) // verificar si ya esta relacionada con otras tablas
                            ->where('id', $request->input_delete)->first();

        $tab_current = 'li-section-bar-2';
        $pago = new Pago();
        $pago = Pago::find($request->input_delete);

        //if($countPagos->cm_count == 0) {
            $query = $pago->delete();
            if($query) {
                return back()->with(['success' => 'El registro se elimin&oacute; satisfactoriamente.', 'tab_current' => $tab_current]);
            }
            else {
                return back()->with(['fail' => 'No se pudo eliminar la informaci&oacute;n. Intente nuevamente.', 'tab_current' => $tab_current]);
            }
        // }
        // else {
        //     return back()->with(['fail' => 'No se pudo eliminar la informaci&oacute;n. La clase de mutaci&oacute;n <b>' . $pago->nombre . ' (' . $pago->codigo . ')</b> ya posee informaci&oacute;n asociada.', 'tab_current' => $tab_current]);
        // }
    }

    public function list_pagos_fecha(Request $request) {
        $pagos = DB::table('pagos')->join('bancos', function ($join) {
                            $join->on('pagos.id_banco_factura', '=', 'bancos.id');
                        })
                        ->where('fecha_pago', Carbon::createFromFormat("Y-m-d", $request->fecha_pago)->format('Y-m-d'))
                        ->where('id_banco_factura', $request->id_banco_factura)
                        ->select('pagos.*', 'bancos.nombre as banco')
                        ->orderBy('fecha_pago', 'asc')
                        ->get();

        $logs = DB::table('archivos_asobancaria')
                        ->leftJoin('bancos', 'bancos.id', '=', 'archivos_asobancaria.id_banco')
                        ->leftJoin('usuarios', 'usuarios.id', '=', 'archivos_asobancaria.id_usuario')
                        ->where('fecha_pago', Carbon::createFromFormat("Y-m-d", $request->fecha_pago)->format('Y-m-d'))
                        ->where('id_banco', $request->id_banco_factura)
                        ->select(DB::raw("archivos_asobancaria.*, CONCAT(usuarios.nombres, ' ', usuarios.apellidos) as usuario, CONCAT(bancos.nombre, ' (', bancos.asobancaria, ')') as banco"))
                        ->get();
        return response()->json([
            'pagos' => $pagos,
            'logs' => $logs
        ]);
    }

    public function get_info_pago(Request $request) {
        $data = json_decode($request->form);
        $fecha = $data->{'fecha_pago'};
        $predio_pago = DB::table('predios_pagos')
                        ->join('predios', 'predios.id', '=', 'predios_pagos.id_predio')
                        ->leftJoin('pagos', 'pagos.numero_recibo', '=', 'predios_pagos.factura_pago')
                        ->select(DB::raw("predios_pagos.id_predio, MAX(predios_pagos.ultimo_anio) as ultimo_anio, CASE WHEN CONVERT(datetime, '" . $fecha . " 00:00:00.000') <= MAX(predios_pagos.primer_fecha) THEN SUM(predios_pagos.total_calculo) WHEN CONVERT(datetime, '" . $fecha . " 00:00:00.000') <= MAX(predios_pagos.segunda_fecha) THEN SUM(predios_pagos.total_dos) WHEN CONVERT(datetime, '" . $fecha . " 00:00:00.000') <= MAX(predios_pagos.tercera_fecha) THEN SUM(predios_pagos.total_tres) ELSE SUM(predios_pagos.total_calculo) END as valor_pago, MAX(predios_pagos.fecha_emision) as fecha_pago, predios_pagos.pagado, predios.codigo_predio, pagos.id_banco_archivo, pagos.paquete_archivo, pagos.codigo_barras"))
                        ->where('factura_pago', $data->{'factura_pago'})
                        ->groupBy('predios_pagos.id_predio', 'predios_pagos.pagado', 'predios.codigo_predio', 'pagos.id_banco_archivo', 'pagos.paquete_archivo', 'pagos.codigo_barras')
                        ->orderBy('ultimo_anio', 'desc')
                        ->get();
        if(count($predio_pago) > 0)
            return response()->json([$predio_pago[0]]);
        else
            return response()->json([]);
    }

    public function store_pagos_delete(Request $request) {
        $data = json_decode($request->form);

        DB::beginTransaction();
        try {
            $prev_pago = DB::table('pagos')
                                    ->select('pagos.*')
                                    ->where('pagos.id', $data->{'id'})
                                    ->first();

            // Eliminar el pago
            $deleted = Pago::where('id', $prev_pago->id)
                       ->delete();

            if($deleted) {
                $pago = new PagosAud();
                $pago->id_pago = $prev_pago->id;
                $pago->fecha_pago = $prev_pago->fecha_pago;
                $pago->codigo_barras = $prev_pago->codigo_barras;
                $pago->numero_recibo = $prev_pago->numero_recibo;
                $pago->id_predio = $prev_pago->id_predio;
                $pago->valor_facturado = $prev_pago->valor_facturado;
                $pago->anio_pago = $prev_pago->anio_pago;
                $pago->fecha_factura = $prev_pago->fecha_factura;
                $pago->id_banco_factura = $prev_pago->id_banco_factura;
                $pago->id_banco_archivo = $prev_pago->id_banco_archivo;
                $pago->paquete_archivo = $prev_pago->paquete_archivo;
                $pago->origen = $prev_pago->origen;
                $pago->id_usuario_elimina = $request->session()->get('userid');
                $pago->save();

                $updated = PredioPago::where('factura_pago', $prev_pago->numero_recibo)
                ->update([
                    'valor_pago' => 0,
                    'fecha_pago' => null,
                    'id_banco' => null,
                    'pagado' => 0
                ]);

                $pagos = DB::table('pagos')->join('bancos', function ($join) {
                    $join->on('pagos.id_banco_factura', '=', 'bancos.id');
                })
                ->where('fecha_pago', Carbon::createFromFormat("Y-m-d", $data->{'fecha_pago'})->format('Y-m-d'))
                ->where('id_banco_factura', $data->{'id_banco_factura'})
                ->select('pagos.*', 'bancos.nombre as banco')
                ->orderBy('fecha_pago', 'asc')
                ->get();

                DB::commit();

                return response()->json([
                    'pagos' => $pagos,
                    'message' => 'La información del pago se eliminó satisfactoriamente.',
                    'error' => false
                ]);
            }
            else {
                DB::rollback();
                return response()->json([
                    'message' => 'No se pudo eliminar la información del pago. Contacte al administrador del sistema.',
                    'error' => true
                ]);
            }
        }
        catch(\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => $e,
                'error' => true
            ]);
        }
    }

    public function get_info_recibo(Request $request) {
        $numero_recibo = $request->numero_recibo;
        $info_recibo = DB::table('pagos')
                        ->leftJoin('predios_pagos', 'pagos.numero_recibo', '=', 'predios_pagos.factura_pago')
                        ->leftJoin('bancos', 'bancos.id', '=', 'predios_pagos.id_banco')
                        ->select(DB::raw("COUNT(predios_pagos.factura_pago) as anios_pagados, predios_pagos.id_predio, predios_pagos.factura_pago as numero, MAX(predios_pagos.ultimo_anio) as anio, predios_pagos.fecha_emision as fecha_emision, CASE WHEN TRY_CONVERT(DATE, predios_pagos.fecha_emision) <= TRY_CONVERT(DATE, MAX(predios_pagos.primer_fecha)) THEN MAX(predios_pagos.primer_fecha) WHEN TRY_CONVERT(DATE, predios_pagos.fecha_emision) <= TRY_CONVERT(DATE, MAX(predios_pagos.segunda_fecha)) THEN MAX(predios_pagos.segunda_fecha) WHEN TRY_CONVERT(DATE, predios_pagos.fecha_emision) <= TRY_CONVERT(DATE, MAX(predios_pagos.tercera_fecha)) THEN MAX(predios_pagos.tercera_fecha) ELSE MAX(predios_pagos.primer_fecha) END as fecha_vencimiento, MAX(predios_pagos.avaluo) as valor_avaluo, SUM(predios_pagos.valor_pago) as valor_factura, IIF(predios_pagos.anulada = 0, 'NO', 'SI') as anulado, IIF(predios_pagos.pagado < 0, 'SI', 'NO') as pagado, MAX(predios_pagos.fecha_pago) as fecha_pago, CONCAT(bancos.codigo, ' - ', bancos.nombre, ' (', bancos.asobancaria, ')') as banco"))
                        ->where('pagos.numero_recibo', $numero_recibo)
                        ->groupBy('predios_pagos.id_predio', 'predios_pagos.factura_pago', 'predios_pagos.fecha_emision', 'predios_pagos.anulada', 'predios_pagos.pagado', 'bancos.codigo', 'bancos.nombre', 'bancos.asobancaria')
                        ->get();
        if(count($info_recibo) > 0)
            return response()->json([$info_recibo[0]]);
        else
            return response()->json([]);
    }
}
