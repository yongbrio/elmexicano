<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenesModel extends Model
{
    use HasFactory;
    
    protected $table = "ordenes";

    protected $fillable = [
        'id_sucursal',
        'id_datos',
        'datos',
        'tipo_orden',
        'datos_empresa',
        'detalle',
        'comentarios',
        'status1',
        'status2',
        'registrado_por',
    ];
}
