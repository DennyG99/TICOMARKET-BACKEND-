<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reembolsos extends Model
{

    protected $table = "reembolso";
    protected $primaryKey = "idReembolso";
    public $timestamps = false;

    protected $fillable = [
        'idReembolso',
        'fechaSolicitud',
        'idEstado',
        'motivo',
        'idVendedor'
    ];
}