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
        Schema::create('inventario', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_producto')->unique();
            $table->string('sucursal');
            $table->string('categoria');
            $table->string('tipo');
            $table->text('descripcion');
            $table->string('unidad_medida');
            $table->double('costo_unitario', 2);
            $table->double('precio_unitario_con_iva', 2);
            $table->double('precio_unitario_sin_iva', 2);
            $table->double('stock', 2);
            $table->double('stock_minimo', 2);
            $table->string('imagen');
            $table->double('comision', 2);
            $table->integer('registrado_por');
            $table->string('estado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventario');
    }
};
