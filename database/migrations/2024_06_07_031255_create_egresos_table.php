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
        Schema::create('egresos', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo_egreso');
            $table->string('categoria_1');
            $table->string('categoria_2');
            $table->integer('tipo_egreso');
            $table->string('descripcion_egreso');
            $table->integer('codigo_producto');
            $table->integer('unidad_medida');
            $table->integer('estado');
            $table->integer('registrado_por');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('egresos');
    }
};
