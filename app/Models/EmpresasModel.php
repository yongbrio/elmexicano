<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpresasModel extends Model
{
    use HasFactory;

    protected $table = "empresas";

    protected $fillable = [
        'nit',
        'nombre_comercial',
        'nombre_legal',
        'departamento',
        'ciudad',
        'direccion',
        'matricula',
        'estado',
        'registrado_por'
    ];
}
