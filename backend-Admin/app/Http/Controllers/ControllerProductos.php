<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Support\Facades\DB;

class ControllerProductos extends Controller
{
    public function productosMasVendidos()
    {
        //CONSULTA PARA OBTENER AQUELLOS PRODUCTOS MÁS VENDIDOS
        //ANOTACIÓN--- EL BD:raw() PERMITE AÑADIR FUNCIONES AL SQL QUE ELOQUENT NO PROCESA, TAL Y COMO EL COMO EL Count().
        $productosMasVendidos = Producto::select(
            'productos.nombre as Nombre_Producto',
            'productos.precio as Precio',
            'productos.descripcion as Descripcion',
            'usuarios.nombre as Usuario_Dueno_Tienda',
            DB::raw('count(ventas_productos.idProducto) as Cantidad_Vendida')
        )
            ->join('ventas_productos', 'productos.idProducto', '=', 'ventas_productos.idProducto')
            ->join('ventas', 'ventas_productos.idVenta', '=', 'ventas.idVenta')
            ->join('tiendas', 'productos.tienda', '=', 'tiendas.idTienda')
            ->join('usuarios', 'tiendas.idTienda', '=', 'usuarios.id')
            ->join('usuarios_plan', 'usuarios.id', '=', 'usuarios_plan.idUsuario')
            ->where('usuarios.idRol', 2) //SUPONIENDO QUE EL ROL DE VENDEDOR ES 2
            ->groupBy('productos.idProducto')
            ->orderByDesc(DB::raw('count(ventas_productos.idProducto)'))
            ->get();

            return response()->json($productosMasVendidos);
    }
}
