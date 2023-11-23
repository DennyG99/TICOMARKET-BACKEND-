<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VentaProducto extends Model
{
    protected $table = 'Ventas_productos';
    protected $primaryKey = 'id_venta_producto';
    public $timestamps = false;
}
