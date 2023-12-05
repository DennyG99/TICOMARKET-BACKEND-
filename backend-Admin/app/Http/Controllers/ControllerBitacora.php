<?php

namespace App\Http\Controllers;

use App\Models\Sesion;
use Illuminate\Http\Request;

class ControllerBitacora extends Controller
{
    public function getBitacora(){
       $bitacora = Sesion::select('sesiones.*', 'usuarios.correo', 'roles.nombre as rol', 'estados.nombre as estado')
       ->join('usuarios', 'sesiones.id_usuario', '=', 'usuarios.id')
       ->join('roles', 'usuarios.idRol', '=', 'roles.id')
       ->join('estados', 'usuarios.idEstado' , '=', 'estados.id')
       ->orderBy('sesiones.ingreso', 'desc')
       ->get();
       return response()->json($bitacora, 200);
    }
}