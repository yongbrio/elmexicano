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
            if (!Schema::hasColumn('ordenes', 'estado_envio')) {
                $table->integer('estado_envio')->after('estado_orden');
            }
            if (!Schema::hasColumn('ordenes', 'adjuntos_envios')) {
                $table->json('adjuntos_envios')->nullable()->after('estado_orden');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ordenes', function (Blueprint $table) {
            if (Schema::hasColumn('ordenes', 'estado_envio')) {
                $table->dropColumn('estado_envio');
            }
            if (Schema::hasColumn('ordenes', 'adjuntos_envios')) {
                $table->dropColumn('adjuntos_envios');
            }
        });
    }
};
