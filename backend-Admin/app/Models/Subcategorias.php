<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;

class Subcategorias extends Model
{
    protected $table= "subcategoria";
    protected $primaryKey='idSubcategoria';
    public $timestamps =false;

protected $fillable = ['nombre', 'descripcion', 'idEstado','idCategoria'];

public function estado()
    {
        return $this->belongsTo(Estado::class, 'idEstado');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'idCategoria');
    }

}
