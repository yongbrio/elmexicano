<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoProductoModel extends Model
{
    use HasFactory;

    protected $table = "tipo_producto";

    protected $fillable = [
        'nombre_tipo_producto'
    ];
}
