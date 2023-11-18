<?php

use App\Http\Controllers\ControllerUsuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/usuario', [ControllerUsuarios::class, 'getUsuario']);
Route::post('/usuario/insertar', [ControllerUsuarios::class, 'store']);
Route::put('/usuario/editar/{id}', [ControllerUsuarios::class, 'update']);
Route::delete('/usuario/eliminar/{id}', [ControllerUsuarios::class, 'destroy']);


