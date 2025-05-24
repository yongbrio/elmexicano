<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('egresos', function (Blueprint $table) {
            // Asegúrate de que la columna exista
            if (Schema::hasColumn('egresos', 'codigo_producto')) {
                $table->foreign('codigo_producto')
                    ->references('id')
                    ->on('inventario')
                    ->onDelete('cascade'); // O usa SET NULL si es nullable
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('egresos', function (Blueprint $table) {
            $table->dropForeign(['codigo_producto']);
        });
    }
};
