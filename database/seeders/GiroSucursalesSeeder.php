<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GiroSucursalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('giro_sucursales')->insert(
            [
                [
                    'descripcion' => 'Tortilla',
                    'estado' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'descripcion' => 'Totopos',
                    'estado' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'descripcion' => 'Minimarket',
                    'estado' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'descripcion' => 'Restaurante',
                    'estado' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]
        );
    }
}
