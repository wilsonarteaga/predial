<?php

namespace App\Http\Controllers;

use App\Models\Fonoaudiologo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\FonoaudiologosCreateFormRequest;
use App\Http\Requests\FonoaudiologosUpdateFormRequest;
use App\Http\Requests\RubricasCreateFormRequest;
use App\Http\Requests\RubricasUpdateFormRequest;
use App\Http\Requests\UsuariosCreateFormRequest;
use App\Http\Requests\UsuariosUpdateFormRequest;
use App\Http\Requests\JuegosCreateFormRequest;
use App\Http\Requests\JuegosUpdateFormRequest;

use App\Models\Opcion;
use App\Models\Rubrica;
use App\Models\Usuario;
use App\Models\Juego;

class AdministracionController extends Controller
{
    public function registro_fonoaudiologos(Request $request, $id) {
        if (!$request->session()->exists('userid')) {
            return redirect('/');
        }
        $opcion = Opcion::where('id','=', base64_decode($id))->first();
        $usuarios = DB::table('usuarios')
                    ->leftJoin('fonoaudiologos', 'usuarios.ide_usu', '=', 'fonoaudiologos.usuarios_ide_usu')
                    ->whereNull('fonoaudiologos.usuarios_ide_usu')
                    ->where('usuarios.tipos_usuarios_ide_tip', 3)
                    ->get();

        $fonoaudiologos = DB::table('fonoaudiologos')->join('usuarios', function ($join) {
                            $join->on('fonoaudiologos.usuarios_ide_usu', '=', 'usuarios.ide_usu');
                        })
                        ->select('usuarios.nom_usu', 'usuarios.ape_usu', 'fonoaudiologos.*')
                        ->get();

        $usuarios_up = DB::table('usuarios')
                        ->where('usuarios.tipos_usuarios_ide_tip', 3)
                        ->get();

        $tab_current = 'li-section-bar-1';

        return view('admin.registro_fonoaudiologos', ['opcion' => $opcion,
                                                      'usuarios' => $usuarios,
                                                      'usuarios_up' => $usuarios_up,
                                                      'fonoaudiologos' => $fonoaudiologos,
                                                      'tab_current' => $tab_current]);
    }

    public function rubrica(Request $request, $id) {
        if (!$request->session()->exists('userid')) {
            return redirect('/');
        }
        $opcion = Opcion::where('id','=', base64_decode($id))->first();

        $juegos = DB::table('juegos')->get();
        $rubricas = DB::table('rubricas')->join('juegos', function ($join) {
                            $join->on('rubricas.juegos_ide_jue', '=', 'juegos.ide_jue');
                        })
                        ->select('juegos.nom_jue', 'rubricas.*')
                        ->get();

        $tab_current = 'li-section-bar-1';

        return view('admin.registro_rubrica', ['opcion' => $opcion,
                                                'juegos' => $juegos,
                                                'rubricas' => $rubricas,
                                                'tab_current' => $tab_current]);
    }

    public function createfon(FonoaudiologosCreateFormRequest $request) {
        if (!$request->session()->exists('userid')) {
            return redirect('/');
        }
        // $rules = [
        //     'ide_usu'  => 'required',
        //     'num_fon'  => 'required'
        // ];

        // $customMessages = [
        //     'ide_usu.required' => 'El campo Usuario es obligatorio.',
        //     'num_fon.required' => 'El campo Número de registro fonoaudiologo es obligatorio.',
        // ];

        // $this->validate($request, $rules, $customMessages);

        $fonoaudiologo = new Fonoaudiologo;

        $fonoaudiologo->num_fon = $request->num_fon;

        $fonoaudiologo->usuarios_ide_usu = $request->ide_usu;

        $query = $fonoaudiologo->save();
        $tab_current = 'li-section-bar-1';

        if($query) {
            return back()->with(['success' => 'La informaci&oacute;n se guard&oacute; satisfactoriamente.', 'tab_current' => $tab_current]);
        }
        else {
            return back()->with(['fail' => 'No se pudo guardar la informaci&oacute;n. Intente nuevamente.', 'tab_current' => $tab_current]);
        }
    }

    public function updatefon(FonoaudiologosUpdateFormRequest $request) {
        if (!$request->session()->exists('userid')) {
            return redirect('/');
        }
        // $rules = [
        //     'usuarios_ide_usu_edit'  => 'required',
        //     'num_fon_edit'  => 'required'
        // ];

        // $customMessages = [
        //     'usuarios_ide_usu_edit.required' => 'El campo Usuario es obligatorio.',
        //     'num_fon_edit.required' => 'El campo Número de registro fonoaudiologo es obligatorio.',
        // ];

        // $this->validate($request, $rules, $customMessages);

        $fonoaudiologo = new Fonoaudiologo;

        $fonoaudiologo = Fonoaudiologo::find($request->ide_fon_edit);

        $fonoaudiologo->num_fon = $request->num_fon_edit;

        $fonoaudiologo->usuarios_ide_usu = $request->usuarios_ide_usu;

        $query = $fonoaudiologo->save();
        $tab_current = 'li-section-bar-2';

        if($query) {
            return back()->with(['success' => 'La informaci&oacute;n se actualiz&oacute; satisfactoriamente.', 'tab_current' => $tab_current]);
        }
        else {
            return back()->with(['fail' => 'No se pudo actualizar la informaci&oacute;n. Intente nuevamente.', 'tab_current' => $tab_current]);
        }
    }

    public function createrub(RubricasCreateFormRequest $request) {
        if (!$request->session()->exists('userid')) {
            return redirect('/');
        }
        // $rules = [
        //     'ide_jue'  => 'required',
        //     'val_rub'  => 'required',
        //     'con_rub'  => 'required',
        // ];

        // $customMessages = [
        //     'ide_jue.required' => 'El campo Juego es obligatorio.',
        //     'val_rub.required' => 'El campo Valor es obligatorio.',
        //     'con_rub.required' => 'El campo Concepto es obligatorio.',
        // ];

        // $this->validate($request, $rules, $customMessages);

        $rubrica = new Rubrica;

        $rubrica->val_rub = $request->val_rub;
        $rubrica->con_rub = $request->con_rub;

        $rubrica->juegos_ide_jue= $request->ide_jue;

        $query = $rubrica->save();
        $tab_current = 'li-section-bar-1';

        if($query) {
            return back()->with(['success' => 'La informaci&oacute;n se guard&oacute; satisfactoriamente.', 'tab_current' => $tab_current]);
        }
        else {
            return back()->with(['fail' => 'No se pudo guardar la informaci&oacute;n. Intente nuevamente.', 'tab_current' => $tab_current]);
        }
    }

    public function updaterub(RubricasUpdateFormRequest $request) {
        if (!$request->session()->exists('userid')) {
            return redirect('/');
        }
        // $rules = [
        //     'juegos_ide_jue_edit'  => 'required',
        //     'val_rub_edit'  => 'required',
        //     'con_rub_edit'  => 'required',
        // ];

        // $customMessages = [
        //     'juegos_ide_jue_edit.required' => 'El campo Juego es obligatorio.',
        //     'val_rub_edit.required' => 'El campo Valor es obligatorio.',
        //     'con_rub_edit.required' => 'El campo Concepto es obligatorio.',
        // ];

        // $this->validate($request, $rules, $customMessages);

        $rubrica = new Rubrica;

        $rubrica = Rubrica::find($request->ide_rub_edit);

        $rubrica->val_rub = $request->val_rub_edit;
        $rubrica->con_rub = $request->con_rub_edit;

        $rubrica->juegos_ide_jue = $request->juegos_ide_jue_edit;

        $query = $rubrica->save();
        $tab_current = 'li-section-bar-2';

        if($query) {
            return back()->with(['success' => 'La informaci&oacute;n se actualiz&oacute; satisfactoriamente.', 'tab_current' => $tab_current]);
        }
        else {
            return back()->with(['fail' => 'No se pudo actualizar la informaci&oacute;n. Intente nuevamente.', 'tab_current' => $tab_current]);
        }
    }

    public function deleterub(Request $request) {
        if (!$request->session()->exists('userid')) {
            return redirect('/');
        }
        $rubrica = new Rubrica;
        $rubrica = Rubrica::find($request->input_delete);
        $query = $rubrica->delete();

        $tab_current = 'li-section-bar-2';

        if($query) {
            return back()->with(['success' => 'El registro se elimin&oacute; satisfactoriamente.', 'tab_current' => $tab_current]);
        }
        else {
            return back()->with(['fail' => 'No se pudo eliminar la informaci&oacute;n. Intente nuevamente.', 'tab_current' => $tab_current]);
        }
    }

    public function registro_usuarios(Request $request, $id) {
        if (!$request->session()->exists('userid')) {
            return redirect('/');
        }
        $opcion = Opcion::where('id','=', base64_decode($id))->first();
        $usuarios = DB::table('usuarios')->join('tipos_usuarios', function ($join) {
            $join->on('usuarios.tipos_usuarios_ide_tip', '=', 'tipos_usuarios.ide_tip');
        })
        ->where('usuarios.tipos_usuarios_ide_tip', '<>', '1')
        ->select('usuarios.*', 'tipos_usuarios.*')
        ->get();

        $tipos_usuarios = DB::table('tipos_usuarios')->get();
        $tab_current = 'li-section-bar-1';

        return view('admin.registro_usuarios', ['opcion' => $opcion,
                                                'usuarios' => $usuarios,
                                                'tipos_usuarios' => $tipos_usuarios,
                                                'tab_current' => $tab_current]);
    }

    public function createusu(UsuariosCreateFormRequest $request) {
        if (!$request->session()->exists('userid')) {
            return redirect('/');
        }
        // $rules = [
        //     'nom_usu'  => 'required',
        //     'ape_usu'  => 'required',
        //     'tid_usu'  => 'required',
        //     'ide_usu'  => 'required|unique:usuarios',
        //     'cor_usu'  => 'required|unique:usuarios',
        //     'fec_usu'  => 'required',
        //     'tel_usu'  => 'required',
        //     'dir_usu'  => 'required',
        //     'con_usu'  => 'required|string|min:6|confirmed',
        //     'con_usu_confirmation' => 'required|same:con_usu',
        //     'ide_tip'  => 'required',
        //     'est_usu'  => 'required',
        // ];

        // $customMessages = [
        //     'nom_usu.required' => 'El campo Nombres es obligatorio.',
        //     'ape_usu.required' => 'El campo Apellidos es obligatorio.',
        //     'tid_usu.required' => 'El campo Tipos identificación es obligatorio.',
        //     'ide_usu.required' => 'El campo Identificación es obligatorio.',
        //     'cor_usu.required' => 'El campo Correo electrónico es obligatorio.',
        //     'cor_usu.unique'   => 'El correo electrónico ya existe.',
        //     'fec_usu.required' => 'El campo Fecha nacimiento es obligatorio.',
        //     'tel_usu.required' => 'El campo Teléfono es obligatorio.',
        //     'dir_usu.required' => 'El campo Dirección es obligatorio.',
        //     'ide_usu.unique'   => 'La identificación ya existe.',
        //     'con_usu.required' => 'El campo Nueva contraseña es obligatorio.',
        //     'con_usu.min'      => 'La nueva contraseña es muy corta.',
        //     'con_usu_confirmation.required' => 'El campo Repita la nueva contraseña es obligatorio.',
        //     'con_usu.confirmed' => 'La confirmación de contraseña es erronea.',
        //     'con_usu_confirmation.same' => 'La confirmación de contraseña es erronea.',
        //     'ide_tip.required' => 'El campo Tipo usuario es obligatorio.',
        //     'est_usu.required' => 'El campo Estado es obligatorio.',
        // ];

        // $this->validate($request, $rules, $customMessages);

        $usuario = new Usuario;

        $usuario->nom_usu = $request->nom_usu;
        $usuario->ape_usu = $request->ape_usu;
        $usuario->tid_usu = $request->tid_usu;
        $usuario->ide_usu = $request->ide_usu;
        $usuario->cor_usu = $request->cor_usu;
        $date_variable = $request->fec_usu;
        $usuario->fec_usu = $date_variable;
        $usuario->tel_usu = $request->tel_usu;
        $usuario->dir_usu = $request->dir_usu;
        $usuario->con_usu = md5($request->con_usu);
        $usuario->tipos_usuarios_ide_tip = $request->ide_tip;
        $usuario->est_usu = $request->est_usu;

        $query = $usuario->save();
        $tab_current = 'li-section-bar-1';

        if($query) {
            return back()->with(['success' => 'La informaci&oacute;n se guard&oacute; satisfactoriamente.', 'tab_current' => $tab_current]);
        }
        else {
            return back()->with(['fail' => 'No se pudo guardar la informaci&oacute;n. Intente nuevamente.', 'tab_current' => $tab_current]);
        }
    }

    public function updateusu(UsuariosUpdateFormRequest $request) {
        if (!$request->session()->exists('userid')) {
            return redirect('/');
        }
        // $rules = [
        //     'nom_usu_edit'  => 'required',
        //     'ape_usu_edit'  => 'required',
        //     'tid_usu_edit'  => 'required',
        //     'ide_usu_edit'  => 'required',
        //     // 'cor_usu_edit'  => 'required|unique:usuarios,cor_usu,'. $request->ide_usu_edit . ',ide_usu',
        //     'cor_usu_edit'  => 'required',
        //     'fec_usu_edit'  => 'required',
        //     'tel_usu_edit'  => 'required',
        //     'dir_usu_edit'  => 'required',
        //     'con_usu_edit'  => 'required|string|min:6|confirmed',
        //     'con_usu_edit_confirmation' => 'required|same:con_usu_edit',
        //     'tipos_usuarios_ide_tip_edit'  => 'required',
        //     'est_usu_edit'  => 'required',
        // ];

        // $customMessages = [
        //     'nom_usu_edit.required' => 'El campo Nombres es obligatorio.',
        //     'ape_usu_edit.required' => 'El campo Apellidos es obligatorio.',
        //     'tid_usu_edit.required' => 'El campo Tipos identificación es obligatorio.',
        //     'ide_usu_edit.required' => 'El campo Identificación es obligatorio.',
        //     'cor_usu_edit.required' => 'El campo Correo electrónico es obligatorio.',
        //     'cor_usu_edit.unique'   => 'El correo electrónico ya existe.',
        //     'fec_usu_edit.required' => 'El campo Fecha nacimiento es obligatorio.',
        //     'tel_usu_edit.required' => 'El campo Teléfono es obligatorio.',
        //     'dir_usu_edit.required' => 'El campo Dirección es obligatorio.',
        //     'ide_usu_edit.unique'   => 'La identificación ya existe.',
        //     'con_usu_edit.required' => 'El campo Nueva contraseña es obligatorio.',
        //     'con_usu_edit.min'      => 'La nueva contraseña es muy corta.',
        //     'con_usu_edit_confirmation.required' => 'El campo Repita la nueva contraseña es obligatorio.',
        //     'con_usu_edit.confirmed' => 'La confirmación de contraseña es erronea.',
        //     'con_usu_edit_confirmation.same' => 'La confirmación de contraseña es erronea.',
        //     'tipos_usuarios_ide_tip_edit.required' => 'El campo Tipo usuario es obligatorio.',
        //     'est_usu_edit.required' => 'El campo Estado es obligatorio.',
        // ];

        //$this->validate($request, $rules, $customMessages);

        $tab_current = 'li-section-bar-2';

        $usuario = new Usuario;
        $usuario = Usuario::find($request->ide_usu_edit);

        $usuario->nom_usu = $request->nom_usu_edit;
        $usuario->ape_usu = $request->ape_usu_edit;
        $usuario->tid_usu = $request->tid_usu_edit;
        $usuario->ide_usu = $request->ide_usu_edit;
        $usuario->cor_usu = $request->cor_usu_edit;
        $date_variable = $request->fec_usu_edit;
        $usuario->fec_usu = $date_variable;
        $usuario->tel_usu = $request->tel_usu_edit;
        $usuario->dir_usu = $request->dir_usu_edit;

        if ($request->con_usu_edit != $usuario->con_usu) {
            $usuario->con_usu = md5($request->con_usu_edit);
        }

        $usuario->tipos_usuarios_ide_tip = $request->tipos_usuarios_ide_tip_edit;
        $usuario->est_usu = $request->est_usu_edit;

        $query = $usuario->save();

        if($query) {
            return back()->with(['success' => 'La informaci&oacute;n se actualiz&oacute; satisfactoriamente.', 'tab_current' => $tab_current]);
        }
        else {
            return back()->with(['fail' => 'No se pudo actualizar la informaci&oacute;n. Intente nuevamente.', 'tab_current' => $tab_current]);
        }
    }

    public function deleteusu(Request $request) {
        if (!$request->session()->exists('userid')) {
            return redirect('/');
        }

        $countUsuarios = DB::table('usuarios')
                            ->leftJoin('fonoaudiologos', 'fonoaudiologos.usuarios_ide_usu', '=', 'usuarios.ide_usu')
                            ->select(DB::raw('count(*) as usuarios_count'))
                            ->where('usuarios.ide_usu', $request->input_delete)
                            ->where(function($query) {
                                $query->orWhereNotNull('fonoaudiologos.usuarios_ide_usu');
                            })->first();

        $tab_current = 'li-section-bar-2';
        $usuario = new Usuario;
        $usuario = Usuario::find($request->input_delete);

        if($countUsuarios->usuarios_count == 0) {
            $query = $usuario->delete();
            if($query) {
                return back()->with(['success' => 'El registro se elimin&oacute; satisfactoriamente.', 'tab_current' => $tab_current]);
            }
            else {
                return back()->with(['fail' => 'No se pudo eliminar la informaci&oacute;n. Intente nuevamente.', 'tab_current' => $tab_current]);
            }
        }
        else {
            return back()->with(['fail' => 'No se pudo eliminar la informaci&oacute;n. El usuario <b>' . $usuario->nom_usu . ' ' . $usuario->ape_usu . '</b> ya posee informaci&oacute;n asociada.', 'tab_current' => $tab_current]);
        }
    }

    public function registro_juegos(Request $request, $id) {
        if (!$request->session()->exists('userid')) {
            return redirect('/');
        }
        $opcion = Opcion::where('id','=', base64_decode($id))->first();
        $juegos = DB::table('juegos')->join('tipos_juegos', function ($join) {
            $join->on('juegos.tipos_juegos_ide_tju', '=', 'tipos_juegos.ide_tju');
        })
        ->select('juegos.*', 'tipos_juegos.*')
        ->get();
        $tipos_juegos = DB::table('tipos_juegos')->get();
        $tab_current = 'li-section-bar-1';

        return view('admin.registro_juegos', ['opcion' => $opcion,
                                              'juegos' => $juegos,
                                              'tipos_juegos' => $tipos_juegos,
                                              'tab_current' => $tab_current]);
    }

    public function createjue(JuegosCreateFormRequest $request) {
        if (!$request->session()->exists('userid')) {
            return redirect('/');
        }
        // $rules = [
        //     'nom_jue'  => 'required',
        //     'mod_jue'  => 'required',
        //     'tic_jue'  => 'required',
        //     'ale_jue'  => 'required',
        //     'pun_jue'  => 'required',
        //     'ide_tju'  => 'required',
        // ];

        // $customMessages = [
        //     'nom_jue.required' => 'El campo Nombre juego es obligatorio.',
        //     'mod_jue.required' => 'El campo Modo juego es obligatorio.',
        //     'tic_jue.required' => 'El campo Tipo concepto juego es obligatorio.',
        //     'ale_jue.required' => 'El campo Ale jue es obligatorio.',
        //     'pun_jue.required' => 'El campo Puntaje es obligatorio.',
        //     'ide_tju.required' => 'El campo Tipo juego es obligatorio.',
        // ];

        // $this->validate($request, $rules, $customMessages);

        $juego = new Juego;

        $juego->nom_jue = $request->nom_jue;
        $juego->mod_jue = $request->mod_jue;
        $juego->tic_jue = $request->tic_jue;
        $juego->ale_jue = $request->ale_jue;
        $juego->pun_jue = $request->pun_jue;
        $juego->tipos_juegos_ide_tju = $request->ide_tju;

        $query = $juego->save();
        $tab_current = 'li-section-bar-1';

        if($query) {
            return back()->with(['success' => 'La informaci&oacute;n se guard&oacute; satisfactoriamente.', 'tab_current' => $tab_current]);
        }
        else {
            return back()->with(['fail' => 'No se pudo guardar la informaci&oacute;n. Intente nuevamente.', 'tab_current' => $tab_current]);
        }
    }

    public function updatejue(JuegosUpdateFormRequest $request) {
        if (!$request->session()->exists('userid')) {
            return redirect('/');
        }
        // $rules = [
        //     'nom_jue_edit'  => 'required',
        //     'mod_jue_edit'  => 'required',
        //     'tic_jue_edit'  => 'required',
        //     'ale_jue_edit'  => 'required',
        //     'pun_jue_edit'  => 'required',
        //     'tipos_juegos_ide_tju_edit'  => 'required',
        // ];

        // $customMessages = [
        //     'nom_jue_edit.required' => 'El campo Nombre juego es obligatorio.',
        //     'mod_jue_edit.required' => 'El campo Modo juego es obligatorio.',
        //     'tic_jue_edit.required' => 'El campo Tipo concepto juego es obligatorio.',
        //     'ale_jue_edit.required' => 'El campo Ale jue es obligatorio.',
        //     'pun_jue_edit.required' => 'El campo Puntaje es obligatorio.',
        //     'tipos_juegos_ide_tju_edit.required' => 'El campo Tipo juego es obligatorio.',
        // ];

        //$this->validate($request, $rules, $customMessages);

        $tab_current = 'li-section-bar-2';

        $juego = new Juego;
        $juego = Juego::find($request->ide_jue_edit);

        $juego->nom_jue = $request->nom_jue_edit;
        $juego->mod_jue = $request->mod_jue_edit;
        $juego->tic_jue = $request->tic_jue_edit;
        $juego->ale_jue = $request->ale_jue_edit;
        $juego->pun_jue = $request->pun_jue_edit;
        $juego->tipos_juegos_ide_tju = $request->tipos_juegos_ide_tju_edit;

        $query = $juego->save();

        if($query) {
            return back()->with(['success' => 'La informaci&oacute;n se actualiz&oacute; satisfactoriamente.', 'tab_current' => $tab_current]);
        }
        else {
            return back()->with(['fail' => 'No se pudo actualizar la informaci&oacute;n. Intente nuevamente.', 'tab_current' => $tab_current]);
        }
    }

    public function deletejue(Request $request) {
        if (!$request->session()->exists('userid')) {
            return redirect('/');
        }

        $countJuegos = DB::table('juegos')
                            ->leftJoin('juegos_pacientes', 'juegos_pacientes.juegos_ide_jue', '=', 'juegos.ide_jue')
                            ->leftJoin('valoraciones_juegos', 'valoraciones_juegos.juegos_ide_jue', '=', 'juegos.ide_jue')
                            ->select(DB::raw('count(*) as juegos_count'))
                            ->where('juegos.ide_jue', $request->input_delete)
                            ->where(function($query) {
                                $query->orWhereNotNull('juegos_pacientes.juegos_ide_jue')
                                      ->orWhereNotNull('valoraciones_juegos.juegos_ide_jue');
                            })->first();

        $tab_current = 'li-section-bar-2';
        $juego = new Juego;
        $juego = Juego::find($request->input_delete);

        if($countJuegos->juegos_count == 0) {
            $query = $juego->delete();
            if($query) {
                return back()->with(['success' => 'El registro se elimin&oacute; satisfactoriamente.', 'tab_current' => $tab_current]);
            }
            else {
                return back()->with(['fail' => 'No se pudo eliminar la informaci&oacute;n. Intente nuevamente.', 'tab_current' => $tab_current]);
            }
        }
        else {
            return back()->with(['fail' => 'No se pudo eliminar la informaci&oacute;n. El juego <b>' . $juego->nom_jue . '</b> ya posee informaci&oacute;n asociada.', 'tab_current' => $tab_current]);
        }
    }
}
