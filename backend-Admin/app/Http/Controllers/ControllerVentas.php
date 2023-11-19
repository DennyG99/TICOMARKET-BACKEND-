<?php

namespace App\Http\Controllers;

use App\Models\Tienda;
use Illuminate\Support\Facades\DB;


class ControllerVentas extends Controller
{
	//FUNCIÓN DE VENTAS PRODUCIDAS POR CADA TIENDA ACCEDE ÚNICAMENTE -> ADMIN
	public function ventasPorTienda()
	{
		$ventasPorTienda = Tienda::select(
			'tiendas.nombreTienda as Nombre_Tienda',
			'usuarios.nombre as Vendedor_Responsable',
			DB::raw('COUNT(ventas_productos.idProducto) as Cantidad_Ventas')
		)
		->join('ventas', 'tiendas.cedulaJuridicaTienda', '=', 'ventas.cedulaJuridica')
		->join('usuarios', 'ventas.idUsuario', '=', 'usuarios.id')
		->join('ventas_productos', 'ventas.idVenta', '=', 'ventas_productos.idVenta')
		->groupBy('tiendas.nombreTienda', 'usuarios.nombre')
		->get();
		
		return response()->json($ventasPorTienda);
	}
	
}