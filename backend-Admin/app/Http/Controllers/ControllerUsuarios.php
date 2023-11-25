<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\ControllerMail;
use Illuminate\Database\QueryException;

class ControllerUsuarios extends Controller
{
    /*Mostrar todos los usuarios registrados*/
    public function index()
    {
        return response()->json(Usuario::all(), 200);
    }



    /*registrar usuarios */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required',
                'apellidoUno' => 'required',
                'apellidoDos' => 'required',
                'correo' => 'required',
                'contrasena' => 'required',
                'idRol' => 'required',
                'idEstado' => 'required',
                'fechaAcceso' => 'required',
                'tiempoInactividad' => 'required',
                'telefono' => 'required'
            ]);

            $input = $request->all();

            $usuario = new Usuario();
            $usuario->nombre = $input['nombre'];
            $usuario->apellidoUno = $input['apellidoUno'];
            $usuario->apellidoDos = $input['apellidoDos'];
            $usuario->correo = $input['correo'];
            $usuario->contrasena = Hash::make($input['contrasena']);
            $usuario->idRol = $input['idRol'];
            $usuario->idEstado = $input['idEstado'];
            $usuario->fechaAcceso = $input['fechaAcceso'];
            $usuario->tiempoInactividad = $input['tiempoInactividad'];
            //  $usuario->fotoCedula = $input['fotoCedula'];
            $usuario->telefono = $input['telefono'];

            $usuario->save();

            return response()->json($usuario);
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1452) {
                return response()->json(['error' => 'Error de FK: el estado especificado o rol no existe.'], 400);
            } else {
                return response()->json(['error' => 'Error de base de datos.'], 500);
            }
        }
    }



    /*realizar la edición de los usuarios mediante su id*/
    public function update(Request $request, string $id)
    {

        try {

            $request->validate([
                'nombre' => 'required',
                'apellidoUno' => 'required',
                'apellidoDos' => 'required',
                'correo' => 'required',
                'idRol' => 'required',
                'idEstado' => 'required',
                'telefono' => 'required'

            ]);

            $usuario = Usuario::find($id);
            $input = $request->all();

            $usuario->nombre = $input['nombre'];
            $usuario->apellidoUno = $input['apellidoUno'];
            $usuario->apellidoDos = $input['apellidoDos'];
            $usuario->correo = $input['correo'];
            $usuario->idRol = $input['idRol'];
            $usuario->idEstado = $input['idEstado'];
            // $usuario->fechaAcceso = $input['fechaAcceso'];
            // $usuario->tiempoInactividad = $input['tiempoInactividad'];
            //  $usuario->fotoCedula = $input['fotoCedula'];
            $usuario->telefono = $input['telefono'];

            $usuario->save();
            return response()->json($usuario, 200);
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1452) {
                return response()->json(['error' => 'Error de FK: el estado especificado o rol no existe.'], 400);
            }
        }
    }

    /*Eliminar Usuarios*/
    public function destroy(string $id)
    {
        try {
            $item = Usuario::find($id);
            $item->delete();
            return response()->json(["message" => "Usuario eliminado correctamente"], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
    }


    /*Se requiere que los usuarios Super Admin y Administrador realizar búsquedas de usuarios 
    por medio de los siguientes datos: Correo */
    public function busquedaPorCorreo($correo)
    {

        try {
            $usuario = Usuario::where('correo', $correo)->get();

            if ($usuario) {
                $datosUsuario = $usuario->makeHidden(['correo']);

                return response()->json($datosUsuario, 200);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
    }

    /*Se requiere que los usuarios Super Admin y Administrador realizar búsquedas de usuarios 
    por medio de los siguientes datos: Nombre */
    public function busquedaPorNombre($nombre)
    {
        try {
            $usuario = Usuario::where('nombre', $nombre)->get();

            if ($usuario) {
                $datosUsuario = $usuario->makeHidden(['nombre']);

                return response()->json($datosUsuario, 200);
            } else {
                return response()->json(['message' => 'Usuario no encontrado'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al procesar la solicitud'], 500);
        }
    }

    /*Se requiere que los usuarios Super Admin y Administrador realizar búsquedas de usuarios 
    por medio de los siguientes datos: Rol */
    public function busquedaPorRol($idRol)
    {
        try {
            $usuario = Usuario::where('idRol', $idRol)->get();

            if ($usuario) {
                $datosUsuario = $usuario->makeHidden(['idRol']);

                return response()->json($datosUsuario, 200);
            } else {
                return response()->json(['message' => 'Usuario no encontrado'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al procesar la solicitud'], 500);
        }
    }

    /*Se requiere que los usuarios Super Admin y Administrador realizar búsquedas de usuarios 
    por medio de los siguientes datos: Estado */
    public function busquedaPorEstado($idEstado)
    {
        try {
            $usuario = Usuario::where('idEstado', $idEstado)->get();

            if ($usuario) {
                $datosUsuario = $usuario->makeHidden(['idEstado']);

                return response()->json($datosUsuario, 200);
            } else {
                return response()->json(['message' => 'Usuario no encontrado'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al procesar la solicitud'], 500);
        }
    }
    /*Se requiere que los usuarios Super Admin y Administrador puedan realizar búsquedas para mostrar 
el total vendedores que usan la Marketplace.*/
    public function contarRol($idRol)
    {
        try {
            $totalUsuarios = Usuario::where('idRol', $idRol)->count();

            return response()->json(['total_usuarios' => $totalUsuarios], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al procesar la solicitud'], 500);
        }
    }

    /*Se requiere que los usuarios Super Admin y Administrador puedan realizar búsquedas que muestran el 
    total de usuarios en general (Usuarios independientemente de su rol).*/
    public function totalUsuarios()
    {
        try {
            $totalUsuarios = Usuario::count();

            return response()->json(['total_usuarios' => $totalUsuarios], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al procesar la solicitud'], 500);
        }
    }

    /*Se requiere que los usuarios Super Admin y Administrador puedan realizar búsquedas 
    que muestran el total de usuarios suspendidos y en línea.*/
    public function totalUsuariosPorEstado($idEstado)
    {
        try {
            $totalUsuarios = Usuario::where('idEstado', $idEstado)->count();

            return response()->json(['total_usuarios' => $totalUsuarios], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al procesar la solicitud'], 500);
        }
    }
    /* Se requiere que en el sistema haya un apartado para poder   	
     Realizar la recuperación de contraseña por medio del correo que el   
     usuario tenga registrado.*/
    public function recuperarContrasena(Request $request, string $id)
    {
        $usuario = Usuario::find($id);
        $asunto = "Recuperación de Contraseña";


        if ($usuario) {
            $nuevaContrasena = Str::random(8);

            $contenido = "Tu nueva contraseña es: " . $nuevaContrasena;

            $usuario->contrasena = Hash::make($nuevaContrasena);
            //    $usuario->contrasena = ($nuevaContrasena);
            $usuario->idEstado = 9;
            $usuario->save();

            Mail::to($usuario->correo)->send(new ControllerMail($asunto, 'Mail.recuperacion', 0, $nuevaContrasena));


            return response()->json(['message' => 'Contraseña recuperada y enviada al correo'], 200);
        } else {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
    }


    /*Se requiere que en el sistema haya un apartado para poder   realizar el cambio de contraseña*/
    public function cambioContrasena(Request $request, string $id)
    {
        $usuario = Usuario::find($id);
        $input = $request->all();

        if (Hash::check($input['contrasenaActual'], $usuario->contrasena) && !Hash::check($input['contrasenaNueva'], $usuario->contrasena)) {
            $usuario->contrasena = Hash::make($input['contrasenaNueva']);
            $usuario->idEstado = 1;
            $usuario->save();

            return response()->json(['message' => 'Contraseña cambiada con éxito'], 200);
        } else {
            return response()->json(['message' => 'La contraseña no puede ser igual a la anterior'], 422);
        }
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
