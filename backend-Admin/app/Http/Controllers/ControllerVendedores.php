<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Vendedor;
use App\Models\Tienda;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ControllerVendedores extends Controller
{

    public function index($id)
    {


        $vendedores = Usuario::join('estados', 'usuarios.idEstado', '=', 'estados.id')
            ->join('vendedores', 'vendedores.idVendedor', '=', 'usuarios.id')
            ->join('tiendas', 'tiendas.idVendedor', '=', 'vendedores.idVendedor')
            ->select('estados.*', 'vendedores.*', 'tiendas.*', 'usuarios.*')
            ->where('usuarios.id', '=', $id)
            ->get();
        return response()->json($vendedores, 200);
    } //End index

    public function edit($id)
    {
        $data = Usuario::findOrfail($id);
        return response()->json($data);
    } //End edit

    public function update(Request $request, $id)
    {
        try {
            $dataVendedores = Usuario::find($id);
            $dataVendedores->nombre = $request->nombre;
            $dataVendedores->apellidoUno = $request->apellidoUno;
            $dataVendedores->apellidoDos = $request->apellidoDos;
            $dataVendedores->correo = $request->correo;
            $dataVendedores->contrasena = Hash::make($request->contrasena);
            $dataVendedores->idRol = $request->idRol;
            $dataVendedores->idEstado = $request->idEstado;
            $dataVendedores->telefono = $request->telefono;
            $dataVendedores->save();
            return response()->json($dataVendedores, 200);
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1452) {
                return response()->json(['error' => 'Error de FK: La categoría o estado especificada no existe.'], 400);
            }
        }
    } //End update

    public function exportPDF($id)
    {

        // $usr = Usuario::findOrFail($id);
        $pdf = Usuario::join('estados', 'usuarios.idEstado', '=', 'estados.id')
            ->join('vendedores', 'vendedores.idVendedor', '=', 'usuarios.id')
            ->join('tiendas', 'tiendas.idVendedor', '=', 'vendedores.idVendedor')
            ->select('estados.*', 'vendedores.*', 'tiendas.*', 'usuarios.*')
            ->where('usuarios.id', '=', $id)
            ->get();
        return response()->json($pdf);
    } //End exportPDF

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
