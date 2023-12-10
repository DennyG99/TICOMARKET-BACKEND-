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
        'nombre', 'apellidoUno', 'apellidoDos', 'correo', 'contrasena', 'idRol', 'idEstado', 'fechaAcceso', 'tiempoInactividad', 'telefono'
    ];
    protected $hidden = [
        'contrasena',
        'remember_token',
    ];
/**/
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'idEstado');
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'idRol');
    }
    public function vendedor()
    {
        return $this->belongsTo(Vendedor::class, 'id');
    }
}
