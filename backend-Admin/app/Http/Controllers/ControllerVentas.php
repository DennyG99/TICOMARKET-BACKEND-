<?php

namespace App\Http\Controllers;

use App\Models\Usuario;

use Illuminate\Support\Facades\DB;


class ControllerVentas extends Controller
{
	//FUNCIÓN DE VENTAS PRODUCIDAS POR CADA TIENDA ACCEDE ÚNICAMENTE -> ADMIN
	public function ventasPorTienda()
	{
		$ventasPorTienda = Usuario::select(
			'tiendas.nombreTienda',
			'usuarios.nombre as vendedorResponsable',
			DB::raw('COUNT(ventas.idProducto) as cantidadVentas')
		)
			->join('vendedores', 'usuarios.id', '=', 'vendedores.idVendedor')
			->join('tiendas', 'vendedores.idVendedor', '=', 'tiendas.idVendedor')
			->leftJoin('ventas', 'usuarios.id', '=', 'ventas.idUsuario')//VERIFICA QUE HAYA USUARIOS CON VENTAS ASIGNADAS Y UNE LAS TABLAS
			->leftJoin('ventas_productos', 'ventas.idVenta', '=', 'ventas_productos.idVenta')
			->groupBy('usuarios.id', 'tiendas.idTienda')
			->orderByDesc('cantidadVentas')
			->get();

		return response()->json($ventasPorTienda);
	}
	
}