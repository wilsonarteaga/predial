<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PagosCreateFormRequest;
use App\Http\Requests\PagosUpdateFormRequest;
use App\Models\Pago;
use App\Models\Opcion;

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

        $predios = DB::table('predios')
                            ->select('predios.id', 'predios.codigo_predio')
                            ->get();

        $bancos = DB::table('bancos')
                            ->select('bancos.id', 'bancos.codigo', 'bancos.asobancaria', 'bancos.nombre')
                            ->get();

        $pagos = DB::table('pagos')->join('bancos', function ($join) {
                    $join->on('pagos.id_banco_factura', '=', 'bancos.id');
                })
                ->select('pagos.*', 'bancos.nombre as banco')
                ->get();

        //dd($pagos);
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


        return view('pagos.create', ['opcion' => $opcion,
                                    'pagos' => $pagos,
                                    'predios' => $predios,
                                    'bancos' => $bancos,
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

        $pago = new Pago();
        $pago->fecha_pago = $request->fecha_pago;
        $pago->codigo_barras = $request->codigo_barras;
        $pago->numero_recibo = $request->numero_recibo;
        $pago->id_predio = $request->id_predio;
        $pago->valor_facturado = $request->valor_facturado;
        $pago->anio_pago = $request->anio_pago;
        $pago->fecha_factura = $request->fecha_factura;
        $pago->id_banco_factura = $request->id_banco_factura;
        $pago->id_banco_archivo = $request->filled('id_banco_archivo') ? $request->id_banco_archivo : NULL;
        $pago->paquete_archivo = $request->filled('paquete_archivo') ? $request->paquete_archivo : NULL;
        $query = $pago->save();
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
    public function destroy(Request $request)
    {
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

        return response()->json([
            'pagos' => $pagos
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     if (!$request->session()->exists('userid')) {
    //         return redirect('/');
    //     }

    //     $countPagos = DB::table('usuarios')
    //                         ->leftJoin('fonoaudiologos', 'fonoaudiologos.usuarios_ide_usu', '=', 'usuarios.ide_usu')
    //                         ->select(DB::raw('count(*) as usuarios_count'))
    //                         ->where('usuarios.ide_usu', $request->input_delete)
    //                         ->where(function($query) {
    //                             $query->orWhereNotNull('fonoaudiologos.usuarios_ide_usu');
    //                         })->first();

    //     $tab_current = 'li-section-bar-2';
    //     $usuario = new Usuario;
    //     $usuario = Usuario::find($request->input_delete);

    //     if($countPagos->usuarios_count == 0) {
    //         $query = $usuario->delete();
    //         if($query) {
    //             return back()->with(['success' => 'El registro se elimin&oacute; satisfactoriamente.', 'tab_current' => $tab_current]);
    //         }
    //         else {
    //             return back()->with(['fail' => 'No se pudo eliminar la informaci&oacute;n. Intente nuevamente.', 'tab_current' => $tab_current]);
    //         }
    //     }
    //     else {
    //         return back()->with(['fail' => 'No se pudo eliminar la informaci&oacute;n. El usuario <b>' . $usuario->nom_usu . ' ' . $usuario->ape_usu . '</b> ya posee informaci&oacute;n asociada.', 'tab_current' => $tab_current]);
    //     }
    // }
}
