<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventarioModel extends Model
{
    use HasFactory;

    protected $table = "inventario";

    protected $fillable = [
        'producto_id',
        'sucursal_id',
        'stock',
        'stock_minimo',
        'registrado_por',
        'comisiona',
        'estado'
    ];

    public function producto()
    {
        return $this->belongsTo(ProductosModel::class, 'producto_id');
    }

    public function sucursal()
    {
        return $this->belongsTo(SucursalesModel::class, 'sucursal_id');
    }

    public function registro()
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }

    public function getComisionaTextoAttribute(): string
    {
        return is_null($this->comisiona) ? 'No seleccionó' : ($this->comisiona ? 'Sí' : 'No');
    }
}
