<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriasEgresosAsociadasModel extends Model
{
    use HasFactory;


    protected $table = "categorias_egresos_asociadas";

    protected $fillable = [
        'id_categoria_1',
        'id_categoria_2',
        'estado',
        'registrado_por'
    ];

    // Relación con la tabla categorias_egresos1
    public function categoria1()
    {
        return $this->belongsTo(CategoriasEgresos1Model::class, 'id_categoria_1');
    }

    // Relación con la tabla categorias_egresos2
    public function categoria2()
    {
        return $this->belongsTo(CategoriasEgresos2Model::class, 'id_categoria_2');
    }
}
