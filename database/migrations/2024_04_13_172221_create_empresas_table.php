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
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('nit');
            $table->string('nombre_comercial');
            $table->string('nombre_legal');
            $table->string('departamento');
            $table->string('ciudad');
            $table->string('direccion');
            $table->string('matricula');
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
        Schema::dropIfExists('empresas');
    }
};
