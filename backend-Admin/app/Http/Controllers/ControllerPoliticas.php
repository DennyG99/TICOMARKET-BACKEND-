<?php

namespace App\Http\Controllers;
use App\Models\Politicas;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class ControllerPoliticas extends Controller
{
    
    public function MostrarPoliticas(){
        $politicas = Politicas::all();
        return response()->json($politicas,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function crear(Request $request) 
    {
        try {
            $politicas = new Politicas();
            $politicas->nombre = $request->input('nombre');
            $politicas->descripcion = $request->input('descripcion');
            $politicas->idEstado = $request->input('idEstado');
            $politicas->save();
    
            return response()->json($politicas,200);
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1452) {
                return response()->json(['error' => 'Error de FK: El estado especificada no existe.'], 400);
        }
    }
}


    /**
     * Update the specified resource in storage.
     */
    public function editar(Request $request, string $idPolitica)
    {
        try {
            $politicas = Politicas::find($idPolitica);
            if (!$politicas) {
                return response()->json(['message' => 'Politica no encontrada'], 404);
            }else{
                
                $politicas->nombre = $request->input('nombre');
                $politicas->descripcion = $request->input('descripcion');
                $politicas->idEstado = $request->input('idEstado');
                $politicas->save();
        
            }
        }catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1452) {
                return response()->json(['error' => 'Error de FK: El estado especificada no existe.'], 400);
        }
       
    }
}
    /**
     * Remove the specified resource from storage.
     */
    public function eliminar(string $idPolitica)
    {
        $politicas = Politicas::find($idPolitica);
        $politicas->delete();
        return response()->json(200);
        
    }
}