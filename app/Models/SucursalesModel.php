<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SucursalesModel extends Model
{
    use HasFactory;

    protected $table = "sucursales";

    protected $fillable = [
        'identificador',
        'nombre_sucursal',
        'direccion',
        'departamento',
        'ciudad',
        'estado',
        'registrado_por'
    ];
}
