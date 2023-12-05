<?php

namespace App\Http\Controllers;

use App\Models\Planes;
use App\Models\UsuarioPlan;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ControllerPlanes extends Controller
{
    public function index(Request $request)
    {
        $planes = Planes::with('estado')->get();

        $planes = $planes->toArray();

        foreach ($planes as &$plan) {
            $plan['estado'] = $plan['estado']['nombre'];
        }

        return response()->json($planes);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required',
                'descripcion' => 'required',
                'tipoPlan' => 'required',
                'precio' => 'required',
                'idEstado' => 'required'
            ]);

            $plane = Planes::create($request->all());

            return response()->json(201);
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
    public function update(Request $request, $id)
    {
        try {
            $plan = Planes::find($id);
            if (!$plan) {
                return response()->json(['message' => 'Plan no encontrada'], 404);
            } else {
                $request->validate([
                    'nombre' => 'required',
                    'descripcion' => 'required',
                    'tipoPlan' => 'required',
                    'precio' => 'required',
                    'idEstado' => 'required'
                ]);
                $plan->update($request->all());
                return response()->json(200);
            }
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1452) {
                return response()->json(['error' => 'Error de FK: El estado especificada no existe.'], 400);
            }
        }
    }

/**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $plan =Planes::where('idPlan', $id)->where('idEstado', 1)->first();

        if (!$plan) {
            return response()->json(['message' => 'Plan no encontrada o esta inactiva'], 404);
        } else {
            $usuariosP = UsuarioPlan::where('idPlan', $id)->first();
            if ($usuariosP) {
                $plan->idEstado=2;
                $plan->save();
                return response()->json(['message' => 'Subcategoria tiene productos, se inactivo'], 200);
            } else {
                $plan->delete();
                return response()->json(['message' => 'Subcategoria Eliminada'], 200);
            }
        }
    }

}
