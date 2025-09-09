<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;
use App\Models\Empleado;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('auth.login');
});
/* Route::get('/empleado', function () {
    return view('empleado.index');
    });

Route::get('/empleado/create', [EmpleadoController::class,'create']);
*/
Route::resource('empleado', EmpleadoController::class)->middleware('auth');

Auth::routes([
    'register' => false,
    'reset' => false,
]);


Route::get('/home', [EmpleadoController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/',[EmpleadoController::class, 'index'])->name('home');
});
Route::get('/test', function () {
    \Illuminate\Support\Facades\Log::info('Test route called');
    return 'OK';
});