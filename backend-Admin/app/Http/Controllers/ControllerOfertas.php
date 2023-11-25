<?php

namespace App\Http\Controllers;

use App\Models\UsuarioPlan;
use Illuminate\Support\Facades\DB;


class ControllerOfertas extends Controller
{
	//CONSULTA DE INGRESOS POR ANUNCIOS EN LA PLATAFORMA
    public function ingresosPorAnuncios()
    {
        //LA SIGUIENTE CONSULTA TRADUCE LOS MESES AL ESPAÑOL
        DB::statement("SET lc_time_names = 'es_ES'"); //EL STATEMENT EJECUTA UNA CONSULTA SIN PROCESARLA 
        $resultados = UsuarioPlan::select(DB::raw('MONTHNAME(usuarios_plan.fechaAdquisicion) as mes'), DB::raw('SUM(planes.precio) as ingresoTotal'))
            ->join('planes', 'usuarios_plan.idPlan', '=', 'planes.idPlan')
            ->where('usuarios_plan.idPlan', '>', 3)
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        return response()->json($resultados);
    }
}
