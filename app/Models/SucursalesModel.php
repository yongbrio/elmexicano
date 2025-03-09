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
        'giro_sucursal_id',
        'tipo_sucursal_id',
        'direccion',
        'departamento',
        'ciudad',
        'barrio_localidad',
        'estado',
        'registrado_por'
    ];
    
    // Relación 1 a 1: Una sucursal pertenece a un tipo de sucursal
    public function giroSucursal()
    {
        return $this->belongsTo(GiroSucursalModel::class, 'giro_sucursal_id');
    }

    // Relación 1 a 1: Una sucursal pertenece a un tipo de sucursal
    public function tipoSucursal()
    {
        return $this->belongsTo(TipoSucursalModel::class, 'tipo_sucursal_id');
    }
}
