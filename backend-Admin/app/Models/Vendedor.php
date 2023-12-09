<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendedor extends Model
{
    protected $table = 'vendedores';
    protected $primaryKey = 'idVendedores';
    public $timestamps = false;

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'idEstado');
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'idRol');
    }
}
