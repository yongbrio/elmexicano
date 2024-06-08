<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EgresosModel extends Model
{
    use HasFactory;

    protected $table = 'egresos';

    protected $fillable = [
        'codigo_egreso',
        'categoria_1',
        'categoria_2',
        'tipo_egreso',
        'descripcion_egreso',
        'codigo_producto',
        'unidad_medida',
        'estado',
        'registrado_por'
    ];
}
