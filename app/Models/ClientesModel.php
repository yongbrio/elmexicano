<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientesModel extends Model
{
    use HasFactory;

    protected $table = "clientes";

    protected $fillable = [
        'nombre_comercial',
        'nombre_legal',
        'grupo',
        'telefono',
        'nit',
        'sucursal',
        'direccion',
        'ciudad',
        'departamento',
        'correo',
        'nombre_encargado',
        'descripcion',
        'empresa_factura',
        'importancia',
        'barrio_localidad',
        'estado',
        'registrado_por'
    ];
}
