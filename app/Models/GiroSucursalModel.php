<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiroSucursalModel extends Model
{
    use HasFactory;

    protected $table = "giro_sucursales";

    protected $fillable = [
        'descripcion'
    ];

    public function sucursales()
    {
        return $this->hasMany(SucursalesModel::class, 'giro_sucursal_id');
    }
}
