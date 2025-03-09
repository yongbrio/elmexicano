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
        Schema::create('categorias_egresos_asociadas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_categoria_1')
                ->constrained('categorias_egresos1') // Referencia a la tabla categorias_egresos1
                ->onDelete('restrict');
            $table->foreignId('id_categoria_2')
                ->constrained('categorias_egresos2') // Referencia a la tabla categorias_egresos2
                ->onDelete('restrict');
            $table->integer('estado');
            $table->string('registrado_por');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorias_egresos_asociadas');
    }
};
