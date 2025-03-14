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
            $table->unsignedBigInteger('codigo_producto')->nullable()->change();
            // Agregar clave foránea
            $table->foreign('codigo_producto')->references('id')->on('inventario')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('egresos', function (Blueprint $table) {
            // Revertir a VARCHAR(255) si es necesario
            $table->string('codigo_producto', 255)->nullable()->change();
            // Eliminar clave foránea
            $table->dropForeign(['codigo_producto']);
        });
    }
};
