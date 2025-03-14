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
            $table->unsignedBigInteger('categoria_1')->nullable()->change();
            $table->unsignedBigInteger('categoria_2')->nullable()->change();
            // Agregar claves foráneas
            $table->foreign('categoria_1')->references('id')->on('categorias_egresos1')->onDelete('set null');
            $table->foreign('categoria_2')->references('id')->on('categorias_egresos2')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('egresos', function (Blueprint $table) {
            // Revertir a VARCHAR(255) si es necesario
            $table->string('categoria_1', 255)->nullable()->change();
            $table->string('categoria_2', 255)->nullable()->change();

            // Eliminar claves foráneas
            $table->dropForeign(['categoria_1']);
            $table->dropForeign(['categoria_2']);
        });
    }
};
