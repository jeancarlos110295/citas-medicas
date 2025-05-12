<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControllerTestApi;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Pagos\PagoController;
use App\Http\Controllers\Citas\CitasController;
use App\Http\Controllers\Usuarios\UsuariosController;
use App\Http\Controllers\Medico\MedicoCitasController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/test-api', [ControllerTestApi::class, 'index']);

Route::resource('usuarios', UsuariosController::class)->only([
    'store'
]);

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
});

Route::resource('citas', CitasController::class)->only([
    'store'
]);


Route::controller(PagoController::class)->prefix('pagos')->group(function () {
    Route::post('{cita}/pago', 'store')->name('pagos.store');
    Route::match(['get', 'post'], 'exito', 'exito')->name('pagos.exito');
    Route::match(['get', 'post'],'webhook', 'webhook')->name('pagos.webhook');
});


Route::resource('medicocitas', MedicoCitasController::class)->only([
    'index',
    'show',
    'update'
]);