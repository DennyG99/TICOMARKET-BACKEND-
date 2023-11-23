<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estado;

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
        if (!$id) {
            return response()->json(['message' => 'ID no proporcionado'], 400);
        }
        $estado = Estado::find($id);

        if (!$estado) {
            return response()->json(['message' => 'Estado no encontrado'], 404);
        }

        $estado->delete();
        return response()->json(['message' => 'Estado eliminado']);
    }
    
}
