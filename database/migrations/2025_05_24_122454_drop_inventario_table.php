<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Eliminar la clave foránea de la tabla 'egresos'
        Schema::table('egresos', function (Blueprint $table) {
            // Primero revisamos si la columna y la FK existen
            if (Schema::hasColumn('egresos', 'codigo_producto')) {
                // Usamos SQL directo para evitar errores si Laravel no detecta bien la FK
                DB::statement('ALTER TABLE egresos DROP FOREIGN KEY egresos_codigo_producto_foreign');
            }
        });

        // Ahora sí podemos eliminar la tabla 'inventario'
        Schema::dropIfExists('inventario');
    }

    public function down(): void {}
};
