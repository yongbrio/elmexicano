<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentasBancariasModel extends Model
{
    use HasFactory;

    protected $table = 'cuentas_bancarias';

    protected $casts = [
        'fecha_apertura' => 'datetime:U', // 'U' indica el formato Unix
    ];

    protected $fillable = [
        'tipo_cuenta',
        'numero_cuenta',
        'nombre_banco',
        'fecha_apertura',
        'empresa',
        'estado',
        'registrado_por',
    ];
}
