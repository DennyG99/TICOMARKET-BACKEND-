<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tienda extends Model
{
    protected $table = 'Tiendas';
    protected $primaryKey = 'id_tienda';
    public $timestamps = false;
}
