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

    public function categoria1()
    {
        return $this->belongsTo(CategoriasEgresos1Model::class, 'categoria_1', 'id');
    }

    public function categoria2()
    {
        return $this->belongsTo(CategoriasEgresos2Model::class, 'categoria_2', 'id');
    }

    public function codigoProducto()
    {
        return $this->belongsTo(ProductosModel::class, 'codigo_producto', 'id');
    }
}
