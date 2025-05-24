<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadesMedidaModel extends Model
{
    use HasFactory;

    protected $table = "unidades_medida";

    protected $filable = [
        'nombre_unidad_medida'
    ];

    public function productos()
    {
        return $this->hasMany(ProductosModel::class, 'unidad_medida');
    }
}
