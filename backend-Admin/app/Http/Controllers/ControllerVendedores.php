<?php
namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Support\Facades\DB;


class ControllerVendedores extends Controller {

    public function mostrarVendedoresCotizados() 
    {
        $vendedoresCotizados = Venta::select('usuarios.nombre AS Nombre_Vendedor', 'tiendas.nombreTienda AS Nombre_Tienda')
            ->join('usuarios', 'ventas.idUsuario', '=', 'usuarios.id')
            ->join('tiendas', 'ventas.cedulaJuridica', '=', 'tiendas.cedulaJuridicaTienda')
            ->join('ventas_productos', 'ventas.idVenta', '=', 'ventas_productos.idVenta')
            ->join('productos', 'ventas_productos.idProducto', '=', 'productos.idProducto')
            ->groupBy('usuarios.nombre', 'tiendas.nombreTienda')
            ->orderByDesc(DB::raw('SUM(productos.precio)'))
            ->get();

            return response()->json($vendedoresCotizados);
    }
}
