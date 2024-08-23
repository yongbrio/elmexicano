<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogModel extends Model
{
    use HasFactory;

    protected $table = "log";

    protected $fillable = [
        'id_usuario',
        'nombre_usuario',
        'nombre_apellido',
        'action',
        'model',
        'model_id',
        'old_values',
        'new_values'
    ];
}
