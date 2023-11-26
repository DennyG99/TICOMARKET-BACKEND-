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

        if (!usuario::where('correo', $request->correo)->where('contrasena', $request->contrasena)) {
            return response()->json(['message' => 'Correo o contraseña incorrectos'], 401);
        }

        $user = usuario::where('correo', $request->correo)->firstOrFail();
        $codigoVerificacionUsuarioAdmin = mt_rand(100000, 999999);
        Mail::to($user->correo)->send(new ControllerMail('Verificación de Administrador', 'Mail.validacionUsuarioAdmin', $codigoVerificacionUsuarioAdmin));
        DB::table('usuarios')
            ->where('correo', $user->correo)
            ->update(['telefono' => $codigoVerificacionUsuarioAdmin]);
        $token = $user->createToken('auth_token', ['expires_in' => 250])->plainTextToken;
        return response()->json([
            'user' => $user,
            'token' => $token
        ], 200);
    }

    public function getUser()
    {
        $user = auth()->user();
        return response()->json(['message' => $user], 200);
    }
    public function logout()
    {
        $sesion = Sesion::find(auth()->user()->id);
        $sesion->salida = now();
        $sesion->save();
        auth()->user()->tokens()->delete();

        return response()->json(['message' => 'Se han cerrado los accesos a la cuenta'], 200);
    }

    public function verificacionAdmin(Request $request)
    {

        $codigoAdmin = $request->codigo;
        $user = auth()->user();
        $codigoAdminBD = DB::table('usuarios')->where('telefono', $codigoAdmin)->where('id', $user->id)->exists();

        if ($codigoAdminBD) {
            $user->tokens()->delete();
            DB::table('usuarios')
                ->where('telefono', $codigoAdmin)->where('id', $user->id)
                ->update(['telefono' => '']);
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'token' => $token,
                'user' => $user,

            ], 200);
            $agent = new Agent();
            $sesion = new Sesion();
            $sesion->id_usuario = $user->id;
            $sesion->ip = $request->ip();
            $sesion->dispositivo = $agent->device();
            $sesion->navegador = $agent->browser();
            $sesion->ingreso = now();
            $sesion->save();
        } else {

            return response()->json(['message' => 'error'], 404);
        }
    }
}
