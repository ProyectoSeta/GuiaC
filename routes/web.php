<?php

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth\login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/solicitud', [App\Http\Controllers\SolicitudController::class, 'index'])->name('solicitud');

/*Usuario sujeto pasivo*/

Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('user');
Route::post('/user', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');

//Route::get('/user/{slug?}/roles', [App\Http\Controllers\UserController::class, 'roles'])->name('user.roles');
//Route::get('/user/{slug?}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
//Route::put('/user/{slug?}/updat', [App\Http\Controllers\UserController::class, 'updat'])->name('user.updat');
//Route::put('/user/{slug?}', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');

/////// CANTERAS
Route::get('/cantera', [App\Http\Controllers\CanteraController::class, 'index'])->name('cantera');
Route::post('/cantera/store', [App\Http\Controllers\CanteraController::class, 'store'])->name('cantera.store');
Route::post('/cantera/minerales', [App\Http\Controllers\CanteraController::class, 'minerales'])->name('cantera.minerales');
Route::post('/cantera/info_denegada', [App\Http\Controllers\CanteraController::class, 'info_denegada'])->name('cantera.info_denegada');
Route::post('/cantera/info_limite', [App\Http\Controllers\CanteraController::class, 'info_limite'])->name('cantera.info_limite');
Route::post('/cantera', [App\Http\Controllers\CanteraController::class, 'destroy'])->name('cantera.destroy');

///////SUJETO PASIVO
Route::get('/sujeto', [App\Http\Controllers\SujetoController::class, 'index'])->name('sujeto');
Route::post('/sujeto/representante', [App\Http\Controllers\SujetoController::class, 'representante'])->name('sujeto.representante');

////////SOLICITUD
Route::get('/solicitud', [App\Http\Controllers\SolicitudController::class, 'index'])->name('solicitud');
Route::post('/solicitud/new_solicitud', [App\Http\Controllers\SolicitudController::class, 'new_solicitud'])->name('solicitud.new_solicitud');


Route::post('/solicitud/calcular', [App\Http\Controllers\SolicitudController::class, 'calcular'])->name('solicitud.calcular');
Route::post('/solicitud/store', [App\Http\Controllers\SolicitudController::class, 'store'])->name('solicitud.store');
Route::post('/solicitud/talonarios', [App\Http\Controllers\SolicitudController::class, 'talonarios'])->name('solicitud.talonarios');
Route::post('/solicitud/pago', [App\Http\Controllers\SolicitudController::class, 'pago'])->name('solicitud.pago');
Route::post('/solicitud', [App\Http\Controllers\SolicitudController::class, 'destroy'])->name('solicitud.destroy');


///////////APROBACIÓN DE SOLICITUDES
Route::get('/aprobacion_solicitud', [App\Http\Controllers\AprobacionController::class, 'index'])->name('aprobacion');
Route::post('/aprobacion_solicitud/sujeto', [App\Http\Controllers\AprobacionController::class, 'sujeto'])->name('aprobacion.sujeto');
Route::post('/aprobacion_solicitud/aprobar', [App\Http\Controllers\AprobacionController::class, 'aprobar'])->name('aprobacion.aprobar');
Route::post('/aprobacion_solicitud/correlativo', [App\Http\Controllers\AprobacionController::class, 'correlativo'])->name('aprobacion.correlativo');
Route::post('/aprobacion_solicitud/info', [App\Http\Controllers\AprobacionController::class, 'info'])->name('aprobacion.info');
Route::post('/aprobacion_solicitud/denegarInfo', [App\Http\Controllers\AprobacionController::class, 'denegarInfo'])->name('aprobacion.denegarInfo');
Route::post('/aprobacion_solicitud/denegar', [App\Http\Controllers\AprobacionController::class, 'denegar'])->name('aprobacion.denegar');
Route::get('/aprobacion_solicitud/qr', [App\Http\Controllers\AprobacionController::class, 'qr'])->name('aprobacion.qr');
// Route::get('/aprobacion_solicitud/qr', [App\Http\Controllers\AprobacionController::class, 'qr'])->name('qr');




///////////ESTADO DE SOLICITUDES
Route::get('/estado', [App\Http\Controllers\EstadoController::class, 'index'])->name('estado');
Route::post('/estado/solicitud', [App\Http\Controllers\EstadoController::class, 'solicitud'])->name('estado.solicitud');
Route::post('/estado/info_denegada', [App\Http\Controllers\EstadoController::class, 'info_denegada'])->name('estado.info_denegada');
Route::post('/estado/actualizar', [App\Http\Controllers\EstadoController::class, 'actualizar'])->name('estado.actualizar');


//////////////CORRELATIVO
Route::get('/correlativo', [App\Http\Controllers\CorrelativoController::class, 'index'])->name('correlativo');
Route::post('/correlativo/talonario', [App\Http\Controllers\CorrelativoController::class, 'talonario'])->name('correlativo.talonario');
Route::post('/correlativo/guia', [App\Http\Controllers\CorrelativoController::class, 'guia'])->name('correlativo.guia');
Route::post('/correlativo/qr', [App\Http\Controllers\CorrelativoController::class, 'qr'])->name('correlativo.qr');


////////////////VERIFICAR NUEVO USUARIO
Route::get('/verificar_user', [App\Http\Controllers\VerificarUserController::class, 'index'])->name('verificar_user');
Route::post('/verificar_user/info', [App\Http\Controllers\VerificarUserController::class, 'info'])->name('verificar_user.info');
Route::post('/verificar_user/aprobar', [App\Http\Controllers\VerificarUserController::class, 'aprobar'])->name('verificar_user.aprobar');
Route::post('/verificar_user/info_denegar', [App\Http\Controllers\VerificarUserController::class, 'info_denegar'])->name('verificar_user.info_denegar');
Route::post('/verificar_user/denegar', [App\Http\Controllers\VerificarUserController::class, 'denegar'])->name('verificar_user.denegar');


////////////////VERIFICAR CANTERA
Route::get('/verificar_cantera', [App\Http\Controllers\VerificarCanteraController::class, 'index'])->name('verificar_cantera');
Route::post('/verificar_cantera/info', [App\Http\Controllers\VerificarCanteraController::class, 'info'])->name('verificar_cantera.info');
Route::post('/verificar_cantera/verificar', [App\Http\Controllers\VerificarCanteraController::class, 'verificar'])->name('verificar_cantera.verificar');
Route::post('/verificar_cantera/info_denegar', [App\Http\Controllers\VerificarCanteraController::class, 'info_denegar'])->name('verificar_cantera.info_denegar');
Route::post('/verificar_cantera/denegar', [App\Http\Controllers\VerificarCanteraController::class, 'denegar'])->name('verificar_cantera.denegar');

////////////////LIBRO DE CONTRO: REGISTRO DE GUÍAS
Route::get('/registro_guia', [App\Http\Controllers\RegistroGuiaController::class, 'index'])->name('registro_guia');
Route::post('/registro_guia/modal_registro', [App\Http\Controllers\RegistroGuiaController::class, 'modal_registro'])->name('registro_guia.modal_registro');
Route::post('/registro_guia/cantera', [App\Http\Controllers\RegistroGuiaController::class, 'cantera'])->name('registro_guia.cantera');
Route::post('/registro_guia/store', [App\Http\Controllers\RegistroGuiaController::class, 'store'])->name('registro_guia.store');
Route::post('/registro_guia/editar', [App\Http\Controllers\RegistroGuiaController::class, 'editar'])->name('registro_guia.editar');
Route::post('/registro_guia/editar_guia', [App\Http\Controllers\RegistroGuiaController::class, 'editar_guia'])->name('registro_guia.editar_guia');
Route::post('/registro_guia', [App\Http\Controllers\RegistroGuiaController::class, 'destroy'])->name('registro_guia.destroy');



//////////////////CONFIGURACION DE USUARIO:CONTRIBUYENTES
Route::get('/settings_contribuyente', [App\Http\Controllers\SettingsContribuyenteController::class, 'index'])->name('settings_contribuyente');