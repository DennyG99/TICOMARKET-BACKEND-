<?php


namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use App\Mail\validacionUsuarioAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class ControllerLogin extends Controller
{

    public function login(){

        return view("login");
    }

    public function val(){

        //estos datos serán tomados de la BD más adelante
        $emBD = "correo@gmail.com";
        $passBD = "1";

       //obtiene el correo electronico ingresado
       $em = request('email');
       //obtiene la contraseña ingresada
       $pass = request('password');

       //verifica que el usuario ingresado exista en la BD
       if($em == $emBD && $passBD == $pass){

        //envia el email de prueba al correo ingresado
        Mail::to($em)->send(new validacionUsuarioAdmin);

        return "correo enviado con éxito";
       }else{

        return "usuario no existente";
       }
    }
}

?>