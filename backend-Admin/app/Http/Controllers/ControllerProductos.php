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
            'usuarios.nombre as Usuario_Dueno_Tienda'
        )
            ->join('ventas_productos', 'productos.idProducto', '=', 'ventas_productos.idProducto')
            ->join('ventas', 'ventas_productos.idVenta', '=', 'ventas.idVenta')
            ->join('tiendas', 'productos.tienda', '=', 'tiendas.idTienda')
            ->join('usuarios', 'tiendas.idTienda', '=', 'usuarios.id')
            ->join('vendedores', 'usuarios.id', '=', 'vendedores.idVendedor')
            ->where('vendedores.idEstado', 1) //DEPENDE DEL ESTADO DEL VENDEDOR
            ->groupBy('productos.idProducto')
            ->orderByDesc(DB::raw('count(ventas_productos.idProducto)'))
            ->limit(10) //LIMITANDO A 10 RESULTADOS
            ->get();
    
            return response()->json($productosMasVendidos);
        }    
}
