<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('egresos', function (Blueprint $table) {
            // Primero eliminamos la llave foránea incorrecta
            $table->dropForeign(['codigo_producto']);

            // Ahora agregamos la correcta hacia productos
            $table->foreign('codigo_producto')
                ->references('id')
                ->on('productos')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('egresos', function (Blueprint $table) {
            // En reversa, quitamos la nueva y volvemos a la antigua (opcional)
            $table->dropForeign(['codigo_producto']);

            $table->foreign('codigo_producto')
                ->references('id')
                ->on('inventario')
                ->onDelete('cascade');
        });
    }
};
