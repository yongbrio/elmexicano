<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoSucursalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipo_sucursales')->insert(
            [
                [
                    'descripcion' => 'Propia',
                    'estado' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'descripcion' => 'Franquicia',
                    'estado' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'descripcion' => 'Mixta',
                    'estado' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]
        );
    }
}
