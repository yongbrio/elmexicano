<?php

namespace Database\Seeders;

use App\Models\TipoProductoModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipoProductoModel::insert(
            [
                ['nombre_tipo_producto' => 'Insumo'],
                ['nombre_tipo_producto' => 'Híbrido'],
                ['nombre_tipo_producto' => 'Regular']
            ]
        );
    }
}
