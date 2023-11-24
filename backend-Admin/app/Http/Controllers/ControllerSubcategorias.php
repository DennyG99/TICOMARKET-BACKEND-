<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Subcategorias;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class ControllerSubcategorias extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $subcategorias = Subcategorias::all();
        return response()->json($subcategorias);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required',
                'idEstado' => 'required',
                'descripcion' => 'required',
                'idCategoria' => 'required'
            ]);
            $subcategoria = Subcategorias::create($request->all());

            return response()->json(201);
        } catch (QueryException $e) {

            $errorCode = $e->errorInfo[1];

            if ($errorCode == 1452) {
                return response()->json(['error' => 'Error de FK: La categoría o estado especificada no existe.'], 400);
            }
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $subcategoria = Subcategorias::find($id);
            if (!$subcategoria) {
                return response()->json(['message' => 'Subcategoria no encontrada'], 404);
            } else {
                $request->validate([
                    'nombre' => 'required',
                    'idEstado' => 'required',
                    'descripcion' => 'required',
                    'idCategoria' => 'required'
                ]);
                $subcategoria->update($request->all());
                return response()->json(200);
            }
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1452) {
                return response()->json(['error' => 'Error de FK: La categoría o estado especificada no existe.'], 400);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $subcategoria =Subcategorias::where('idSubcategoria', $id)->where('idEstado', 1)->first();

        if (!$subcategoria) {
            return response()->json(['message' => 'Subcategoria no encontrada o esta inactiva'], 404);
        } else {
            $producto = Producto::where('subcategoria', $id)->first();
            if ($producto) {
                $subcategoria->idEstado=2;
                $subcategoria->save();
                return response()->json(['message' => 'Subcategoria tiene productos, se inactivo'], 200);
            } else {
                $subcategoria->delete();
                return response()->json(['message' => 'Subcategoria Eliminada'], 200);
            }
        }
    }
}
