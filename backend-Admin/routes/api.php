<?php

use App\Http\Controllers\ControllerPoliticas;
use App\Http\Controllers\ControllerUsuarios;
use App\Http\Controllers\ControllerLogin;
use App\Http\Controllers\ControllerProductos;
use App\Http\Controllers\ControllerOfertas;
use App\Http\Controllers\ControllerVentas;
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

|Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::get('/usuario', [ControllerUsuarios::class, 'getUsuario']);
Route::post('/usuario/insertar', [ControllerUsuarios::class, 'store']);
Route::put('/usuario/editar/{id}', [ControllerUsuarios::class, 'update']);
Route::delete('/usuario/eliminar/{id}', [ControllerUsuarios::class, 'destroy']);

//RESUMENES ESTADÍSTICOS DE ADMINISTRADOR
Route::get('/admin/productos-mas-vendidos', [ControllerProductos::class, 'productosMasVendidos']);
Route::get('/admin/ingresos-por-anuncios', [ControllerOfertas::class, 'ingresosPorAnuncios']);
Route::get('/admin/estado-usuarios', [ControllerUsuarios::class, 'estadoUsuarios']);
Route::get('/admin/ventas-por-tienda', [ControllerVentas::class, 'ventasPorTienda']);
Route::get('/admin/vendedores-cotizados', [ControllerVendedores::class, 'mostrarVendedoresCotizados']);

//Administrar Políticas
Route::get('/politicas', [ControllerPoliticas::class, 'MostrarPoliticas']);
Route::post('/politicas/crear', [ControllerPoliticas::class, 'crear']);
Route::put('/politicas/editar/{idPolitica}', [ControllerPoliticas::class, 'editar']);
Route::delete('/usuario/eliminar/{idPolitica}', [ControllerPoliticas::class, 'eliminar']);

//login entre otros metodos de autenticacion
Route::post('login', [ControllerLogin::class,'login']);
Route::post('register', [ControllerLogin::class,'register']);

//Vendedor 
Route::get('/vendedor/mostrar/{id}', [ControllerVendedores::class, 'index']);
Route::get('/vendedor/editar/{id}', [ControllerVendedores::class, 'edit']);
Route::get('/vendedor/pdf/{id}', [ControllerVendedores::class, 'exportPDF']);
Route::put('/vendedor/modificar/{id}', [ControllerVendedores::class, 'update']);
Route::get('/vendedor/listar', [ControllerVendedores::class,'index']);
Route::post('/vendedor/eliminar/{id}', [ControllerVendedores::class, 'eliminarVendedor']);



Route::middleware('auth:sanctum')->group(function (){
    Route::get('logout', [ControllerLogin::class,'logout']);
    Route::get('user', [ControllerLogin::class,'getUser']);
    Route::post('/verificacion', [ControllerLogin::class, 'verificacionAdmin']);

});


//Estados
Route::get('/estado', [ControllerEstados::class, 'index']);
Route::post('/estado', [ControllerEstados::class, 'store']);
Route::delete('/estado', [ControllerEstados::class, 'destroy']);
Route::put('/estado', [ControllerEstados::class, 'update']);


Route::post('/notificacion', [ControllerNotificaciones::class, 'val']);