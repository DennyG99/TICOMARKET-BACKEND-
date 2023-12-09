<?php

namespace App\Http\Controllers;

use App\Mail\ControllerMail;
use App\Models\Sesion;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Jenssegers\Agent\Agent;

class ControllerLogin extends Controller
{

    public function register(Request $request)
    {
        $usuario = usuario::create([
            'correo' => $request->correo,
            'contrasena' => bcrypt($request->contrasena),
        ]);



        return response()->json([
            'user' => $usuario,
        ], 200);
    }


    public function login(Request $request)
    {

        $usuario = Usuario::where('correo', $request->correo)->first();
        if (!$usuario || !password_verify($request->contrasena, $usuario->contrasena)) {
            return response()->json(['message' => 'Datos incorrecta'], 401);
        } else {
            $user = usuario::where('correo', $request->correo)->firstOrFail();
            $codigoVerificacionUsuarioAdmin = mt_rand(100000, 999999);
            Mail::to($user->correo)->send(new ControllerMail('Verificación de Administrador', 'Mail.validacionUsuarioAdmin', $codigoVerificacionUsuarioAdmin, ''));
            DB::table('usuarios')
                ->where('correo', $user->correo)
                ->update(['codigoVerificacion' => $codigoVerificacionUsuarioAdmin]);
            $token = $user->createToken('auth_token', ['expires_in' => 450])->plainTextToken;
            return response()->json([
                'user' => $user,
                'token' => $token
            ], 200);
        }
    }

    public function getUser()
    {
        $user = auth()->user();
        return response()->json(['message' => $user], 200);
    }
    public function logout()
    {
        $sesion = Sesion::where('id_usuario', auth()->user()->id)
            ->where('salida', null)
            ->first();

        if ($sesion) {
            $sesion->salida = now();
            $sesion->save();
            auth()->user()->tokens()->delete();
            return response()->json(['message' => 'Se han cerrado los accesos a la cuenta'], 200);
        }
        //return response()->json($sesion);

    }

    public function verificacionAdmin(Request $request)
    {

        $codigoAdmin = $request->codigo;
        $user = auth()->user();
        $codigoAdminBD = DB::table('usuarios')->where('codigoVerificacion', $codigoAdmin)->where('id', $user->id)->exists();

        if ($codigoAdminBD) {
            $user->tokens()->delete();
            DB::table('usuarios')
                ->where('codigoVerificacion', $codigoAdmin)->where('id', $user->id)
                ->update(['codigoVerificacion' => '']);
            $token = $user->createToken('auth_token')->plainTextToken;

            $agent = new Agent();
            $sesion = new Sesion();
            $sesion->id_usuario = $user->id;
            $sesion->ip = $request->ip() . "";
            $sesion->dispositivo = $agent->device();
            $sesion->navegador = $agent->browser();
            $sesion->ingreso = now();
            $sesion->save();

            return response()->json([
                'token' => $token,
                'user' => $user,
                'Sesion' => $sesion,

            ], 200);
        } else {
            return response()->json(['message' => 'error'], 404);
        }
    }
}
