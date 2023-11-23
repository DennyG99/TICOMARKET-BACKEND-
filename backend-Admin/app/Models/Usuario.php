<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Usuario extends Authenticatable
{
<<<<<<< HEAD
   
    protected $table  = "usuarios";
    protected $primaryKey = "id";
=======
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'id';
    protected $table = 'Usuarios';
>>>>>>> 4a8e4d780d5f2aa04e3949d9a86ce46eb2e10f3b
    public $timestamps = false;

    protected $fillable = [
        'correo',
        'contrasena',
    ];
    protected $hidden = [
        'contrasena',
        'remember_token',
    ];

}
