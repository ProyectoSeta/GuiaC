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
Route::post('/cantera', [App\Http\Controllers\CanteraController::class, 'destroy'])->name('cantera.destroy');

///////SUJETO PASIVO
Route::get('/sujeto', [App\Http\Controllers\SujetoController::class, 'index'])->name('sujeto');


////////SOLICITUD
Route::get('/solicitud', [App\Http\Controllers\SolicitudController::class, 'index'])->name('solicitud');
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
Route::post('/aprobacion_solicitud/denegar', [App\Http\Controllers\AprobacionController::class, 'denegar'])->name('aprobacion.denegar');


/////////VISTAS: CLIC SIDEBAR
Route::get('/registro_guia', function () { 
    return view('registro_guia');
})->name('registro_guia');

