<?php

namespace App\Http\Controllers;
use App\Models\Politicas;
use App\Controller\ControllerNotificaciones;
use Illuminate\Support\Facades\Mail;
use App\Mail\ControllerMail;
use Illuminate\Http\Request;
use App\Models\Usuario;

class ControllerPoliticas extends Controller
{
    public function contenidoNombre(){
        return request('descripcion');
        }
    public function contenidoDescripcion(){
        return request('nombre');
        }
        
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
    
        $asunto = "Cambio Politicas";
        $usuarios = Usuario::all();
       
        foreach ($usuarios as $usuario) {
            Mail::to($usuario->correo)->send(new ControllerMail($asunto, 'Mail.cambioPolitica',0));
        }
    $politicas->save();
        return response()->json($politicas,200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function editar(Request $request, string $idPolitica)
    {
        $politicas = Politicas::find($idPolitica);
        $politicas->nombre = $request->input('nombre');
        $politicas->descripcion = $request->input('descripcion');
        $politicas->idEstado = $request->input('idEstado');
        $politicas->save();

    }
    /**
     * Remove the specified resource from storage.
     */
    public function eliminar(string $idPolitica)
    {
        $politicas = Politicas::find($idPolitica);
        $politicas->delete();
        return response()->json($politicas,200);
        
    }
}
