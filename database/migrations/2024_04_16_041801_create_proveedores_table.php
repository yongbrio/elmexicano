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
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id();
            $table->string('telefono');
            $table->string('grupo');
            $table->string('nombre_comercial');
            $table->string('nombre_legal');
            $table->string('nit');
            $table->string('sucursal');
            $table->string('direccion');
            $table->string('ciudad');
            $table->string('departamento');
            $table->string('correo');
            $table->string('nombre_encargado');
            $table->string('descripcion');
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
        Schema::dropIfExists('proveedores');
    }
};
