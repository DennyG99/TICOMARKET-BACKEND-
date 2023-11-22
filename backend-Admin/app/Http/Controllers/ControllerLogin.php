<?php

namespace App\Http\Controllers;

use App\Mail\ControllerMail;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ControllerLogin extends Controller
{

    public function login(){

        return view("login");
    }

    public function val(){

        //estos datos serán tomados de la BD más adelante
        $emBD = "stantf99@gmail.com";
        $passBD = "1";

       //obtiene el correo electronico ingresado
       $emailUserAdmin = request('email');
       //obtiene la contraseña ingresada
       $passwordUserAdmin = request('password');
        $dato = "123";
        $_SESSION['dato'] = $dato;

       //verifica que el usuario ingresado exista en la BD
       if($emailUserAdmin == $emBD && $passBD == $passwordUserAdmin){

        //envia el email de prueba al correo ingresado junto con el asun-to y la vista del mismo
        Mail::to($emailUserAdmin)->send(new ControllerMail('Verificación de Administrador', 'Mail.validacionUsuarioAdmin'));

        return "correo enviado con éxito";
       }else{

        return "usuario no existente";
       }
    }
}

?>
