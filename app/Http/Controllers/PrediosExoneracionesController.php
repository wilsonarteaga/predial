<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PrediosExoneracionesCreateFormRequest;
use App\Http\Requests\PrediosExoneracionesUpdateFormRequest;
use App\Models\Predio;
use App\Models\Opcion;
use App\Models\PredioExoneracionVigencia;
use App\Models\Resolucion;
use App\Models\ResolucionPredio;

use Carbon\Carbon;

class PrediosExoneracionesController extends Controller
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
     * Show the form for exoneracion de vigencia of a resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id) {
        if (!$request->session()->exists('userid')) {
            return redirect('/');
        }
        $opcion = Opcion::where('id','=', base64_decode($id))->first();

        $exoneraciones = DB::table('predios_exoneraciones_vigencia')
                    ->join('predios', 'predios_exoneraciones_vigencia.id_predio', '=', 'predios.id')
                    ->select('predios_exoneraciones_vigencia.*', 'predios.codigo_predio')
                    ->where('predios_exoneraciones_vigencia.estado', 1)
                    ->get();

        // $predios = DB::table('predios')
        //             ->leftJoin('predios_exoneraciones_vigencia', function ($join) {
        //                 $join->on('predios.id', '=', 'predios_exoneraciones_vigencia.id_predio');
        //                 $join->on('predios_exoneraciones_vigencia.estado', DB::raw(1));
        //             })
        //             ->select('predios.id', 'predios.codigo_predio')
        //             ->whereNull('predios_exoneraciones_vigencia.id')
        //             ->where('predios.estado', 1)
        //             ->get();

        $conceptos_predios = DB::table('conceptos_predio')
                                ->select('conceptos_predio.id', 'conceptos_predio.codigo', 'conceptos_predio.nombre')
                                ->get();

        $tab_current = 'li-section-bar-1';
        if ($request->has('page')) {
            $tab_current = 'li-section-bar-2';
        }

        //$request->session()->put('display_buttons', '1');

        return view('exoneraciones.create', ['opcion' => $opcion,
                                            'exoneraciones' => $exoneraciones,
                                            //'predios' => $predios,
                                            'conceptos_predios' => $conceptos_predios,
                                            'tab_current' => $tab_current]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PrediosExoneracionesCreateFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PrediosExoneracionesCreateFormRequest $request) {
        if (!$request->session()->exists('userid')) {
            return redirect('/');
        }

        $predio_exoneracion = new PredioExoneracionVigencia();
        $predio_exoneracion->id_predio = $request->id_predio;
        $predio_exoneracion->id_concepto_predio = $request->id_concepto_predio;
        $predio_exoneracion->exoneracion_desde = $request->exoneracion_desde;
        $predio_exoneracion->exoneracion_hasta = $request->exoneracion_hasta;
        $predio_exoneracion->escritura = $request->escritura;
        $predio_exoneracion->matricula = $request->matricula;
        $predio_exoneracion->certificado_libertad = $request->certificado_libertad;
        $query = $predio_exoneracion->save();
        $tab_current = 'li-section-bar-1';

        if($query) {
            $resolucion = new Resolucion();
            $resolucion->numero_resolucion = $request->numero_resolucion;
            $resolucion->fecha_resolucion = Carbon::createFromFormat("Y-m-d", $request->fecha_resolucion)->format('Y-m-d');
            $resolucion->firma_resolucion = strtoupper($request->firma_resolucion);
            $query = $resolucion->save();
            if($query) {
                $resolucion_predio = new ResolucionPredio();
                $predio = new Predio();
                $predio = Predio::find($predio_exoneracion->id_predio);
                $resolucion_predio->id_predio = $predio->id;
                $resolucion_predio->id_resolucion = $resolucion->id;
                $resolucion_predio->id_usuario = $request->session()->get('userid');
                $resolucion_predio->descripcion = 'Registro de exoneración de vigencia predio ' . $predio->codigo_predio . ', desde: ' . $predio_exoneracion->exoneracion_desde . ', hasta: '. $predio_exoneracion->exoneracion_hasta;

                $query = $resolucion_predio->save();
                if($query) {
                    return back()->with(['success' => 'La informaci&oacute;n se guard&oacute; satisfactoriamente.', 'tab_current' => $tab_current]);
                }
                else {
                    $resolucion->delete();
                    $predio_exoneracion->delete();
                    return back()->with(['fail' => 'No se pudo generar la informaci&oacute;n de resoluci&oacute;n predio. Intente nuevamente.', 'tab_current' => $tab_current]);
                }
            }
            else {
                $predio_exoneracion->delete();
                return back()->with(['fail' => 'No se pudo generar la informaci&oacute;n de resoluci&oacute;n. Intente nuevamente.', 'tab_current' => $tab_current]);
            }
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
     * @param  PrediosExoneracionesUpdateFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(PrediosExoneracionesUpdateFormRequest $request) {
        if (!$request->session()->exists('userid')) {
            return redirect('/');
        }

        $tab_current = 'li-section-bar-2';
        $predio_exoneracion = new PredioExoneracionVigencia();
        $predio_exoneracion_tmp = new PredioExoneracionVigencia();
        $predio_exoneracion = PredioExoneracionVigencia::find($request->id_edit);
        $predio_exoneracion_tmp = PredioExoneracionVigencia::find($request->id_edit);
        $predio_exoneracion->id_predio = $request->id_predio_edit;
        $predio_exoneracion->id_concepto_predio = $request->id_concepto_predio_edit;
        $predio_exoneracion->exoneracion_desde = $request->exoneracion_desde_edit;
        $predio_exoneracion->exoneracion_hasta = $request->exoneracion_hasta_edit;
        $predio_exoneracion->escritura = $request->escritura_edit;
        $predio_exoneracion->matricula = $request->matricula_edit;
        $predio_exoneracion->certificado_libertad = $request->certificado_libertad_edit;
        $query = $predio_exoneracion->save();

        if($query) {
            $resolucion = new Resolucion();
            $resolucion->numero_resolucion = $request->numero_resolucion;
            $resolucion->fecha_resolucion = Carbon::createFromFormat("Y-m-d", $request->fecha_resolucion)->format('Y-m-d');
            $resolucion->firma_resolucion = strtoupper($request->firma_resolucion);
            $query = $resolucion->save();
            if($query) {
                $resolucion_predio = new ResolucionPredio();
                $predio = new Predio();
                $predio = Predio::find($predio_exoneracion->id_predio);
                $resolucion_predio->id_predio = $predio->id;
                $resolucion_predio->id_resolucion = $resolucion->id;
                $resolucion_predio->id_usuario = $request->session()->get('userid');
                $resolucion_predio->descripcion = 'Actualización de exoneración de vigencia predio ' . $predio->codigo_predio;

                $query = $resolucion_predio->save();
                if($query) {
                    return back()->with(['success' => 'La informaci&oacute;n se actualiz&oacute; satisfactoriamente.', 'tab_current' => $tab_current]);
                }
                else {
                    $resolucion->delete();
                    $predio_exoneracion_tmp->save();
                    return back()->with(['fail' => 'No se pudo generar la informaci&oacute;n de resoluci&oacute;n predio. Intente nuevamente.', 'tab_current' => $tab_current]);
                }
            }
            else {
                $predio_exoneracion_tmp->save();
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

        $countPredios = DB::table('predios_exoneraciones_vigencia')
                            ->select(DB::raw('count(*) as cm_count')) // verificar si ya esta relacionada con otras tablas
                            ->where('id', $request->input_delete)
                            ->where('estado', 1)
                            ->first();

        $tab_current = 'li-section-bar-2';
        $predio_exoneracion = new PredioExoneracionVigencia();
        $predio_exoneracion = PredioExoneracionVigencia::find($request->input_delete);

        if($countPredios->cm_count > 0) {
            $predio_exoneracion->estado = 0;
            $query = $predio_exoneracion->save();
            if($query) {
                // $resolucion = new Resolucion();
                // $resolucion->numero_resolucion = $request->numero_resolucion;
                // $resolucion->fecha_resolucion = Carbon::createFromFormat("Y-m-d", $request->fecha_resolucion)->format('Y-m-d');
                // $resolucion->firma_resolucion = strtoupper($request->firma_resolucion);
                // $query = $resolucion->save();
                // if($query) {
                //     $resolucion_predio = new ResolucionPredio();
                //     $resolucion_predio->id_predio = $predio_exoneracion->id;
                //     $resolucion_predio->id_resolucion = $resolucion->id;
                //     $resolucion_predio->id_usuario = $request->session()->get('userid');
                //     $resolucion_predio->descripcion = 'Anulación de exoneraci&oacute;n del predio ' . $predio_exoneracion->codigo_predio;

                //     $query = $resolucion_predio->save();
                //     if($query) {
                        return back()->with(['success' => 'El registro se anulo satisfactoriamente.', 'tab_current' => $tab_current]);
                //     }
                //     else {
                //         $resolucion->delete();
                //         $predio_exoneracion->estado = 1;
                //         $query = $predio_exoneracion->save();
                //         return back()->with(['fail' => 'No se pudo generar la informaci&oacute;n de resoluci&oacute;n de exoneraci&oacute;n del predio. Intente nuevamente.', 'tab_current' => $tab_current]);
                //     }
                // }
                // else {
                //     $predio_exoneracion->estado = 1;
                //     $query = $predio_exoneracion->save();
                //     return back()->with(['fail' => 'No se pudo generar la informaci&oacute;n de resoluci&oacute;n. Intente nuevamente.', 'tab_current' => $tab_current]);
                // }
            }
            else {
                return back()->with(['fail' => 'No se pudo anular la exoneraci&oacute;n del predio. Intente nuevamente.', 'tab_current' => $tab_current]);
            }
        }
        // else {
        //     return back()->with(['fail' => 'No se pudo eliminar la informaci&oacute;n. La clase de mutaci&oacute;n <b>' . $predio->nombre . ' (' . $predio->codigo . ')</b> ya posee informaci&oacute;n asociada.', 'tab_current' => $tab_current]);
        // }
    }
}
