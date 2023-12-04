<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Politicas extends Model
{
    protected $primaryKey = "idPolitica";
    protected $table  = "politicas";
    public $timestamps = false;

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'idEstado');
    }
}
