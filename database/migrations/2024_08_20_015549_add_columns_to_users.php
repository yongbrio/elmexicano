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
        Schema::table('users', function (Blueprint $table) {

            if (!Schema::hasColumn('users', 'nombre_contacto_emergencia')) {
                $table->string('nombre_contacto_emergencia')->after('imagen');
            }

            if (!Schema::hasColumn('users', 'numero_contacto_emergencia')) {
                $table->string('numero_contacto_emergencia')->after('imagen');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('nombre_contacto_emergencia');
            $table->dropColumn('numero_contacto_emergencia');
        });
    }
};
