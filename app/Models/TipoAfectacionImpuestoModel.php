<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoAfectacionImpuestoModel extends Model
{
    use HasFactory;

    protected $table = "tipo_afectacion_impuesto";

    protected $fillable = [
        'nombre_tipo_afectacion_impuesto',
        'estado',
        'registrado_por'
    ];

    public function productos()
    {
        return $this->hasMany(ProductosModel::class, 'tipo_impuesto');
    }
}
