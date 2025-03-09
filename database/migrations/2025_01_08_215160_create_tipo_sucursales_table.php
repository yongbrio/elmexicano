<?php

use Database\Seeders\TipoSucursalesSeeder;
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
        Schema::create('tipo_sucursales', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion');
            $table->integer('estado');
            $table->timestamps();
        });

        // Llamar al seeder después de crear la tabla
        (new TipoSucursalesSeeder())->run();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_sucursales');
    }
};
