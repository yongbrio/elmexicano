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
        Schema::table('historial_transferencias', function (Blueprint $table) {
            if (!Schema::hasColumn('historial_transferencias', 'transferencia_recibida')) {
                $table->integer('transferencia_recibida')->after('cantidad_transferida');
            }
            if (!Schema::hasColumn('historial_transferencias', 'usuario_aprobacion')) {
                $table->integer('usuario_aprobacion')->after('transferencia_recibida');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historial_transferencias', function (Blueprint $table) {
            if (Schema::hasColumn('historial_transferencias', 'transferencia_recibida')) {
                $table->dropColumn('transferencia_recibida');  //Eliminar la columna si existe
            }
            if (Schema::hasColumn('historial_transferencias', 'transfeusuario_aprobacionrencia_recibida')) {
                $table->dropColumn('usuario_aprobacion');  //Eliminar la columna si existe
            }
        });
    }
};
