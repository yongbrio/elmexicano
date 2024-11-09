<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagosOrdenes extends Model
{
    use HasFactory;

    protected $table = "pagos_ordenes";

    protected $fillable = [
        'orden',
        'fecha',
        'id_empresa',
        'nombre_empresa',
        'id_cuenta_banco',
        'numero_cuenta_banco',
        'id_sucursal',
        'nombre_sucursal',
        'id_forma_pago',
        'nombre_forma_pago',
        'id_estado_pago',
        'nombre_estado_pago',
        'dias_plazo_pago',
        'monto'
    ];
}
