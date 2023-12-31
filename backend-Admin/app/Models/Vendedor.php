<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendedor extends Model
{
    protected $table = 'vendedores';
    protected $primaryKey = 'idVendedor';
    public $timestamps = false;

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'idEstado');
    }

    public function usuario(){
        return $this->belongsTo(Usuario::class , 'idVendedor');
    }
}
