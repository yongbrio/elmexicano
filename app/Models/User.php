<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'apellidos',
        'cedula',
        'fecha_nacimiento',
        'direccion',
        'telefono',
        'correo',
        'fecha_inicio',
        'referencia_1',
        'referencia_2',
        'horario',
        'username',
        'eps',
        'pension',
        'banco',
        'numero_cuenta',
        'cargo',
        'numero_contacto_emergencia',
        'nombre_contacto_emergencia',
        'password',
        'perfil',
        'caja',
        'imagen',
        'estado'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function productosRegistrados()
    {
        return $this->hasMany(ProductosModel::class, 'registrado_por');
    }
}
