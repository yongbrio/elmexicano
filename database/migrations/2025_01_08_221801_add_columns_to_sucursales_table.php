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
        Schema::table('sucursales', function (Blueprint $table) {
            if (!Schema::hasColumn('sucursales', 'giro_sucursal_id')) {
                $table->unsignedBigInteger('giro_sucursal_id')->after('nombre_sucursal')->default(1); // Valor predeterminado
                // Definir la llave foránea
                $table->foreign('giro_sucursal_id')
                    ->references('id')
                    ->on('giro_sucursales');
            }

            if (!Schema::hasColumn('sucursales', 'tipo_sucursal_id')) {
                $table->unsignedBigInteger('tipo_sucursal_id')->after('giro_sucursal_id')->default(1); // Valor predeterminado;
                // Definir la llave foránea
                $table->foreign('tipo_sucursal_id')
                    ->references('id')
                    ->on('tipo_sucursales')
                    ->onDelete('cascade');
            }

            if (!Schema::hasColumn('sucursales', 'barrio_localidad')) {
                $table->string('barrio_localidad')->after('ciudad');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sucursales', function (Blueprint $table) {
            if (Schema::hasColumn('sucursales', 'giro_sucursal_id')) {
                $table->dropForeign(['giro_sucursal_id']); // Eliminar la llave foránea
                $table->dropColumn('giro_sucursal_id');    // Luego eliminar la columna
            }

            if (Schema::hasColumn('sucursales', 'tipo_sucursal_id')) {
                $table->dropForeign(['tipo_sucursal_id']); // Eliminar la llave foránea
                $table->dropColumn('tipo_sucursal_id');    // Luego eliminar la columna
            }

            if (Schema::hasColumn('sucursales', 'barrio_localidad')) {
                $table->dropColumn('barrio_localidad');
            }
        });
    }
};
