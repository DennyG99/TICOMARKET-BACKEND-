<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use App\Models\Usuario;
use App\Models\Vendedor;
use App\Models\Tienda;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ControllerVendedores extends Controller
{

    public function index()
    {
        $vendedores = Usuario::where('usuarios.idRol', '=', '4')
            ->leftJoin('estados', 'usuarios.idEstado', '=', 'estados.id')
            ->leftJoin('roles', 'roles.id', '=', 'usuarios.idRol')
            ->leftJoin('tiendas', 'tiendas.idVendedor', '=', 'usuarios.id')->where('usuarios.idRol', '=', '4')
            ->select(
                'tiendas.nombreTienda',
                'tiendas.tipoNegocio',
                'usuarios.id',
                'usuarios.nombre as nombreUsuario',
                'usuarios.apellidoUno',
                'usuarios.apellidoDos',
                'usuarios.correo',
                'usuarios.telefono',
                'estados.nombre as nombreEstado'
            )
            ->get();
        return response()->json($vendedores);
    } //End index


    public function update(Request $request, $id)
    {
        try {
            $vendedor = Usuario::find($id);
            if ($vendedor) {
                $estados = Estado::find($request->idEstado);
                if ($estados) {
                    $vendedor->idEstado = $request->idEstado;
                    $vendedor->save();
                    return response()->json(200);
                } else {
                return response()->json(['Estado erroneo'], 404);

                }
            } else {
                return response()->json(['Vendedor no encontrado'], 404);
            }
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1452) {
                return response()->json(['error' => 'Error de FK: La categoría o estado especificada no existe.'], 400);
            }
        }
    } //End update


    public function eliminarVendedor($idUsuario)
    {
        $vendedor = Usuario::where('id', $idUsuario)->first();
        $estadoInactivo = 2;
        $estadoEliminado = 4;

        if (!$vendedor) {
            return response()->json(['message' => 'Vendedor no encontrado.'], 404);
        } else {

            $tiendasActivas = $this->getTiendasActivas($idUsuario);

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
        $vendedoresCotizados = Usuario::select(
            'usuarios.id',
            'usuarios.nombre as nombreVendedor',
            DB::raw('COUNT(ventas.idVenta) as cantidadVentas')
        )
            ->join('vendedores', 'usuarios.id', '=', 'vendedores.idVendedor')
            ->leftJoin('ventas', 'usuarios.id', '=', 'ventas.idUsuario')
            ->groupBy('usuarios.id', 'usuarios.nombre')
            ->orderByDesc('cantidadVentas')
            ->get();

        return response()->json($vendedoresCotizados);
    }
}
