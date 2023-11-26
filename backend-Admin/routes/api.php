<?php

use App\Http\Controllers\ControllerPoliticas;
use App\Http\Controllers\ControllerUsuarios;
use App\Http\Controllers\ControllerLogin;
use App\Http\Controllers\ControllerProductos;
use App\Http\Controllers\ControllerOfertas;
use App\Http\Controllers\ControllerVentas;
use App\Http\Controllers\ControllerVendedores;
use App\Http\Controllers\ControllerEstados;
use App\Http\Controllers\ControllerNotificaciones;
use App\Http\Controllers\ControllerPlanes;
use App\Http\Controllers\ControllerSubcategorias;
use App\Http\Controllers\ControllerCategorias;
use App\Http\Controllers\ControllerReembolsos;
use App\Http\Controllers\ControllerRol;
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
Route::delete('/politicas/eliminar/{idPolitica}', [ControllerPoliticas::class, 'eliminar']);

//login entre otros metodos de autenticacion
Route::post('login', [ControllerLogin::class,'login']);
Route::post('register', [ControllerLogin::class,'register']);


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

//Subcategorias
Route::get('/subcategorias', [ControllerSubcategorias::class, 'index']);
Route::post('/subcategorias/crear', [ControllerSubcategorias::class, 'store']);
Route::put('/subcategorias/editar/{idSubcategoria}', [ControllerSubcategorias::class, 'update']);
Route::delete('/subcategorias/eliminar/{idSubcategoria}', [ControllerSubcategorias::class, 'destroy']);

//Planes
Route::get('/planes', [ControllerPlanes::class, 'index']);
Route::post('/planes/crear', [ControllerPlanes::class, 'store']);
Route::put('/planes/editar/{idPlan}', [ControllerPlanes::class, 'update']);
Route::delete('/planes/eliminar/{idPlan}', [ControllerPlanes::class, 'destroy']);

//Administrar Roles
Route::get('/roles', [ControllerRol::class, 'index']);
Route::post('/roles/insertar', [ControllerRol::class, 'store']);
Route::put('/roles/editar/{id}', [ControllerRol::class, 'update']);
Route::delete('/roles/eliminar/{id}', [ControllerRol::class,'destroy']);

//categorias
Route::get('/categoria', [ControllerCategorias::class, 'index']);
Route::post('/categoria/insertar', [ControllerCategorias::class, 'store']);
Route::put('/categoria/editar/{id}', [ControllerCategorias::class, 'update']);
Route::delete('/categoria/eliminar/{id}', [ControllerCategorias::class, 'destroy']);

//Reembolsos
Route::get('/reembolsos', [ControllerReembolsos::class, 'get']);
Route::post('/reembolsos/create', [ControllerReembolsos::class, 'create']);
Route::patch('/reembolsos/update/{id}', [ControllerReembolsos::class, 'update']);


//Vendedor
Route::get('/vendedor/mostrar/{id}', [ControllerVendedores::class, 'index']);
Route::get('/vendedor/editar/{id}', [ControllerVendedores::class, 'edit']);
Route::get('/vendedor/pdf/{id}', [ControllerVendedores::class, 'exportPDF']);
Route::put('/vendedor/modificar/{id}', [ControllerVendedores::class, 'update']);
Route::get('/vendedor/listar', [ControllerVendedores::class,'index']);
Route::post('/vendedor/eliminar/{id}', [ControllerVendedores::class, 'eliminarVendedor']);

 
//Usuarios
Route::get('/usuario', [ControllerUsuarios::class, 'index']);
Route::post('/usuario/insertar', [ControllerUsuarios::class, 'store']);
Route::put('/usuario/editar/{id}', [ControllerUsuarios::class, 'update']);
Route::delete('/usuario/eliminar/{id}', [ControllerUsuarios::class, 'destroy']);
Route::get('/usuario/buscarCorreo/{correo}', [ControllerUsuarios::class, 'busquedaPorCorreo']);
Route::get('/usuario/buscarNombre/{nombre}', [ControllerUsuarios::class, 'busquedaPorNombre']);
Route::get('/usuario/buscarRol/{idRol}', [ControllerUsuarios::class, 'busquedaPorRol']);
Route::get('/usuario/buscarEstado/{idEstado}', [ControllerUsuarios::class, 'busquedaPorEstado']);
Route::get('/usuario/contarUsuariosPorRol/{idRol}', [ControllerUsuarios::class, 'contarRol']);
Route::get('/usuario/totalUsuarios', [ControllerUsuarios::class, 'totalUsuarios']);
Route::get('/usuario/totalUsuariosPorEstado/{idEstado}', [ControllerUsuarios::class, 'totalUsuariosPorEstado']);
Route::post('/usuario/recuperarContrasena/{id}', [ControllerUsuarios::class, 'recuperarContrasena']);
Route::post('/usuario/cambioContrasena/{id}', [ControllerUsuarios::class, 'cambioContrasena']);


Route::post('/notificacion', [ControllerNotificaciones::class, 'val']);
