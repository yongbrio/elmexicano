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
        Schema::create('tipo_afectacion_impuesto', function (Blueprint $table) {
            $table->id();
            $table->char('codigo', 3);
            $table->string('descripcion');
            $table->string('letra_tributo');
            $table->string('codigo_tributo');
            $table->string('nombre_tributo');
            $table->string('tipo_tributo');
            $table->double('impuesto', 8, 2);
            $table->integer('estado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_afectacion_impuesto');
    }
};
