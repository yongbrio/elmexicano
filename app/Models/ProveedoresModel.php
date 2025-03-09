<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProveedoresModel extends Model
{
    use HasFactory;

    protected $table = "proveedores";

    protected $fillable = [
        'telefono',
        'grupo',
        'nombre_comercial',
        'nombre_legal',
        'nit',
        'sucursal',
        'direccion',
        'ciudad',
        'departamento',
        'barrio_localidad',
        'correo',
        'nombre_encargado',
        'descripcion',
        'estado',
        'registrado_por'
    ];
}
