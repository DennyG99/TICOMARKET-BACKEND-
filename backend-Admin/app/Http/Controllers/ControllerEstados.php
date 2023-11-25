<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estado;
use App\Models\Categoria;
use App\Models\Reembolsos;
use App\Models\Tienda;
use App\Models\Rol;
use App\Models\Planes;
use App\Models\Politicas;
use App\Models\Subcategorias;
use App\Models\estados;
use App\Models\Producto;
use App\Models\Usuario;
use App\Models\Vendedor;


class ControllerEstados extends Controller
{
    //GET
    public function index(Request $request)
    {
        // Obtener la cantidad de registros por página desde la consulta o establecer un valor predeterminado
        $perPage = $request->input('per_page', 10);
    
        // Obtener la página actual desde la consulta o establecer un valor predeterminado
        $currentPage = $request->input('page', 1);
    
        // Realizar la consulta paginada
        $estados = Estado::paginate($perPage, ['*'], 'page', $currentPage);
    
        return response()->json($estados);
    }
    //PUT
    public function store(Request $request){
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'status' => 'required'
        ]);
    
        $state = Estado::create($request->all());
        return response()->json($state, 201);
    }
    //update
    public function update(Request $request){
        $id = $request->query('id');
        if (!$id) {
            return response()->json(['message' => 'ID no proporcionado'], 400);
        }

        $state = Estado::find($id);
        if(!$state){
            return response()->json(['message' => 'Nota no encontrada'], 404);
        }
    
        $state->update($request->all());
        return response()->json($state);
    }
    //DELETE
    
    public function destroy(Request $request)
    {
        $id = $request->query('id');
        //se le asigna la sub donde idestado = $id y idEstado = 1
        $estado = Estado::where('id', $id)->first();

        if (!$estado) {
            return response()->json(['message' => 'Estado no encontrado'], 404);
        } else {
            $tienda = Tienda::where('idEstado', $id)->first();
            if ($tienda) {
                return response()->json(['message' => 'El Estado está ligado a una tienda'], 200);
            }
            $categoria = Categoria::where('idEstado', $id)->first();
            if ($categoria) {
                return response()->json(['message' => 'El Estado está ligado a una categoria'], 200);
            }
            $vendedor = Vendedor::where('idEstado', $id)->first();
            if ($vendedor) {
                return response()->json(['message' => 'El Estado está ligado a una categoria'], 200);
            }
            $reembolso = Reembolsos::where('idEstado', $id)->first();
            if ($reembolso){
                return response()->json(['message' => 'El Estado está ligado a un reembolso'], 200);
            }
            $rol = Rol::where('idEstado', $id)->first();
            if ($rol){
                return response()->json(['message' => 'El Estado está ligado a un Rol'], 200);
            }
            $plan = Planes::where('idEstado', $id)->first();
            if ($plan){
                return response()->json(['message' => 'El Estado está ligado a un plan'], 200);
            }
            $politica = Politicas::where('idEstado', $id)->first();
            if ($politica){
                return response()->json(['message' => 'El Estado está ligado a una politica'], 200);
            }
            $subcategoria = Subcategorias::where('idEstado', $id)->first();
            if ($subcategoria){
                return response()->json(['message' => 'El Estado está ligado a una subcategoria'], 200);
            }
            $producto = Producto::where('estado', $id)->first();
            if ($producto){
                return response()->json(['message' => 'El Estado está ligado a un producto'], 200);
            }
            $usuario = Usuario::where('idEstado', $id)->first();
            if ($usuario){
                return response()->json(['message' => 'El Estado está ligado a un usuario'], 200);
            }
            else {
                $estado->delete();
                return response()->json(['message' => 'estado Eliminada'], 200);
            }
        }
}
}
