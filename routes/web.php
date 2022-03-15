<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AniosController;
use App\Http\Controllers\BancosController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\ClasesMutacionController;
use App\Http\Controllers\ClasesPredioController;
use App\Http\Controllers\ConceptosPredioController;
use App\Http\Controllers\DescuentosController;
use App\Http\Controllers\ErrorRequestController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TiposPredioController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('auth.login');
// });
Route::get('/', [LoginController::class, 'login']);
Route::get('logout', [LoginController::class, 'logout'])->name('auth.logout');

//Login
Route::post('checkLogin', [LoginController::class, 'checkLogin'])->name('auth.checkLogin')->middleware('checkdb');
Route::get('profile', [LoginController::class, 'profile'])->middleware('checkdb');

Route::get('cambiar_password', [ChangePasswordController::class, 'index'])->name('auth.index_change_pass')->middleware('checkdb');
Route::post('changepass', [ChangePasswordController::class, 'changepass'])->name('auth.change_pass')->middleware('checkdb');

//Pacientes y Acudientes
// Route::get('atencion_usuarios', [AtencionUsuariosController::class, 'atencion_usuarios'])->middleware('checkdb');

// Route::get('registro_pacientes/{id}', [AtencionUsuariosController::class, 'registro_pacientes'])->middleware('checkdb');
// Route::get('registro_pacientes', [ErrorRequestController::class, 'error_request'])->middleware('checkdb');

// Route::get('reporte_pacientes_au/{id}', [AtencionUsuariosController::class, 'reporte_pacientes'])->middleware('checkdb');
// Route::get('reporte_pacientes_au', [ErrorRequestController::class, 'error_request'])->middleware('checkdb');

// Route::get('registro_acudientes/{id}', [AtencionUsuariosController::class, 'registro_acudientes'])->middleware('checkdb');
// Route::get('registro_acudientes', [ErrorRequestController::class, 'error_request'])->middleware('checkdb');

// Route::get('acudientes_paciente/{id}', [AtencionUsuariosController::class, 'acudientes_paciente'])->middleware('checkdb');
// Route::get('acudientes_paciente', [ErrorRequestController::class, 'error_request'])->middleware('checkdb');

// Route::post('createpac', [AtencionUsuariosController::class, 'createpac'])->name('aten.create_pac')->middleware('checkdb');
// Route::post('updatepac', [AtencionUsuariosController::class, 'updatepac'])->name('aten.update_pac')->middleware('checkdb');
// Route::post('deletepac', [AtencionUsuariosController::class, 'deletepac'])->name('aten.delete_pac')->middleware('checkdb');

// Route::post('createasoc', [AtencionUsuariosController::class, 'createasoc'])->name('aten.create_asoc')->middleware('checkdb');
// Route::post('updateasoc', [AtencionUsuariosController::class, 'updateasoc'])->name('aten.update_asoc')->middleware('checkdb');
// Route::post('deleteasoc', [AtencionUsuariosController::class, 'deleteasoc'])->name('aten.delete_asoc')->middleware('checkdb');

// Route::post('createacu', [AtencionUsuariosController::class, 'createacu'])->name('aten.create_acu')->middleware('checkdb');
// Route::post('updateacu', [AtencionUsuariosController::class, 'updateacu'])->name('aten.update_acu')->middleware('checkdb');
// Route::post('deleteacu', [AtencionUsuariosController::class, 'deleteacu'])->name('aten.delete_acu')->middleware('checkdb');

// Route::get('citas/{id}', [AtencionUsuariosController::class, 'citas'])->middleware('checkdb');
// Route::get('citas_paciente/{id}/{paciente}', [AtencionUsuariosController::class, 'citas_paciente'])->middleware('checkdb');
// Route::get('citas', [ErrorRequestController::class, 'error_request'])->middleware('checkdb');
// Route::get('citas_paciente', [ErrorRequestController::class, 'error_request'])->middleware('checkdb');
// Route::get('citas_paciente/{id}', [ErrorRequestController::class, 'error_request'])->middleware('checkdb');

// Route::post('createcit', [AtencionUsuariosController::class, 'createcit'])->name('aten.create_cit')->middleware('checkdb');
// Route::post('updatecit', [AtencionUsuariosController::class, 'updatecit'])->name('aten.update_cit')->middleware('checkdb');

// Route::get('/available/hours', [AtencionUsuariosController::class, 'getAvailableHours']);
// Route::get('/iavailable/hours', [AtencionUsuariosController::class, 'getAvailableHoursInclusive']);

//Fonoaudiologia
// Route::get('dislex_game/{id}/{id_cita}', [FonoaudiologiaController::class, 'dislex_game'])->middleware('checkdb');
// Route::get('dislex_game', [ErrorRequestController::class, 'error_request'])->middleware('checkdb');
// Route::get('dislex_game/{id}', [ErrorRequestController::class, 'error_request'])->middleware('checkdb');

// Route::get('historial_medico/{id}', [FonoaudiologiaController::class, 'historial_medico'])->middleware('checkdb');
// Route::get('historial_medico', [ErrorRequestController::class, 'error_request'])->middleware('checkdb');

// Route::get('remision/{id}', [FonoaudiologiaController::class, 'remision'])->middleware('checkdb');
// Route::get('remision', [ErrorRequestController::class, 'error_request'])->middleware('checkdb');

// Route::get('reporte_pacientes_fo/{id}', [FonoaudiologiaController::class, 'reporte_pacientes'])->middleware('checkdb');
// Route::get('reporte_pacientes_fo', [ErrorRequestController::class, 'error_request'])->middleware('checkdb');

// Route::get('citas_fonoaudiologo/{id}', [FonoaudiologiaController::class, 'citas_fonoaudiologo'])->middleware('checkdb');
// Route::get('citas_fonoaudiologo', [ErrorRequestController::class, 'error_request'])->middleware('checkdb');

// Route::post('createhist', [FonoaudiologiaController::class, 'createhist'])->name('fono.create_hist')->middleware('checkdb');
// Route::post('updatehist', [FonoaudiologiaController::class, 'updatehist'])->name('fono.update_hist')->middleware('checkdb');

// Route::post('createrem', [FonoaudiologiaController::class, 'createrem'])->name('fono.create_rem')->middleware('checkdb');
// Route::post('updaterem', [FonoaudiologiaController::class, 'updaterem'])->name('fono.update_rem')->middleware('checkdb');
// Route::post('deleterem', [FonoaudiologiaController::class, 'deleterem'])->name('fono.delete_rem')->middleware('checkdb');

//Administracion
// Route::get('registro_fonoaudiologos/{id}', [AdministracionController::class, 'registro_fonoaudiologos'])->middleware('checkdb');
// Route::get('registro_fonoaudiologos', [ErrorRequestController::class, 'error_request'])->middleware('checkdb');

// Route::get('rubrica/{id}', [AdministracionController::class, 'rubrica'])->middleware('checkdb');
// Route::get('rubrica', [ErrorRequestController::class, 'error_request'])->middleware('checkdb');

// Route::get('registro_usuarios/{id}', [AdministracionController::class, 'registro_usuarios'])->middleware('checkdb');
// Route::get('registro_usuarios', [ErrorRequestController::class, 'error_request'])->middleware('checkdb');

// Route::get('registro_juegos/{id}', [AdministracionController::class, 'registro_juegos'])->middleware('checkdb');
// Route::get('registro_juegos', [ErrorRequestController::class, 'error_request'])->middleware('checkdb');

// Route::post('createfon', [AdministracionController::class, 'createfon'])->name('admin.create_fon')->middleware('checkdb');
// Route::post('updatefon', [AdministracionController::class, 'updatefon'])->name('admin.update_fon')->middleware('checkdb');

// Route::post('createrub', [AdministracionController::class, 'createrub'])->name('admin.create_rub')->middleware('checkdb');
// Route::post('updaterub', [AdministracionController::class, 'updaterub'])->name('admin.update_rub')->middleware('checkdb');
// Route::post('deleterub', [AdministracionController::class, 'deleterub'])->name('admin.delete_rub')->middleware('checkdb');

// Route::post('createusu', [AdministracionController::class, 'createusu'])->name('admin.create_usu')->middleware('checkdb');
// Route::post('updateusu', [AdministracionController::class, 'updateusu'])->name('admin.update_usu')->middleware('checkdb');
// Route::post('deleteusu', [AdministracionController::class, 'deleteusu'])->name('admin.delete_usu')->middleware('checkdb');

// Route::post('createjue', [AdministracionController::class, 'createjue'])->name('admin.create_jue')->middleware('checkdb');
// Route::post('updatejue', [AdministracionController::class, 'updatejue'])->name('admin.update_jue')->middleware('checkdb');
// Route::post('deletejue', [AdministracionController::class, 'deletejue'])->name('admin.delete_jue')->middleware('checkdb');

// Route::get('generate-pdf', [AtencionUsuariosController::class, 'generatePDF'])->name('aten.patientreport')->middleware('checkdb');
// Route::get('generate-pdf/{id}', [AtencionUsuariosController::class, 'generatePDFByIdPaciente'])->name('aten.singlepatientreport')->middleware('checkdb');

//juego paciente
// Route::get('dislex_game/gamedata', [FonoaudiologiaController::class, 'Data']);

// Route::get('games', [JuegoPaciente::class, 'guardar']);

// Route::get('jueguito', [JuegoPaciente::class, 'juego']);

//ClasesMutacionController
Route::get('registro_clasesmutacion/{id}', [ClasesMutacionController::class, 'create'])->middleware('checkdb');
Route::get('registro_clasesmutacion', [ErrorRequestController::class, 'error_request'])->middleware('checkdb');

Route::post('create_clasesmutacion', [ClasesMutacionController::class, 'store'])->name('clasesmutacion.create_clasesmutacion')->middleware('checkdb');
Route::post('update_clasesmutacion', [ClasesMutacionController::class, 'update'])->name('clasesmutacion.update_clasesmutacion')->middleware('checkdb');
Route::post('delete_clasesmutacion', [ClasesMutacionController::class, 'destroy'])->name('clasesmutacion.delete_clasesmutacion')->middleware('checkdb');

//ClasesPredioController
Route::get('registro_clasespredio/{id}', [ClasesPredioController::class, 'create'])->middleware('checkdb');
Route::get('registro_clasespredio', [ErrorRequestController::class, 'error_request'])->middleware('checkdb');

Route::post('create_clasespredio', [ClasesPredioController::class, 'store'])->name('clasespredio.create_clasespredio')->middleware('checkdb');
Route::post('update_clasespredio', [ClasesPredioController::class, 'update'])->name('clasespredio.update_clasespredio')->middleware('checkdb');
Route::post('delete_clasespredio', [ClasesPredioController::class, 'destroy'])->name('clasespredio.delete_clasespredio')->middleware('checkdb');

//ConceptosPredioController
Route::get('registro_conceptospredio/{id}', [ConceptosPredioController::class, 'create'])->middleware('checkdb');
Route::get('registro_conceptospredio', [ErrorRequestController::class, 'error_request'])->middleware('checkdb');

Route::post('create_conceptospredio', [ConceptosPredioController::class, 'store'])->name('conceptospredio.create_conceptospredio')->middleware('checkdb');
Route::post('update_conceptospredio', [ConceptosPredioController::class, 'update'])->name('conceptospredio.update_conceptospredio')->middleware('checkdb');
Route::post('delete_conceptospredio', [ConceptosPredioController::class, 'destroy'])->name('conceptospredio.delete_conceptospredio')->middleware('checkdb');

//TiposPredioController
Route::get('registro_tipospredio/{id}', [TiposPredioController::class, 'create'])->middleware('checkdb');
Route::get('registro_tipospredio', [ErrorRequestController::class, 'error_request'])->middleware('checkdb');

Route::post('create_tipospredio', [TiposPredioController::class, 'store'])->name('tipospredio.create_tipospredio')->middleware('checkdb');
Route::post('update_tipospredio', [TiposPredioController::class, 'update'])->name('tipospredio.update_tipospredio')->middleware('checkdb');
Route::post('delete_tipospredio', [TiposPredioController::class, 'destroy'])->name('tipospredio.delete_tipospredio')->middleware('checkdb');

//AniosController
Route::get('registro_anios/{id}', [AniosController::class, 'create'])->middleware('checkdb');
Route::get('registro_anios', [ErrorRequestController::class, 'error_request'])->middleware('checkdb');

Route::post('create_anios', [AniosController::class, 'store'])->name('anios.create_anios')->middleware('checkdb');
Route::post('update_anios', [AniosController::class, 'update'])->name('anios.update_anios')->middleware('checkdb');
Route::post('delete_anios', [AniosController::class, 'destroy'])->name('anios.delete_anios')->middleware('checkdb');

//BancosController
Route::get('registro_bancos/{id}', [BancosController::class, 'create'])->middleware('checkdb');
Route::get('registro_bancos', [ErrorRequestController::class, 'error_request'])->middleware('checkdb');

Route::post('create_bancos', [BancosController::class, 'store'])->name('bancos.create_bancos')->middleware('checkdb');
Route::post('update_bancos', [BancosController::class, 'update'])->name('bancos.update_bancos')->middleware('checkdb');
Route::post('delete_bancos', [BancosController::class, 'destroy'])->name('bancos.delete_bancos')->middleware('checkdb');

//DescuentosController
Route::get('registro_descuentos/{id}', [DescuentosController::class, 'create'])->middleware('checkdb');
Route::get('registro_descuentos', [ErrorRequestController::class, 'error_request'])->middleware('checkdb');

Route::post('create_descuentos', [DescuentosController::class, 'store'])->name('descuentos.create_descuentos')->middleware('checkdb');
Route::post('update_descuentos', [DescuentosController::class, 'update'])->name('descuentos.update_descuentos')->middleware('checkdb');
Route::post('delete_descuentos', [DescuentosController::class, 'destroy'])->name('descuentos.delete_descuentos')->middleware('checkdb');
