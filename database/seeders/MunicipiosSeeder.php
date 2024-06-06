<?php

namespace Database\Seeders;

use App\Models\MunicipiosModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MunicipiosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ruta del archivo CSV
        $filePath = storage_path('app/archivos_conf/municipios.csv');

        // Abrir el archivo CSV
        if (($handle = fopen($filePath, "r")) !== FALSE) {
            // Leer cada línea del archivo CSV
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                // Crear un nuevo registro en la base de datos
                MunicipiosModel::create([
                    'codigo_departamento' => $data[0],
                    'codigo_municipio' => $data[1],
                    'nombre_municipio' => $data[2],
                ]);
            }
            fclose($handle);
        }
    }
}
