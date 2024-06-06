<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TipoAfectacionImpuestoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipo_afectacion_impuesto')->insert(
            [
                [
                    'codigo' => '10',
                    'descripcion' => 'IVA 19%',
                    'letra_tributo' => 'S',
                    'codigo_tributo' => '1000',
                    'nombre_tributo' => 'IVA19',
                    'tipo_tributo' => 'VAT',
                    'impuesto' => 19,
                    'estado' => 1,
                ],
                [
                    'codigo' => '20',
                    'descripcion' => 'IVA 5%',
                    'letra_tributo' => 'E',
                    'codigo_tributo' => '9997',
                    'nombre_tributo' => 'IVA5',
                    'tipo_tributo' => 'VAT',
                    'impuesto' => 0,
                    'estado' => 1,
                ],
                [
                    'codigo' => '30',
                    'descripcion' => 'IVA 0%',
                    'letra_tributo' => 'O',
                    'codigo_tributo' => '9998',
                    'nombre_tributo' => 'IVA0',
                    'tipo_tributo' => 'FRE',
                    'impuesto' => 0,
                    'estado' => 1,
                ]
            ]
        );
    }
}
