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


/////////VISTAS: CLIC SIDEBAR
Route::get('/registro_guia', function () { 
    return view('registro_guia');
})->name('registro_guia');

Route::get('/aprobacion_solicitud', function () { 
    return view('aprobacion_solicitud');
})->name('aprobacion_solicitud');
