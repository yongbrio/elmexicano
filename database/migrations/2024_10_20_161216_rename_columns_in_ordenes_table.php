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
        Schema::table('ordenes', function (Blueprint $table) {
            // Verificar si las columnas existen antes de renombrarlas
            if (Schema::hasColumn('ordenes', 'status1')) {
                $table->renameColumn('status1', 'forma_pago');
            }
            if (Schema::hasColumn('ordenes', 'status2')) {
                $table->renameColumn('status2', 'estado_pago');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ordenes', function (Blueprint $table) {
            // Verificar si las columnas existen antes de renombrarlas
            if (Schema::hasColumn('ordenes', 'forma_pago')) {
                $table->renameColumn('forma_pago', 'status1');
            }
            if (Schema::hasColumn('ordenes', 'estado_pago')) {
                $table->renameColumn('estado_pago', 'status2');
            }
        });
    }
};

