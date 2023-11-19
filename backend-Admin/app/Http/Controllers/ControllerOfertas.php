<?php

namespace App\Http\Controllers;

use App\Models\VentaProducto;


class ControllerOfertas extends Controller
{
	//CONSULTA DE INGRESOS POR ANUNCIOS EN LA PLATAFORMA
    public function ingresosPorAnuncios()
    {
        $resultados = VentaProducto::join('ofertas', 'ventas_productos.idProducto', '=', 'ofertas.idProducto')
            ->join('productos', 'ventas_productos.idProducto', '=', 'productos.idProducto')
            ->whereNotNull('ofertas.idOferta')
            ->selectRaw('COUNT(ventas_productos.idProducto) AS Cantidad_Productos_Vendidos, SUM(productos.precio) AS Ingresos_Por_Anuncios')
            ->first();

        return response()->json($resultados);
    }
}
