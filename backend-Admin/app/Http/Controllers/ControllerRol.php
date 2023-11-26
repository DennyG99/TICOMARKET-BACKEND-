<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Models\Usuario;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ControllerRol extends Controller
{
    // Recupera y devuelve todos los roles junto con su estado asociado.
    // Recupera y devuelve todos los roles junto con su estado asociado.
    public function index()
    {
        try {
            // Obtiene todos los roles y carga su estado relacionado de la base de datos.
            $roles = Rol::with('estado')->get();
            // Devuelve los roles en formato JSON.
            return response()->json($roles);
        } catch (Exception $e) {
            // En caso de cualquier excepción, devuelve un error 500 con el mensaje de la excepción.
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    // Crea un nuevo rol y lo guarda en la base de datos.
    // Crea un nuevo rol y lo guarda en la base de datos.
    public function store(Request $request)
    {
        try {
            // Valida los datos de la solicitud y asegura que los campos requeridos estén presentes.
            $validatedData = $request->validate([
                'nombre' => 'required|max:255',
                'descripcion' => 'required',
                'idEstado' => 'required|exists:estados,id',
            ]);

            // Crea una nueva instancia de Rol y asigna los valores.
            $role = new Rol();
            $role->nombre = $validatedData['nombre'];
            $role->descripcion = $validatedData['descripcion'];
            $role->idEstado = $validatedData['idEstado'];
            // Guarda el rol en la base de datos.
            $role->save();

            // Devuelve los datos del rol creado con un código de estado HTTP 201.
            return response()->json($role, 201);
        } catch (Exception $e) {
            // Captura cualquier excepción y devuelve un mensaje de error.
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    // Muestra un rol específico por su ID, incluyendo su estado asociado.
    // Muestra un rol específico por su ID, incluyendo su estado asociado.
    public function show($id)
    {
        try {
            // Busca el rol por su ID y carga su estado relacionado. Si no lo encuentra, lanza una excepción.
            $role = Rol::with('estado')->findOrFail($id);
            // Devuelve los datos del rol en formato JSON.
            return response()->json($role);
        } catch (ModelNotFoundException $e) {
            // Si el rol no se encuentra, devuelve un error 404 con un mensaje.
            return response()->json(['message' => 'Rol no encontrado'], 404);
        } catch (Exception $e) {
            // Captura cualquier otra excepción y devuelve un mensaje de error.
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    // Actualiza un rol existente basado en el ID proporcionado.
    // Actualiza un rol existente basado en el ID proporcionado.
    public function update(Request $request, $id)
    {
        try {
            // Busca el rol por su ID. Si no lo encuentra, lanza una excepción.
            $role = Rol::findOrFail($id);
            // Obtiene todos los datos de la solicitud HTTP.
            $input = $request->all();
            // Actualiza el rol con los nuevos datos y lo guarda.
            $role->fill($input)->save();
            // Devuelve los datos del rol actualizado en formato JSON.
            return response()->json($role);
        } catch (ModelNotFoundException $e) {
            // Si el rol no se encuentra, devuelve un error 404 con un mensaje.
            return response()->json(['message' => 'Rol not found'], 404);
        } catch (Exception $e) {
            // Captura cualquier otra excepción y devuelve un mensaje de error.
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



    // Elimina un rol basado en el ID proporcionado.
    // Elimina un rol basado en el ID proporcionado.
    public function destroy($id)
    {
        try {
            // Busca el rol por su ID. Si no lo encuentra, lanza una excepción.
            $role = Rol::findOrFail($id);
            // Elimina el rol de la base de datos.
            $usuario = Usuario::where('idRol', $id)->first();
            if ($usuario) {
                $role->idEstado = 2;
                $role->save();
                return response()->json(['message'=> 'El rol tiene usuarios, se desactivo'], 200);
            }
            else {
                $role->delete();
                // Devuelve un mensaje de confirmación.
                return response()->json(["message" => "Rol eliminado"], 200);
            }

            
        } catch (ModelNotFoundException $e) {
            // Si el rol no se encuentra, devuelve un error 404 con un mensaje.
            return response()->json(['message' => 'Rol no encontrado'], 404);
        } catch (Exception $e) {
            // Captura cualquier otra excepción y devuelve un mensaje de error.
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}