<?php

namespace App\Http\Controllers;
use App\Models\Politicas;
use Illuminate\Http\Request;

class PoliticasController extends Controller
{
    
    public function MostrarPoliticas(){
        $politicas = Politicas::orderBy('idPolitica', 'asc')->paginate(3);
        return $politicas->items(); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function crear(Request $request) 
    {
        
        $politicas = new Politicas();
        $politicas->idPolitica = $request->input('idPolitica');
        $politicas->nombre = $request->input('nombre');
        $politicas->descripcion = $request->input('descripcion');
        $politicas->idEstado = $request->input('idEstado');
        $politicas->save();

        return response()->json($politicas,200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
