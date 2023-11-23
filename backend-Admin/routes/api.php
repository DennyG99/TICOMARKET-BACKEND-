<?php

use App\Http\Controllers\ControllerUsuarios;
use App\Http\Controllers\ControllerVendedores;
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


//Vendedor 
Route::get('/vendedor/mostrar/{id}', [ControllerVendedores::class, 'index']);
Route::get('/vendedor/editar/{id}', [ControllerVendedores::class, 'edit']);
Route::get('/vendedor/pdf/{id}', [ControllerVendedores::class, 'exportPDF']);
Route::put('/vendedor/modificar/{id}', [ControllerVendedores::class, 'update']);
Route::get('/vendedor/listar', [ControllerVendedores::class,'index']);
Route::post('/vendedor/eliminar/{id}', [ControllerVendedores::class, 'eliminarVendedor']);




