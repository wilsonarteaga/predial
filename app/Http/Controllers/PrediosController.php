<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\Http\Requests\PrediosCreateFormRequest;
use App\Http\Requests\PrediosUpdateFormRequest;
use App\Models\Anio;
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
use App\Models\PredioPrescripcion;

use Carbon\Carbon;
use PDF;
use \stdClass;
use Illuminate\Support\Str;

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
        $predios = [];
        // DB::table('predios')->join('zonas', function ($join) {
        //                 $join->on('predios.id_zona', '=', 'zonas.id');
        //             })
        //             ->leftJoin('predios_prescripciones', 'predios.id', '=', 'predios_prescripciones.id_predio')
        //             //->select('predios.*', 'zonas.descripcion')
        //             ->select(DB::raw('predios.*, zonas.descripcion, CASE WHEN COALESCE(predios_prescripciones.prescribe_hasta, 0) >= YEAR(GETDATE()) THEN 1 ELSE 0 END AS prescrito, predios_prescripciones.prescribe_hasta'))
        //             ->where('estado', 1)
        //             ->get(); //paginate(5);

        // $propietarios = DB::table('predios')
        //                              ->join('predios_propietarios', 'predios.id', '=', 'predios_propietarios.id_predio')
        //                              ->join('propietarios', 'propietarios.id', '=', 'predios_propietarios.id_propietario')
        //                              ->join('zonas', 'zonas.id', '=', 'predios.id_zona')
        //         ->select(DB::raw('predios_propietarios.id_predio, STRING_AGG(CONCAT(TRIM(propietarios.nombre), \' - \', propietarios.identificacion), \'<br />\') AS propietarios'))
        //         ->where('predios.estado', 1)
        //         ->groupBy('predios_propietarios.id_predio')
        //         ->get();

        // if($propietarios) {
        //     foreach ($predios as $key => $predio) {
        //         $desired_object = self::findInCollection($propietarios, 'id_predio', $predio->id);
        //         if($desired_object) {
        //             $predio->propietarios = $desired_object->propietarios;
        //         }
        //         else {
        //             $predio->propietarios = 'Sin asignar';
        //         }
        //     }
        // }
        // else {
        //     foreach ($predios as $key => $predio) {
        //         $predio->propietarios = 'Sin asignar';
        //     }
        // }

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

        $predio->tipo = $request->filled('tipo') ? $request->tipo : NULL;//2
        $predio->zona = $request->filled('zona') ? $request->zona : NULL;//2

        $predio->sector = $request->sector;//2

        $predio->comuna = $request->filled('comuna') ? $request->comuna : NULL;//2
        $predio->barrio = $request->filled('barrio') ? $request->barrio : NULL;//2

        $predio->manzana = $request->manzana;//4

        $predio->predio = $request->predio;//4
        $predio->terreno = $request->filled('terreno') ? $request->terreno : NULL;//4

        $predio->mejora = $request->mejora;//3

        $predio->condicion = $request->filled('condicion') ? $request->condicion : NULL;//1
        $predio->edificio_torre = $request->filled('edificio_torre') ? $request->edificio_torre : NULL;//2
        $predio->piso = $request->filled('piso') ? $request->piso : NULL;//2
        $predio->propiedad = $request->filled('propiedad') ? $request->propiedad : NULL;//4

        $predio->id_zona = $request->id_zona;
        $predio->direccion = $request->direccion;
        $predio->area_metros = str_replace(",", "", $request->area_metros);
        $predio->area_construida = str_replace(",", "", $request->area_construida);
        $predio->area_hectareas = str_replace(",", "", $request->area_hectareas);
        $predio->tarifa_actual = str_replace(",", "", $request->tarifa_actual);
        $predio->avaluo = str_replace(",", "", $request->avaluo);
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
        $predio_tmp = Predio::find($request->id_edit);
        $predio->codigo_predio = $request->codigo_predio_edit;

        if((strlen($predio_tmp->codigo_predio) == 15 && strlen($request->codigo_predio_edit) == 25) ||
           (strlen($predio_tmp->codigo_predio) == 25 && strlen($request->codigo_predio_edit) == 15)) {
            $predio->codigo_predio_anterior = $predio_tmp->codigo_predio;
        }

        $predio->tipo = $request->filled('tipo_edit') ? $request->tipo_edit : NULL;//2
        $predio->zona = $request->filled('zona_edit') ? $request->zona_edit : NULL;//2

        $predio->sector = $request->sector_edit;//2

        $predio->comuna = $request->filled('comuna_edit') ? $request->comuna_edit : NULL;//2
        $predio->barrio = $request->filled('barrio_edit') ? $request->barrio_edit : NULL;//2

        $predio->manzana = $request->manzana_edit;//4

        $predio->predio = $request->predio_edit;//4
        $predio->terreno = $request->filled('terreno_edit') ? $request->terreno_edit : NULL;//4

        $predio->mejora = $request->mejora_edit;//3

        $predio->condicion = $request->filled('condicion_edit') ? $request->condicion_edit : NULL;//1
        $predio->edificio_torre = $request->filled('edificio_torre_edit') ? $request->edificio_torre_edit : NULL;//2
        $predio->piso = $request->filled('piso_edit') ? $request->piso_edit : NULL;//2
        $predio->propiedad = $request->filled('propiedad_edit') ? $request->propiedad_edit : NULL;//4

        $predio->id_zona = $request->id_zona_edit;
        $predio->direccion = $request->direccion_edit;
        $predio->area_metros = str_replace(",", "", $request->area_metros_edit);
        $predio->area_construida = str_replace(",", "", $request->area_construida_edit);
        $predio->area_hectareas = str_replace(",", "", $request->area_hectareas_edit);
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
                    $predio_tmp->save();
                    return back()->with(['fail' => 'No se pudo generar la informaci&oacute;n de resoluci&oacute;n predio. Intente nuevamente.', 'tab_current' => $tab_current]);
                }
            }
            else {
                $predio_tmp->save();
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
                            ->where('estado', 1)
                            ->first();

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
                        $predio->save();
                        return back()->with(['fail' => 'No se pudo generar la informaci&oacute;n de resoluci&oacute;n predio. Intente nuevamente.', 'tab_current' => $tab_current]);
                    }
                }
                else {
                    $predio->estado = 1;
                    $predio->save();
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
        $predio_prescripcion = new PredioPrescripcion();

        $predio_prescripcion->id_predio = $predio->id;
        $predio_prescripcion->prescribe_hasta = $request->prescribe_hasta;
        $query = $predio_prescripcion->save();
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
                    $predio_prescripcion->delete();
                    return back()->with(['fail' => 'No se pudo generar la informaci&oacute;n de resoluci&oacute;n predio. Intente nuevamente.', 'tab_current' => $tab_current]);
                }
            }
            else {
                $predio_prescripcion->delete();
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
                        ->where('pagado', -1)
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

    public function generateFacturaPDFByIdPredio(Request $request, $id) {
        if (!$request->session()->exists('userid')) {
            return redirect('/');
        }

        $submit = [];
        $dt = Carbon::now();
        $dt_emision = Carbon::now();
        $fecha_mision = $dt_emision;
        $currentYear = $dt->year;

        // Verificar si el registro ya existe
        $ultimo_anio_pagar = DB::table('predios_pagos')
                            ->where('id_predio', $id)
                            ->where('ultimo_anio', $currentYear)
                            ->where('pagado', 0)
                            ->first();

        // Si no existe un predio_pago para el año actual, entonces EJECUTAR PROCEDIMIENTO DE CALCULO
        if($ultimo_anio_pagar == null) {
            $submit = DB::select("SET NOCOUNT ON; EXEC SP_CALCULO_PREDIAL ?,?", array($currentYear, $id));
        }

        if(count($submit) > 0 || $ultimo_anio_pagar != null) {
            $anio = Anio::where('anio', $currentYear)
                          ->first();

            $ultimo_numero_factura = 0;

            // Si se EJECUTO EL PROCEDIMIENTO DE CALCULO, entonces se genera un nuevo numero de factura
            // Generar informacion de numero de fatura solo si se realizo un nuevo calculo
            if(count($submit) > 0) {
                $init_anio = new Anio;
                $init_anio = Anio::find($anio->id);
                $case_ultimo_numero_factura = 0;

                if($anio->numero_factura_actual == null || $anio->numero_factura_actual == 0) {
                    if($anio->numero_factura_inicial == null || $anio->numero_factura_inicial == 0) {
                        $ultimo_numero_factura = 1;
                        $case_ultimo_numero_factura = 1;
                    }
                    else {
                        $ultimo_numero_factura = $anio->numero_factura_inicial;
                        $case_ultimo_numero_factura = 2;
                    }
                }
                else {
                    if($anio->numero_factura_inicial == null || $anio->numero_factura_inicial == 0) {
                        $ultimo_numero_factura = $anio->numero_factura_actual;
                        $case_ultimo_numero_factura = 3;
                    }
                    else if($anio->numero_factura_inicial > $anio->numero_factura_actual) {
                        $ultimo_numero_factura = $anio->numero_factura_inicial;
                        $case_ultimo_numero_factura = 4;
                    }
                    else {
                        $ultimo_numero_factura = $anio->numero_factura_actual;
                    }
                }

                // Maximo numero de factura 99999 cada anio
                if($ultimo_numero_factura > 99999) {
                    return null;
                }

                if($case_ultimo_numero_factura == 1) {
                    $init_anio->numero_factura_inicial = $ultimo_numero_factura;
                    $init_anio->numero_factura_actual = $ultimo_numero_factura;
                    $init_anio->save();
                }
                else if($case_ultimo_numero_factura == 2 || $case_ultimo_numero_factura == 4) {
                    $init_anio->numero_factura_actual = $ultimo_numero_factura;
                    $init_anio->save();
                }
                else if($case_ultimo_numero_factura == 3) {
                    $init_anio->numero_factura_inicial = $ultimo_numero_factura;
                    $init_anio->save();
                }

                $numero_factura = $currentYear . (str_pad($ultimo_numero_factura, 5, "0", STR_PAD_LEFT));

                // Configurar informacion del ultimo año a pagar
                $ultimo_anio_pagar = $submit[0];
            }
            else {
                $numero_factura = $ultimo_anio_pagar->factura_pago;
                $fecha_mision = Carbon::createFromFormat('Y-m-d H:i:s.u', $ultimo_anio_pagar->fecha_emision);
            }

            $predios = DB::table('predios')->join('zonas', function ($join) {
                $join->on('predios.id_zona', '=', 'zonas.id');
            })
            ->leftJoin('predios_prescripciones', 'predios.id', '=', 'predios_prescripciones.id_predio')
            ->select(DB::raw('predios.*, zonas.descripcion, CASE WHEN COALESCE(predios_prescripciones.prescribe_hasta, 0) >= YEAR(GETDATE()) THEN 1 ELSE 0 END AS prescrito, predios_prescripciones.prescribe_hasta'))
            ->where('estado', 1)
            ->where('predios.id', $id)
            ->get();

            $propietarios = DB::table('predios')
                                    ->join('predios_propietarios', 'predios.id', '=', 'predios_propietarios.id_predio')
                                    ->join('propietarios', 'propietarios.id', '=', 'predios_propietarios.id_propietario')
                                    ->join('zonas', 'zonas.id', '=', 'predios.id_zona')
                ->select(DB::raw('predios_propietarios.id_predio, STRING_AGG(TRIM(propietarios.nombre), \'<br />\') AS propietarios, STRING_AGG(propietarios.identificacion, \'<br />\') AS identificaciones'))
                ->where('predios.estado', 1)
                ->where('predios.id', $id)
                ->where('predios_propietarios.jerarquia', 1)
                ->groupBy('predios_propietarios.id_predio')
                ->get();

            if($propietarios) {
                foreach ($predios as $key => $predio) {
                    $desired_object = self::findInCollection($propietarios, 'id_predio', $predio->id);
                    if($desired_object) {
                        $predio->propietarios = $desired_object->propietarios;
                        $predio->identificaciones = $desired_object->identificaciones;
                    }
                    else {
                        $predio->propietarios = 'Sin asignar';
                        $predio->identificaciones = 'Sin asignar';
                    }
                    // Se muestra un solo propietario
                    break;
                }
            }
            else {
                foreach ($predios as $key => $predio) {
                    $predio->propietarios = 'Sin asignar';
                    $predio->identificaciones = 'Sin asignar';
                }
            }

            $nit = '7709998776913';
            $lista_pagos = new Collection();
            $ultimo_anio_pagado = new Collection();
            $suma_total = 0;
            $valores_factura = new Collection();
            $fechas_pago_hasta = new Collection();
            $barras = new Collection();
            $barras_texto = new Collection();
            $porcentajes_descuento = new Collection();

            // Obtener informacion del ultimo año pagado
            $ultimo_anio_pagado = DB::table('predios_pagos')
                                ->where('id_predio', $id)
                                ->where('pagado', -1)
                                ->orderBy('id', 'desc')
                                ->first();

            //establecer años a pagar
            if($ultimo_anio_pagado == null || $ultimo_anio_pagado->ultimo_anio + 1 == $currentYear) {
                $predio->anios_a_pagar = $currentYear;
            }
            else {
                $predio->anios_a_pagar = ($ultimo_anio_pagado->ultimo_anio + 1) . ' A ' . $currentYear;
            }

            if ($ultimo_anio_pagado == null) {
                $obj = new StdClass();
                $obj->factura_pago = '';
                $obj->ultimo_anio = '';
                $obj->fecha_pago = '';
                $obj->valor_pago = 0;
                $ultimo_anio_pagado = $obj;
            }
            else {
                $ultimo_anio_pagado->fecha_pago = Carbon::createFromFormat("Y-m-d", substr($ultimo_anio_pagado->fecha_pago, 0, 10))->format('d/m/Y');
            }

            // Obtener informacion de los pagos pendientes por año
            $pagos_pendientes = DB::table('predios_pagos')
                                ->where('id_predio', $id)
                                ->where('pagado', 0)
                                ->orderBy('id', 'asc')
                                ->get();

            foreach ($pagos_pendientes as $pago_pendiente) {
                $obj = new StdClass();
                $obj->anio = $pago_pendiente->ultimo_anio;
                $obj->m_tar = $pago_pendiente->tarifa == null ? 0 : $pago_pendiente->tarifa * 1000;
                $obj->avaluo = $pago_pendiente->avaluo == null ? 0 : $pago_pendiente->avaluo;
                $obj->impuesto = $pago_pendiente->valor_concepto1 == null ? 0 : $pago_pendiente->valor_concepto1 + $pago_pendiente->valor_concepto3;
                $obj->interes = $pago_pendiente->valor_concepto2 == null ? 0 : $pago_pendiente->valor_concepto2;
                $obj->descuento_interes = $pago_pendiente->valor_concepto13 == null ? 0 : $pago_pendiente->valor_concepto13;
                $obj->catorce = 0;
                $obj->descuento_15 = $pago_pendiente->valor_concepto15 == null ? 0 : $pago_pendiente->valor_concepto15;
                $obj->blanco = 0;
                $obj->otros = 0;
                $obj->total = $pago_pendiente->total_calculo == null ? 0 : $pago_pendiente->total_calculo;
                $suma_total += $pago_pendiente->ultimo_anio < $currentYear ? $pago_pendiente->valor_concepto1 + $pago_pendiente->valor_concepto3 : 0; // al ultimo año se le calculan descuentos
                $lista_pagos->push($obj);
            }

            $fechas_pago_hasta[0] = (Carbon::createFromFormat('Y-m-d H:i:s.u', $ultimo_anio_pagar->primer_fecha)->toDateString());
            $fechas_pago_hasta[1] = (Carbon::createFromFormat('Y-m-d H:i:s.u', $ultimo_anio_pagar->segunda_fecha)->toDateString());
            $fechas_pago_hasta[2] = (Carbon::createFromFormat('Y-m-d H:i:s.u', $ultimo_anio_pagar->tercera_fecha)->toDateString());

            $valores_factura[0] = (round($suma_total + ($ultimo_anio_pagar->valor_concepto1 + $ultimo_anio_pagar->valor_concepto3 - ($ultimo_anio_pagar->valor_concepto1 + $ultimo_anio_pagar->valor_concepto3 * (intval($ultimo_anio_pagar->porcentaje_uno) / 100))), 0));
            $valores_factura[1] = (round($suma_total + ($ultimo_anio_pagar->valor_concepto1 + $ultimo_anio_pagar->valor_concepto3 - ($ultimo_anio_pagar->valor_concepto1 + $ultimo_anio_pagar->valor_concepto3 * (intval($ultimo_anio_pagar->porcentaje_dos) / 100))), 0));
            $valores_factura[2] = (round($suma_total + ($ultimo_anio_pagar->valor_concepto1 + $ultimo_anio_pagar->valor_concepto3 - ($ultimo_anio_pagar->valor_concepto1 + $ultimo_anio_pagar->valor_concepto3 * (intval($ultimo_anio_pagar->porcentaje_tres) / 100))), 0));

            $porcentajes_descuento[0] = ($ultimo_anio_pagar->porcentaje_uno);
            $porcentajes_descuento[1] = ($ultimo_anio_pagar->porcentaje_dos);
            $porcentajes_descuento[2] = ($ultimo_anio_pagar->porcentaje_tres);

            for ($x = 0; $x < count($valores_factura); $x++) {
                $barras[$x] = ('415' . $nit . '8020' . str_pad($numero_factura , 24, "0", STR_PAD_LEFT) . '3900' . str_pad($valores_factura[$x], 14, "0", STR_PAD_LEFT) . '96' . str_replace('-', '', $fechas_pago_hasta[$x]));
                $barras_texto[$x] = ('(415)' . $nit . '(8020)' . str_pad($numero_factura , 24, "0", STR_PAD_LEFT) . '(3900)' . str_pad($valores_factura[$x], 14, "0", STR_PAD_LEFT) . '(96)' . str_replace('-', '', $fechas_pago_hasta[$x]));
            }

            $data = [
                'title' => 'Predio',
                'fecha' => count($submit) > 0 ? $dt_emision->format('d/m/Y') : $fecha_mision->format('d/m/Y'),
                'hora' => count($submit) > 0 ? $dt_emision->isoFormat('h:mm:ss a') : $fecha_mision->isoFormat('h:mm:ss a'),
                'numero_factura' => $numero_factura,
                'predio' => $predio,
                'ultimo_anio_pagado' => $ultimo_anio_pagado,
                'lista_pagos' => $lista_pagos,
                'barras' => $barras,
                'barras_texto' => $barras_texto,
                'fechas_pago_hasta' => $fechas_pago_hasta,
                'porcentajes_descuento' => $porcentajes_descuento,
                'valores_factura' => $valores_factura
            ];

            $pdf = PDF::loadView('predios.facturaPDF', $data);

            $query = true;
            // Actualizar el consecutivo de numero de factura disponible para la proxima impresion
            // Guardar informacion solo si se realizo un nuevo calculo
            if(count($submit) > 0) {
                $update_anio = new Anio;
                $update_anio = Anio::find($anio->id);
                $update_anio->numero_factura_actual = $ultimo_numero_factura + 1;
                $query = $update_anio->save();
            }

            if($query) {
                // Actualizar datos pago: valor_pago, numero_factura, fecha emision
                // Guardar informacion solo si se realizo un nuevo calculo
                if(count($submit) > 0) {
                    $pp = new PredioPago;
                    $pp = PredioPago::find($ultimo_anio_pagar->id);
                    $pp->factura_pago = $numero_factura;
                    $pp->fecha_emision = Carbon::createFromFormat("Y-m-d H:i:s", $dt_emision->toDateTimeString())->format('Y-m-d H:i:s');
                    $pp->save();
                }

                // Nombre del archivo obtenido a partir de la fecha exacta de solicitud de generación del PDF
                return $pdf->download($numero_factura . '_' . $dt_emision->toDateString() . '_' . str_replace(':', '-', $dt_emision->toTimeString()) . '.pdf');
            }
            else {
                return null;
            }
        }
        else {
            return null;
        }
    }

    public static function findInCollection(Collection $collection, $key, $value) {
        foreach ($collection as $item) {
            if (isset($item->$key) && $item->$key == $value) {
                return $item;
            }
        }
        return FALSE;
    }

    public function autocomplete(Request $request) {
        $data = $request->all();
        $term = preg_replace('/\s/', '%', preg_replace('/\s\s+/', ' ', trim($data['q'])));

        // $filter_data = DB::table('predios')
        //                     ->leftJoin('predios_propietarios', 'predios.id', '=', 'predios_propietarios.id_predio')
        //                     ->leftJoin('propietarios', 'propietarios.id', '=', 'predios_propietarios.id_propietario')
        //                 ->selectRaw('predios.id AS id, TRIM(predios.direccion) AS text, predios.codigo_predio, predios_propietarios.id_predio, STRING_AGG(CONCAT(TRIM(propietarios.nombre), \' - \', propietarios.identificacion), \'<br />\') AS propietarios')
        //                 ->where('predios.estado', 1)
        //                 ->where(function($query) use($term) {
        //                     $query->whereRaw('LOWER(predios.direccion) LIKE \'%?%\'', [strtolower($term)])
        //                           ->orWhereRaw('LOWER(predios.codigo_predio) LIKE \'%?%\'', [strtolower($term)])
        //                           ->orwhereRaw('LOWER(propietarios.nombre) LIKE \'%?%\'', [strtolower($term)])
        //                           ->orWhereRaw('LOWER(propietarios.identificacion) LIKE \'%?%\'', [strtolower($term)]);
        //                 })
        //                 ->groupBy('predios.id', 'predios.direccion', 'predios.codigo_predio', 'predios_propietarios.id_predio')
        //                 ->get();

        $filter_data = DB::select('select
                                        id,
                                        text,
                                        codigo_predio,
                                        id_predio,
                                        STRING_AGG(propietarios, \'<br />\') AS propietarios,
                                        tiene_pago
                                    from (
                                        select
                                            distinct p.id AS id,
                                            TRIM(p.direccion) AS text,
                                            p.codigo_predio,
                                            ppr.id_predio,
                                            CONCAT(TRIM(pro.nombre), \' - \', pro.identificacion) AS propietarios,
                                            ISNULL(ppa.id_predio, 0) AS tiene_pago
                                        from predios p inner join
                                            predios_propietarios ppr
                                            on p.id = ppr.id_predio inner join
                                            propietarios pro
                                            on pro.id = ppr.id_propietario left join
                                            predios_pagos ppa
                                            on p.id = ppa.id_predio
                                        where p.estado = 1 and
                                            (LOWER(p.direccion) LIKE \'%'.$term.'%\' or
                                            LOWER(p.codigo_predio) LIKE \'%'.$term.'%\' or
                                            LOWER(pro.nombre) LIKE \'%'.$term.'%\' or
                                            LOWER(pro.identificacion) LIKE \'%'.$term.'%\')
                                    ) a
                                    group by
                                        id,
                                        text,
                                        codigo_predio,
                                        id_predio,
                                        tiene_pago');

        $result = array("items" => $filter_data, "total_count" => count($filter_data));

        return response()->json($result);
    }

    public function get_predio(Request $request) {
        $data = json_decode($request->form);
        $predios =  DB::table('predios')->join('zonas', function ($join) {
                        $join->on('predios.id_zona', '=', 'zonas.id');
                    })
                    ->leftJoin('predios_prescripciones', 'predios.id', '=', 'predios_prescripciones.id_predio')
                    ->select(DB::raw('predios.*, zonas.descripcion, CASE WHEN COALESCE(predios_prescripciones.prescribe_hasta, 0) >= YEAR(GETDATE()) THEN 1 ELSE 0 END AS prescrito, predios_prescripciones.prescribe_hasta'))
                    ->where('predios.estado', 1)
                    ->where('predios.id', $data->{'id_predio'})
                    ->get();

        $propietarios = DB::table('predios')
                                     ->join('predios_propietarios', 'predios.id', '=', 'predios_propietarios.id_predio')
                                     ->join('propietarios', 'propietarios.id', '=', 'predios_propietarios.id_propietario')
                                     ->join('zonas', 'zonas.id', '=', 'predios.id_zona')
                ->select(DB::raw('predios_propietarios.id_predio, STRING_AGG(CONCAT(TRIM(propietarios.nombre), \' - \', propietarios.identificacion), \'<br />\') AS propietarios'))
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

        return response()->json($predios);
    }
}
