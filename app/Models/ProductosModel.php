<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductosModel extends Model
{
    use HasFactory;

    protected $table = "productos";

    protected $fillable = [
        'codigo_producto',
        'categoria',
        'tipo_impuesto',
        'descripcion',
        'unidad_medida',
        'costo_unitario',
        'precio_unitario_con_iva',
        'precio_unitario_sin_iva',
        'imagen',
        'comision',
        'tipo_producto',
        'registrado_por',
        'estado'
    ];

    public function categoria()
    {
        return $this->belongsTo(CategoriasModel::class, 'categoria');
    }

    public function tipoImpuesto()
    {
        return $this->belongsTo(TipoAfectacionImpuestoModel::class, 'tipo_impuesto');
    }

    public function unidadMedida()
    {
        return $this->belongsTo(UnidadesMedidaModel::class, 'unidad_medida');
    }

    public function tipoProducto()
    {
        return $this->belongsTo(TipoProductoModel::class, 'tipo_producto');
    }

    public function registradoPor()
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }
}
