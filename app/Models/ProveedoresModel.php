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

    public function ciudades()
    {
        return $this->belongsTo(MunicipiosModel::class, 'ciudad', 'id');
    }

    public function departamentos()
    {
        return $this->belongsTo(DepartamentosModel::class, 'departamento', 'id');
    }
}
