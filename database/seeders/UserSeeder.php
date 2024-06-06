<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Crear permisos
        Permission::updateOrCreate(['name' => 'admin.clientes']);
        Permission::updateOrCreate(['name' => 'admin.proveedores']);
        Permission::updateOrCreate(['name' => 'admin.empresas']);

        $user1 = User::updateOrCreate(
            ['username' => 'josoriob98'], // Condiciones para encontrar el registro
            [
                'name' => 'Jorge Armando',
                'apellidos' => 'Osorio Bolivar',
                'cedula' => '1024587680',
                'fecha_nacimiento' => '1998-02-04',
                'direccion' => 'Cra 17 B Este #60 a - 72',
                'telefono' => '3059455889',
                'correo' => 'jorgearmanbolivar@hotmail.com',
                'fecha_inicio' => '2019-02-04',
                'referencia_1' => 'nombre-teléfono-dirección',
                'referencia_2' => 'nombre-teléfono-dirección',
                'horario' => 'Diurno',
                'eps' => 'Compensar',
                'pension' => 'Protección',
                'banco' => 'Banco Davivienda',
                'numero_cuenta' => '900015741',
                'cargo' => 'Ingeniero FullStack',
                'perfil' => '1',
                'caja' => '1',
                'estado' => '1'
            ]
        );

        DB::table('users')->updateOrInsert(
            ['username' => 'yongbrio'], // Condiciones para encontrar el registro
            [
                'name' => 'Yonatan Ornelas',
                'password' => Hash::make('posAdminMaix80'),
            ]
        );
    }
}
