<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriasEgresos2Model extends Model
{
    use HasFactory;

    protected $table = "categorias_egresos2";

    protected $fillable = [
        'nombre_categoria',
        'estado',
        'registrado_por'
    ];

    // Relación con la tabla categorias_egresos_asociadas
    public function categoriasAsociadas()
    {
        return $this->hasMany(CategoriasEgresosAsociadasModel::class, 'id_categoria_2');
    }
}
