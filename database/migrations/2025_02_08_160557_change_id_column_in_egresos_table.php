<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Eliminar la columna codigo_egreso si existe
        if (Schema::hasColumn('egresos', 'codigo_egreso')) {
            Schema::table('egresos', function (Blueprint $table) {
                $table->dropColumn('codigo_egreso');
            });
        }

        // Establecer el valor inicial del autoincremento en 9000
        DB::statement('ALTER TABLE egresos AUTO_INCREMENT = 9000;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir el valor inicial del autoincremento
        DB::statement('ALTER TABLE egresos AUTO_INCREMENT = 1;');

        // Recrear la columna 
        Schema::table('egresos', function (Blueprint $table) {
            $table->integer('codigo_egreso')->nullable()->after('id');
        });
    }
};
