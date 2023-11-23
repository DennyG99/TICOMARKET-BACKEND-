<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ControllerMail;
use App\Models\Usuario;


class ControllerNotificaciones extends Controller
{
    public function contenido(){
        return request('contenido');
        }
    
         public function val(Request $request)
        {
            $asunto = $request->query('asunto');
            // Estos datos serán tomados de la BD más adelante
    
            $usuarios = Usuario::all();
       
            foreach ($usuarios as $usuario) {
                Mail::to($usuario->correo)->send(new ControllerMail($asunto, 'Mail.noti',0));
            }
            // Verifica que el usuario ingresado exista en la BD
    
            // Envia el correo de prueba al correo ingresado junto con el asunto
    
            return "Correo enviado con éxito";
        }
}
