<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventarioModel extends Model
{
    use HasFactory;

    protected $table = "inventario";

    protected $fillable = [
        'codigo_producto',
        'sucursal',
        'categoria',
        'tipo',
        'descripcion',
        'unidad_medida',
        'tipo_producto',
        'costo_unitario',
        'precio_unitario_con_iva',
        'precio_unitario_sin_iva',
        'stock',
        'stock_minimo',
        'imagen',
        'registrado_por',
        'comision',
        'estado'
    ];
}
