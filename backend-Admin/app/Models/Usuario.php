<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'id';
    protected $table = 'Usuarios';
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
