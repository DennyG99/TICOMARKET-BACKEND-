<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioPlan extends Model
{
    protected $table = 'Usuarios_plan';
    protected $primaryKey = 'id_usuario_plan';
    public $timestamps = false;
}
