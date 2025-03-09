<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoSucursalModel extends Model
{
    use HasFactory;

    protected $table = "tipo_sucursales";

    protected $fillable = [
        'descripcion'
    ];
    
    public function sucursales()
    {
        return $this->hasMany(SucursalesModel::class, 'tipo_sucursal_id');
    }
}
