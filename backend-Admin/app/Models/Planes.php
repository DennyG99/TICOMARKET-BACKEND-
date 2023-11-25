<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planes extends Model
{
    protected $table= "planes";
    protected $primaryKey='idPlan';
    public $timestamps =false;

    protected $fillable = ['nombre', 'descripcion', 'tipoPlan','precio','idEstado'];
}
