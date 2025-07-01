<?php

namespace Database\Seeders;

use App\Models\UnidadesMedidaModel;
use Illuminate\Database\Seeder;

class UnidadesMedidaExtraSeeder extends Seeder
{
    public function run(): void
    {
        UnidadesMedidaModel::insert([
            ['nombre_unidad_medida' => 'Kilo'],
            ['nombre_unidad_medida' => 'Litro'],
        ]);
    }
}
