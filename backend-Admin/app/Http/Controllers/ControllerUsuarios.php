<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;


class ControllerUsuarios extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $usuario = new Usuario();
        $usuario->nombre = $input['nombre'];
        $usuario->apellidoUno = $input['apellidoUno'];
        $usuario->apellidoDos = $input['apellidoDos'];
        $usuario->correo = $input['correo'];
        $usuario->contrasena = $input['contrasena'];
        $usuario->idRol = $input['idRol'];
        $usuario->idEstado = $input['idEstado'];
        $usuario->fechaAcceso = $input['fechaAcceso'];
        $usuario->tiempoInactividad = $input['tiempoInactividad'];
        $usuario->fotoCedula = $input['fotoCedula'];
        $usuario->telefono = $input['telefono'];

        $usuario->save();

        return response()->json($usuario,200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $usuario = Usuario::find($id);
        $input = $request->all();

        $usuario->nombre = $input['nombre'];
        $usuario->apellidoUno = $input['apellidoUno'];
        $usuario->apellidoDos = $input['apellidoDos'];
        $usuario->correo = $input['correo'];
        $usuario->contrasena = $input['contrasena'];
        $usuario->idRol = $input['idRol'];
        $usuario->idEstado = $input['idEstado'];
        $usuario->fechaAcceso = $input['fechaAcceso'];
        $usuario->tiempoInactividad = $input['tiempoInactividad'];
        $usuario->fotoCedula = $input['fotoCedula'];
        $usuario->telefono = $input['telefono'];

        $usuario->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Usuario::find($id);
        $item->delete();
        return response()->json(["message"=>"Registro no encontrado"], 200);
    }

    public function getUsuario(){
        return response()->json(Usuario::all(),200);
    }
    
    //FUNCIÓN PARA OBTENER EL ESTADO DE LOS USUARIOS ->SOLO ACCEDE ADMIN
    public function estadoUsuarios()
    {
        $estadoUsuarios = Usuario::join('estados', 'usuarios.idEstado', '=', 'estados.id')
            ->select('usuarios.nombre as Nombre_Usuario', 'estados.nombre as Estado')
            ->get();

        return response()->json($estadoUsuarios);
    }
}
