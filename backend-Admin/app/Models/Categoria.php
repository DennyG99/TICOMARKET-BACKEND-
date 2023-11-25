<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $primaryKey = "idCategoria";
    protected $table  = "Categorias";
    public $timestamps = false;
    
    public function productos()
    {
        return $this->hasMany(Producto::class, 'categoria', 'idCategoria');
    }
}