<?php

namespace App\Http\Controllers;

use App\Models\Tienda;
use App\Models\Usuario;
use App\Models\Vendedor;
use App\Models\Venta;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ControllerVendedores extends Controller
{
    public function index(Request $request)
    {
        // Obtener la cantidad de registros por página desde la consulta o establecer un valor predeterminado
        $perPage = $request->input('per_page', 10);
        // Obtener la página actual desde la consulta o establecer un valor predeterminado
        $currentPage = $request->input('page', 1);
        // Realizar la consulta paginada
        $rolVendedor = 4;
        $vendedores = Usuario::where('idRol', $rolVendedor)->paginate($perPage, ['*'], 'page', $currentPage);
        return response()->json($vendedores, 200);
    }//End index

    public function edit($id)
    {
        $data = Usuario::findOrfail($id);
        return response()->json($data);
    }//End edit

    public function update(Request $request, $id)
    {
        //mochis guapo
        $dataVendedores = Usuario::find($id);
        $dataVendedores->nombre = $request->nombre;
        $dataVendedores->apellidoUno = $request->apellidoUno;
        $dataVendedores->apellidoDos = $request->apellidoDos;
        $dataVendedores->correo = $request->correo;
        $dataVendedores->contrasena = $request->contrasena;
        $dataVendedores->idRol = $request->idRol;
        $dataVendedores->idEstado = $request->idEstado;
        $dataVendedores->telefono = $request->telefono;
        $dataVendedores->save();
        return response()->json($dataVendedores, 200);
    }//End update

    public function exportPDF(Request $request)
    {
        $id = $request;
        // $usr = Usuario::findOrFail($id);
        $pdf = Usuario::join('estados', 'usuarios.idEstado', '=', 'estados.id')
            ->join('vendedores', 'vendedores.idVendedor', '=', 'usuarios.id')
            ->join('tiendas', 'tiendas.idVendedor', '=', 'vendedores.idVendedor')
            ->select('estados.*', 'vendedores.*', 'tiendas.*', 'usuarios.*')
            ->get();
        return response()->json($pdf);
    }//End exportPDF

    public function eliminarVendedor($idUsuario)
    {
        $vendedor = Vendedor::where('idVendedor', $idUsuario)->first();
        $estadoInactivo = 2;
        $estadoEliminado = 4;

        if (!$vendedor) {
            return response()->json(['message' => 'Vendedor no encontrado.'], 404);
        } else {
            
            $tiendasActivas = $this->getTiendasActivas($vendedor->idVendedor);

            if (count($tiendasActivas) == 0) {
                $vendedor->idEstado = $estadoEliminado;
                $vendedor->save();
                return response()->json(['message' => 'Se ha cambiado el estado a Eliminado.'], 200);
            } else {
                $vendedor->idEstado = $estadoInactivo;
                $vendedor->save();
                return response()->json(['message' => 'Se ha cambiado el estado a Inactivo.'], 200);
            }
        }
    }

    public function getTiendasActivas($idUsuario)
    {
        $estadoActivo = 1;
        $tiendas = Tienda::where("idVendedor", $idUsuario)->where("idEstado", $estadoActivo)->get();
        return $tiendas;
    }
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
