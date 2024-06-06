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
        Schema::create('historial_transferencias', function (Blueprint $table) {
            $table->id();
            $table->integer('id_sucursal_origen');
            $table->string('nombre_sucursal_origen');
            $table->string('nombre_producto');
            $table->string('codigo_producto');
            $table->string('cantidad_transferida');
            $table->integer('id_sucursal_destino');
            $table->string('nombre_sucursal_destino');
            $table->string('registrado_por');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_transferencias');
    }
};
