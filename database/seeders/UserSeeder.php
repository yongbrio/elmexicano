<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear permisos generales
        $generalPermissions = [
            'caja',
            'clientes',
            'proveedores',
            'inventario',
            'egresos',
        ];

        foreach ($generalPermissions as $permission) {
            Permission::updateOrCreate(['name' => $permission]);
        }

        // Crear permisos de administración
        $adminPermissions = [
            'admin.clientes',
            'admin.proveedores',
            'admin.empresas',
            'admin.sucursales',
            'admin.cuentas_bancarias',
            'admin.inventario',
            'admin.categoria.productos',
            'admin.egresos',
        ];

        foreach ($adminPermissions as $permission) {
            Permission::updateOrCreate(['name' => $permission]);
        }

        // Crear permisos de seguridad
        $securityPermissions = [
            'seguridad.usuarios',
            'seguridad.perfiles',
        ];

        foreach ($securityPermissions as $permission) {
            Permission::updateOrCreate(['name' => $permission]);
        }

        // Crear rol Admin
        $adminRole = Role::updateOrCreate(['name' => 'Admin']);

        // Asignar todos los permisos al rol Admin
        $allPermissions = array_merge($generalPermissions, $adminPermissions, $securityPermissions);
        foreach ($allPermissions as $permission) {
            $adminRole->givePermissionTo($permission);
        }

        // Crear usuarios y asignarles el rol Admin
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
        $user1->assignRole('Admin');

        $user2 = User::updateOrCreate(
            ['username' => 'yongbrio'], // Condiciones para encontrar el registro
            [
                'name' => 'Yonatan',
                'apellidos' => 'Ornelas',
                /* 'password' => Hash::make('posAdminMaix80'), */
                'cedula' => '1111111111',
                'fecha_nacimiento' => '1990-03-08',
                'direccion' => 'dirección',
                'telefono' => '3000000000',
                'fecha_inicio' => '2019-02-04',
                'referencia_1' => 'nombre-teléfono-dirección',
                'referencia_2' => 'nombre-teléfono-dirección',
                'horario' => 'Diurno',
                'eps' => 'Compensar',
                'pension' => 'Protección',
                'banco' => 'Banco Davivienda',
                'numero_cuenta' => '900015741',
                'cargo' => 'cargo',
                'perfil' => '1',
                'caja' => '1',
                'estado' => '1'
            ]
        );
        $user2->assignRole('Admin');
    }
}
