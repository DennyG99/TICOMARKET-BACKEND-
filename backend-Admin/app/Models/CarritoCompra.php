<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarritoCompra extends Model
{
    protected $table = 'carritoCompras';
    protected $primaryKey = 'idCarrito';
    public $timestamps = false;

}
