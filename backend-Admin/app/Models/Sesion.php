<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sesion extends Model
{
    protected $table = 'Sesiones';
    protected $primaryKey = 'id_sesion';
    public $timestamps = false;
}
