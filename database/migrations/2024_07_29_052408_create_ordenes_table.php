<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ordenes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_sucursal');
            $table->integer('id_datos');
            $table->json('datos');
            $table->string('tipo_orden');
            $table->json('datos_empresa');
            $table->json('detalle')->nullable();
            $table->json('comentarios')->nullable();
            $table->json('adjuntos')->nullable();
            $table->string('status1');
            $table->string('status2');
            $table->string('estado_orden')->nullable();
            $table->integer('registrado_por');
            $table->timestamps();
        });

        DB::statement('ALTER TABLE ordenes AUTO_INCREMENT = 10000000;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordenes');
    }
};
