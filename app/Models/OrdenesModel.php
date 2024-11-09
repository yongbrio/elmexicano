<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenesModel extends Model
{
    use HasFactory;

    protected $table = "ordenes";
    
    protected $fillable = [
        'id_sucursal',
        'id_datos',
        'datos',
        'tipo_orden',
        'datos_empresa',
        'detalle',
        'comentarios',
        'forma_pago',
        'estado_pago',
        'estado_orden',
        'estado_envio',
        'registrado_por',
    ];
    
    public function usuario()
    {
        return $this->belongsTo(User::class, 'registrado_por', 'id'); // 'registrado_por' es la clave foránea
    }
}
