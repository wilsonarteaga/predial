<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\Http\Requests\PrediosCreateFormRequest;
use App\Http\Requests\PrediosUpdateFormRequest;
use App\Models\Predio;
use App\Models\Opcion;
use App\Models\PredioAbono;
use App\Models\PredioAcuerdoPago;
use App\Models\PredioCalculo;
use App\Models\PredioDato;
use App\Models\PredioPago;
use App\Models\PredioPropietario;
use App\Models\Propietario;
use App\Models\Resolucion;
use App\Models\ResolucionPredio;
use App\Models\PrescripcionPredio;

use Carbon\Carbon;

class PrediosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
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
        $predios = DB::table('predios')->join('zonas', function ($join) {
                        $join->on('predios.id_zona', '=', 'zonas.id');
                    })
                    ->select('predios.*', 'zonas.descripcion')
                    ->where('estado', 1)
                    ->get(); //paginate(5);

        //dd($predios);

        $propietarios = DB::table('predios')->join('predios_propietarios', 'predios.id', '=', 'predios_propietarios.id_predio')
                                     ->join('propietarios', 'propietarios.id', '=', 'predios_propietarios.id_propietario')
                                     ->join('zonas', 'zonas.id', '=', 'predios.id_zona')
                ->select(DB::raw('predios_propietarios.id_predio, STRING_AGG(CONCAT(propietarios.nombre, \' - \', propietarios.identificacion), \'<br />\') AS propietarios'))
                ->where('predios.estado', 1)
                ->groupBy('predios_propietarios.id_predio')
                ->get();

        if($propietarios) {
            foreach ($predios as $key => $predio) {
                $desired_object = self::findInCollection($propietarios, 'id_predio', $predio->id);
                if($desired_object) {
                    $predio->propietarios = $desired_object->propietarios;
                }
                else {
                    $predio->propietarios = 'Sin asignar';
                }
            }
        }
        else {
            foreach ($predios as $key => $predio) {
                $predio->propietarios = 'Sin asignar';
            }
        }

        $zonas = DB::table('zonas')
                    ->select('zonas.id', 'zonas.descripcion')
                    ->get();
        $tipos_predio = DB::table('tipos_predio')
                            ->select('tipos_predio.id', 'tipos_predio.nombre')
                            ->get();
        $clases_predio = DB::table('clases_predio')
                            ->select('clases_predio.id', 'clases_predio.nombre')
                            ->get();
        $clases_mutacion = DB::table('clases_mutacion')
                            ->select('clases_mutacion.id', 'clases_mutacion.nombre')
                            ->get();
        $tarifas_predial = DB::table('tarifas_predial')
                            ->select('tarifas_predial.id', 'tarifas_predial.descripcion', 'tarifas_predial.anio', 'tarifas_predial.codigo', 'tarifas_predial.tarifa')
                            ->get();
        $bancos = DB::table('bancos')
                            ->select('bancos.id', 'bancos.codigo', 'bancos.asobancaria', 'bancos.nombre')
                            ->get();

        $tab_current = 'li-section-bar-1';
        if ($request->has('page')) {
            $tab_current = 'li-section-bar-2';
        }

        //$request->session()->put('display_buttons', '1');

        return view('predios.create', ['opcion' => $opcion,
                                     'predios' => $predios,
                                     'zonas' => $zonas,
                                     'tipos_predio' => $tipos_predio,
                                     'clases_predio' => $clases_predio,
                                     'clases_mutacion' => $clases_mutacion,
                                     'tarifas_predial' => $tarifas_predial,
                                     'bancos' => $bancos,
                                     'tab_current' => $tab_current]);
    }

    public static function findInCollection(Collection $collection, $key, $value) {
        foreach ($collection as $item) {
            if (isset($item->$key) && $item->$key == $value) {
                return $item;
            }
        }
        return FALSE;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PrediosCreateFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PrediosCreateFormRequest $request) {
        if (!$request->session()->exists('userid')) {
            return redirect('/');
        }

        $predio = new Predio();
        $predio->codigo_predio = $request->codigo_predio;
        $predio->tipo = $request->tipo;
        $predio->sector = $request->sector;
        $predio->manzana = $request->manzana;
        $predio->predio = $request->predio;
        $predio->mejora = $request->mejora;
        $predio->id_zona = $request->id_zona;
        $predio->direccion = $request->direccion;
        $predio->area_metros = $request->area_metros;
        $predio->area_construida = $request->area_construida;
        $predio->area_hectareas = $request->area_hectareas;
        $predio->tarifa_actual = $request->tarifa_actual;
        $predio->avaluo = $request->avaluo;
        $predio->ultimo_anio_pago = $request->ultimo_anio_pago;
        $query = $predio->save();
        $tab_current = 'li-section-bar-1';

        if($query) {
            return back()->with(['success' => 'La informaci&oacute;n se guard&oacute; satisfactoriamente.', 'tab_current' => $tab_current]);
        }
        else {
            return back()->with(['fail' => 'No se pudo guardar la informaci&oacute;n. Intente nuevamente.', 'tab_current' => $tab_current]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PrediosUpdateFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(PrediosUpdateFormRequest $request) {
        if (!$request->session()->exists('userid')) {
            return redirect('/');
        }

        $tab_current = 'li-section-bar-2';
        $predio = new Predio();
        $predio_tmp = new Predio();
        $predio = Predio::find($request->id_edit);
        $predio->codigo_predio = $request->codigo_predio_edit;
        $predio->id_zona = $request->id_zona_edit;
        $predio->direccion = $request->direccion_edit;
        $predio->area_metros = $request->area_metros_edit;
        $predio->area_construida = $request->area_construida_edit;
        $predio->area_hectareas = $request->area_hectareas_edit;
        $predio->tarifa_actual = str_replace(",", "", $request->tarifa_actual_edit);
        $predio->avaluo = str_replace(",", "", $request->avaluo_edit);
        $predio->ultimo_anio_pago = $request->ultimo_anio_pago_edit;
        $query = $predio->save();

        if($query) {
            $resolucion = new Resolucion();
            $resolucion->numero_resolucion = $request->numero_resolucion;
            $resolucion->fecha_resolucion = Carbon::createFromFormat("Y-m-d", $request->fecha_resolucion)->format('Y-m-d');
            $resolucion->firma_resolucion = strtoupper($request->firma_resolucion);
            $query = $resolucion->save();
            if($query) {
                $resolucion_predio = new ResolucionPredio();
                $resolucion_predio->id_predio = $predio->id;
                $resolucion_predio->id_resolucion = $resolucion->id;
                $resolucion_predio->id_usuario = $request->session()->get('userid');
                $resolucion_predio->descripcion = 'Actualización predio ' . $predio->codigo_predio;

                $query = $resolucion_predio->save();
                if($query) {
                    return back()->with(['success' => 'La informaci&oacute;n se actualiz&oacute; satisfactoriamente.', 'tab_current' => $tab_current]);
                }
                else {
                    $resolucion->delete();
                    $query = $predio_tmp->save();
                    return back()->with(['fail' => 'No se pudo generar la informaci&oacute;n de resoluci&oacute;n predio. Intente nuevamente.', 'tab_current' => $tab_current]);
                }
            }
            else {
                $query = $predio_tmp->save();
                return back()->with(['fail' => 'No se pudo generar la informaci&oacute;n de resoluci&oacute;n. Intente nuevamente.', 'tab_current' => $tab_current]);
            }
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

        $countPredios = DB::table('predios')
                            ->select(DB::raw('count(*) as cm_count')) // verificar si ya esta relacionada con otras tablas
                            ->where('id', $request->input_delete)
                            ->where('estado', 1)->first();

        $tab_current = 'li-section-bar-2';
        $predio = new Predio();
        $predio = Predio::find($request->input_delete);

        if($countPredios->cm_count > 0) {
            $predio->estado = 0;
            $query = $predio->save();
            if($query) {
                $resolucion = new Resolucion();
                $resolucion->numero_resolucion = $request->numero_resolucion;
                $resolucion->fecha_resolucion = Carbon::createFromFormat("Y-m-d", $request->fecha_resolucion)->format('Y-m-d');
                $resolucion->firma_resolucion = strtoupper($request->firma_resolucion);
                $query = $resolucion->save();
                if($query) {
                    $resolucion_predio = new ResolucionPredio();
                    $resolucion_predio->id_predio = $predio->id;
                    $resolucion_predio->id_resolucion = $resolucion->id;
                    $resolucion_predio->id_usuario = $request->session()->get('userid');
                    $resolucion_predio->descripcion = 'Anulación predio ' . $predio->codigo_predio;

                    $query = $resolucion_predio->save();
                    if($query) {
                        return back()->with(['success' => 'El registro se anulo satisfactoriamente.', 'tab_current' => $tab_current]);
                    }
                    else {
                        $resolucion->delete();
                        $predio->estado = 1;
                        $query = $predio->save();
                        return back()->with(['fail' => 'No se pudo generar la informaci&oacute;n de resoluci&oacute;n predio. Intente nuevamente.', 'tab_current' => $tab_current]);
                    }
                }
                else {
                    $predio->estado = 1;
                    $query = $predio->save();
                    return back()->with(['fail' => 'No se pudo generar la informaci&oacute;n de resoluci&oacute;n. Intente nuevamente.', 'tab_current' => $tab_current]);
                }
            }
            else {
                return back()->with(['fail' => 'No se pudo anular el predio. Intente nuevamente.', 'tab_current' => $tab_current]);
            }
        }
        // else {
        //     return back()->with(['fail' => 'No se pudo eliminar la informaci&oacute;n. La clase de mutaci&oacute;n <b>' . $predio->nombre . ' (' . $predio->codigo . ')</b> ya posee informaci&oacute;n asociada.', 'tab_current' => $tab_current]);
        // }
    }

    /**
     * Prescribe the specified resource from storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function prescribe(Request $request) {
        if (!$request->session()->exists('userid')) {
            return redirect('/');
        }

        $tab_current = 'li-section-bar-2';
        $predio = new Predio();
        $predio = Predio::find($request->input_prescribe);
        $prescripcion_predio = new PrescripcionPredio();

        $prescripcion_predio->id_predio = $predio->id;
        $prescripcion_predio->prescibe_hasta = Carbon::createFromFormat("Y-m-d", $request->prescribe_hasta)->format('Y-m-d');;
        $query = $prescripcion_predio->save();
        if($query) {
            $resolucion = new Resolucion();
            $resolucion->numero_resolucion = $request->numero_resolucion;
            $resolucion->fecha_resolucion = Carbon::createFromFormat("Y-m-d", $request->fecha_resolucion)->format('Y-m-d');
            $resolucion->firma_resolucion = strtoupper($request->firma_resolucion);
            $query = $resolucion->save();
            if($query) {
                $resolucion_predio = new ResolucionPredio();
                $resolucion_predio->id_predio = $predio->id;
                $resolucion_predio->id_resolucion = $resolucion->id;
                $resolucion_predio->id_usuario = $request->session()->get('userid');
                $resolucion_predio->descripcion = 'Prescripción predio ' . $predio->codigo_predio;

                $query = $resolucion_predio->save();
                if($query) {
                    return back()->with(['success' => 'El predio se prescribio satisfactoriamente.', 'tab_current' => $tab_current]);
                }
                else {
                    $resolucion->delete();
                    $prescripcion_predio->delete();
                    return back()->with(['fail' => 'No se pudo generar la informaci&oacute;n de resoluci&oacute;n predio. Intente nuevamente.', 'tab_current' => $tab_current]);
                }
            }
            else {
                $prescripcion_predio->delete();
                return back()->with(['fail' => 'No se pudo generar la informaci&oacute;n de resoluci&oacute;n. Intente nuevamente.', 'tab_current' => $tab_current]);
            }
        }
        else {
            return back()->with(['fail' => 'No se pudo prescribir el predio. Intente nuevamente.', 'tab_current' => $tab_current]);
        }
    }

    public function store_predios_datos_basicos(Request $request) {

        $data = json_decode($request->form);

        $predio_dato = new PredioDato();

        if(array_key_exists('id', $data)) {
            $predio_dato = PredioDato::find($data->{'id'});
        }
        $predio_dato->id_predio = $data->{'id_predio'};
        $predio_dato->id_tipo_predio = $data->{'id_tipo_predio'};
        $predio_dato->matricula_inmobiliaria = $data->{'matricula_inmobiliaria'};
        $predio_dato->avaluo_presente_anio = str_replace(",", "", $data->{'avaluo_presente_anio'});
        $predio_dato->excento_impuesto = array_key_exists('excento_impuesto', $data) ? $data->{'excento_impuesto'} : '0';
        $predio_dato->id_clase_predio = $data->{'id_clase_predio'};
        //$predio_dato->id_clase_mutacion = $data->{'id_clase_mutacion'};
        //$predio_dato->predio_incautado = array_key_exists('predio_incautado', $data) ? $data->{'predio_incautado'} : '0';
        //$predio_dato->aplica_ley44 = array_key_exists('aplica_ley44', $data) ? $data->{'aplica_ley44'} : '0';

        $query = $predio_dato->save();

        $result = array("success"=>$query);

        if($query) {
            $result['message'] = 'Informaci&oacute;n b&aacute;sica del predio actualizada satisfactoriamente.';
            return response()->json([
                'data' => $result,
                'obj' => $predio_dato
            ]);
        }
        else {
            $result['message'] = 'No se pudo actualizar la informaci&oacute;n b&aacute;sica del predio.';
            return response()->json([
                'data' => $result
            ]);
        }
    }

    public function store_predios_datos_propietarios(Request $request) {

        $data = json_decode($request->form);

        $propietario = new Propietario();

        if(array_key_exists('id', $data)) {
            $propietario = Propietario::find($data->{'id'});
        }
        else {
            $propietario->identificacion = $data->{'identificacion'};
        }
        $propietario->nombre = $data->{'nombre'};
        $propietario->direccion = $data->{'direccion'};
        $propietario->correo_electronico = $data->{'correo_electronico'};

        $query = $propietario->save();

        $result = array("success"=>$query);

        if($query) {

            if(array_key_exists('id', $data)) {
                $result['message'] = 'Informaci&oacute;n de propietario del predio actualizada satisfactoriamente.';

                $propietario = DB::table('predios_propietarios')
                                   ->join('propietarios', 'predios_propietarios.id_propietario', '=', 'propietarios.id')
                                   ->select('propietarios.*', 'predios_propietarios.jerarquia')
                                   ->where('propietarios.id', $propietario->id)
                                   ->first();

                return response()->json([
                    'data' => $result,
                    'obj' => $propietario
                ]);
            }
            else {
                $predio_propietario = new PredioPropietario();
                $predio_propietario->id_predio = $data->{'id_predio'};
                $predio_propietario->id_propietario = $propietario->id;
                $predio_propietario->jerarquia = str_pad(intval($data->{'jerarquia'}), 3, "0", STR_PAD_LEFT);

                $query = $predio_propietario->save();

                $result = array("success"=>$query);

                if($query) {
                    $result['message'] = 'Informaci&oacute;n de propietario del predio actualizada satisfactoriamente.';

                    $propietario = DB::table('predios_propietarios')
                                   ->join('propietarios', 'predios_propietarios.id_propietario', '=', 'propietarios.id')
                                   ->select('propietarios.*', 'predios_propietarios.jerarquia')
                                   ->where('propietarios.id', $propietario->id)
                                   ->first();

                    return response()->json([
                        'data' => $result,
                        'obj' => $propietario
                    ]);
                }
                else {
                    $propietario->delete();
                    $result['message'] = 'No se pudo actualizar la informaci&oacute;n de propietario del predio.';
                    return response()->json([
                        'data' => $result
                    ]);
                }
            }
        }
        else {
            $result['message'] = 'No se pudo actualizar la informaci&oacute;n de propietario del predio.';
            return response()->json([
                'data' => $result
            ]);
        }
    }

    public function store_predios_datos_calculo(Request $request) {

        $data = json_decode($request->form);

        $predio_calculo = new PredioCalculo();

        if(array_key_exists('id', $data)) {
            $predio_calculo = PredioCalculo::find($data->{'id'});
        }
        $predio_calculo->id_predio = $data->{'id_predio'};
        $predio_calculo->estrato = $data->{'estrato'};
        $predio_calculo->id_tarifa_predial = $data->{'id_tarifa_predial'};
        $predio_calculo->destino_economico = $data->{'destino_economico'};
        $predio_calculo->numero_resolucion = $data->{'numero_resolucion'};
        $predio_calculo->numero_ultima_factura = $data->{'numero_ultima_factura'};
        $predio_calculo->uso_suelo = array_key_exists('uso_suelo', $data) ? $data->{'uso_suelo'} : '0';

        $query = $predio_calculo->save();

        $result = array("success"=>$query);

        if($query) {
            $result['message'] = 'Informaci&oacute;n de c&aacute;lculo del predio actualizada satisfactoriamente.';
            return response()->json([
                'data' => $result,
                'obj' => $predio_calculo
            ]);
        }
        else {
            $result['message'] = 'No se pudo actualizar la informaci&oacute;n de c&aacute;lculo del predio.';
            return response()->json([
                'data' => $result
            ]);
        }
    }

    public function store_predios_datos_pagos(Request $request) {

        $data = json_decode($request->form);

        $predio_pago = new PredioPago();

        if(array_key_exists('id', $data)) {
            $predio_pago = PredioPago::find($data->{'id'});
        }
        $predio_pago->id_predio = $data->{'id_predio'};
        $predio_pago->ultimo_anio_pago = $data->{'ultimo_anio_pago'};
        $predio_pago->valor_pago = str_replace(",", "", $data->{'valor_pago'});
        $predio_pago->fecha_pago = Carbon::createFromFormat("Y-m-d", $data->{'fecha_pago'})->format('Y-m-d');
        $predio_pago->factura_pago = $data->{'factura_pago'};
        $predio_pago->id_banco = $data->{'id_banco'};
        $predio_pago->acuerdo_pago = array_key_exists('acuerdo_pago', $data) ? $data->{'acuerdo_pago'} : '0';

        $query = $predio_pago->save();

        $result = array("success"=>$query);

        if($query) {
            $result['message'] = 'Informaci&oacute;n de pago del predio actualizada satisfactoriamente.';
            return response()->json([
                'data' => $result,
                'obj' => $predio_pago
            ]);
        }
        else {
            $result['message'] = 'No se pudo actualizar la informaci&oacute;n de pago del predio.';
            return response()->json([
                'data' => $result
            ]);
        }
    }

    public function store_predios_datos_abonos(Request $request) {

        $data = json_decode($request->form);

        $predio_abono = new PredioAbono();

        if(array_key_exists('id', $data)) {
            $predio_abono = PredioAbono::find($data->{'id'});
        }
        $predio_abono->id_predio = $data->{'id_predio'};
        $predio_abono->anio_abono = $data->{'anio_abono'};
        $predio_abono->factura_abono = $data->{'factura_abono'};
        $predio_abono->valor_abono = str_replace(",", "", $data->{'valor_abono'});

        $query = $predio_abono->save();

        $result = array("success"=>$query);

        if($query) {
            $result['message'] = 'Informaci&oacute;n de abono del predio actualizada satisfactoriamente.';

            $predio_abonos = PredioAbono::where('id_predio', $data->{'id_predio'})
                            ->orderBy('id', 'asc')
                            ->get();

            return response()->json([
                'data' => $result,
                'obj' => $predio_abonos
            ]);
        }
        else {
            $result['message'] = 'No se pudo actualizar la informaci&oacute;n de abono del predio.';
            return response()->json([
                'data' => $result
            ]);
        }
    }

    public function show_predios_datos(Request $request) {
        $predio_dato = PredioDato::where('id_predio', $request->id_predio)->first();

        $predio_propietarios = DB::table('predios_propietarios')
                                   ->join('propietarios', 'predios_propietarios.id_propietario', '=', 'propietarios.id')
                                   ->select('propietarios.*', 'predios_propietarios.jerarquia')
                                   ->where('predios_propietarios.id_predio', $request->id_predio)
                                   ->orderBy('predios_propietarios.jerarquia', 'asc')
                                   ->get();

        $predio_calculo = PredioCalculo::where('id_predio', $request->id_predio)->first();

        $predio_pago = PredioPago::where('id_predio', $request->id_predio)
                        ->orderBy('id', 'desc')
                        ->first();

        $predio_acuerdo_pago = PredioAcuerdoPago::where('id_predio', $request->id_predio)->first();

        $predio_abonos = PredioAbono::where('id_predio', $request->id_predio)
                        ->orderBy('id', 'asc')
                        ->get();

        //$predio_proceso_historico = PredioAbono::where('id_predio', $request->id_predio)->first();

        return response()->json([
            'predio_dato' => $predio_dato,
            'predio_propietarios' => $predio_propietarios,
            'predio_calculo' => $predio_calculo,
            'predio_pago' => $predio_pago,
            'predio_acuerdo_pago' => $predio_acuerdo_pago,
            'predio_abonos' => $predio_abonos
        ]);
    }

}
