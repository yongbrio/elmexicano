<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriasModel extends Model
{
    use HasFactory;
    
    protected $table = "categorias";

    protected $fillable = [
        'nombre_categoria',
        'estado',
        'registrado_por'
    ];
}
