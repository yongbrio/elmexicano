<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriasEgresos1Model extends Model
{
    use HasFactory;

    protected $table = "categorias_egresos1";

    protected $fillable = [
        'nombre_categoria',
        'estado',
        'registrado_por'
    ];

    // Relación con la tabla categorias_egresos_asociadas
    public function categoriasAsociadas()
    {
        return $this->hasMany(CategoriasEgresosAsociadasModel::class, 'id_categoria_1');
    }


}
