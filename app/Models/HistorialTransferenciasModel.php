<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialTransferenciasModel extends Model
{
    use HasFactory;

    protected $table = "historial_transferencias";

    protected $fillable = [
        'id_sucursal_origen',
        'nombre_sucursal_origen',
        'nombre_producto',
        'codigo_producto',
        'cantidad_transferida',
        'transferencia_recibida',
        'usuario_aprobacion',
        'id_sucursal_destino',
        'nombre_sucursal_destino',
        'registrado_por'
    ];
}
