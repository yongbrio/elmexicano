<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerfilesModel extends Model
{
    use HasFactory;

    protected $table = "perfiles";

    protected $fillable = [
        'id_rol',
        'estado',
        'registrado_por'
    ];
}
