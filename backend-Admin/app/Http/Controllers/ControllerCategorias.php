<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class ControllerCategorias extends Controller
{
   
/*El sistema permitirá visualizar una lista de las categorías existentes, donde mostrará los campos id y su nombre y estado.*/ 
    public function index()
    {
        return response()->json(Categoria::all(),200);
    }



     /*El sistema debe permitirle al super administrador registrar una nueva categoría con los siguientes datos: 
     id nombre estado descripción */ 
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'idEstado' => 'required',
            'descripcion' => 'required'
        ]);

        $input = $request->all();

        $categoria = new Categoria();
        $categoria->nombre = $input['nombre']; 
        $categoria->idEstado = $input['idEstado']; 
        $categoria->descripcion = $input['descripcion'];
      
        $categoria->save();

        return response()->json($categoria,200);
    }

   


     /*El sistema deberá ofrecer la funcionalidad de editar una categoría identificada mediante su ID.*/
    public function update(Request $request, string $id)
    {

        $request->validate([
            'nombre' => 'required',
            'idEstado' => 'required',
            'descripcion' => 'required'
        ]);
        
        $categoria = Categoria::find($id);

        $input = $request->all();

        $categoria->nombre = $input['nombre']; 
        $categoria->idEstado = $input['idEstado']; 
        $categoria->descripcion = $input['descripcion'];
      
        $categoria->save();

        return response()->json($categoria,200);
    }

    

     /*Permitir eliminar una categoría a través de su identificador único (ID). 
     Sin embargo, esta operación debe estar condicionada por la ausencia de productos asociados a dicha categoría. 
     En caso de que existan productos relacionados con la categoría que se intenta eliminar, 
     la categoría no debe ser eliminada directamente, en su lugar, se debe cambiar su estado a "inactivo" 
     para mantener un registro de la categoría. */
    public function destroy(string $id)
    {
        try {
            $categoria = Categoria::find($id);
    
            if (!$categoria) {
                return response()->json(["message" => "Categoría no encontrada"], 404);
            }
    
            if ($categoria->productos->count() > 0) {
                $categoria->idEstado = 2;
                $categoria->save();
                return response()->json(["message" => "No se puede eliminar la categoría porque tiene productos asociados, se cambió el estado a inactivo"], 422);
             
            }
    
            $categoria->delete();
    
            return response()->json(["message" => "Categoría eliminada correctamente"], 200);
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }


    /*Este metodo no está en los requerimientos, pero si intento eliminar una categoria y existen productos asociados
    esta cambiara de estado a inactivo, ¿que pasa si luego lo quiero activar? para eso es este metodo*/ 
    public function reactivarEstado(String $id){
        $categoria = Categoria::find($id);
        $categoria->idEstado = 1;
        $categoria->save();
        return response()->json(["message" => "Se ha cambiado el estado de la categoria"], 200);
             
    }

   
}