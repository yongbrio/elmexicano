<?php

namespace Database\Seeders;

use App\Models\UnidadesMedidaModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnidadesMedidaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UnidadesMedidaModel::insert(
            [
                ['nombre_unidad_medida' => 'Gramos'],
                ['nombre_unidad_medida' => 'Mililitros'],
                ['nombre_unidad_medida' => 'Unidad']
            ]
        );
    }
}
