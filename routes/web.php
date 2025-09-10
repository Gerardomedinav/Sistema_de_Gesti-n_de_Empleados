<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;
use App\Models\Empleado;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('auth.login');
});

Route::resource('empleado', EmpleadoController::class)->middleware('auth');

Auth::routes([
    'register' => false,
    'reset' => false,
]);

// Ruta principal para la página de inicio después de login
Route::group(['middleware' => ['auth']], function () {
    Route::get('/', [EmpleadoController::class, 'index'])->name('home');
});

Route::get('/test', function () {
    \Illuminate\Support\Facades\Log::info('Test route called');
    return 'OK';
});