<?php

namespace Database\Seeders;

use App\Models\DepartamentosModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartamentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ruta del archivo CSV
        $filePath = storage_path('app/archivos_conf/departamentos.csv');

        // Abrir el archivo CSV
        if (($handle = fopen($filePath, "r")) !== FALSE) {
            // Leer cada línea del archivo CSV
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                // Crear un nuevo registro en la base de datos
                DepartamentosModel::create([
                    'codigo_dane' => $data[0],
                    'nombre_departamento' => $data[1],
                ]);
            }
            fclose($handle);
        }
    }
}
