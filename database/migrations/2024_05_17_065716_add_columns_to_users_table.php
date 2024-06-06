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

            $table->string('apellidos')->nullable()->after('name');
            $table->string('cedula')->nullable()->after('password');
            $table->string('fecha_nacimiento')->nullable()->after('cedula');
            $table->string('direccion')->nullable()->after('fecha_nacimiento');
            $table->string('telefono')->nullable()->after('direccion');
            $table->string('correo')->nullable()->after('telefono');
            $table->string('fecha_inicio')->nullable()->after('correo');
            $table->string('referencia_1')->nullable()->after('fecha_inicio');
            $table->string('referencia_2')->nullable()->after('referencia_1');
            $table->string('horario')->nullable()->after('referencia_2');
            $table->string('eps')->nullable()->after('horario');
            $table->string('pension')->nullable()->after('eps');
            $table->string('banco')->nullable()->after('pension');
            $table->string('numero_cuenta')->nullable()->after('banco');
            $table->string('cargo')->nullable()->after('numero_cuenta');
            $table->string('perfil')->nullable()->after('cargo');
            $table->string('caja')->nullable()->after('perfil');
            $table->string('imagen')->nullable()->after('caja');
            $table->integer('estado')->nullable()->after('imagen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('apellidos');
            $table->dropColumn('cedula');
            $table->dropColumn('fecha_nacimiento');
            $table->dropColumn('direccion');
            $table->dropColumn('telefono');
            $table->dropColumn('correo');
            $table->dropColumn('fecha_inicio');
            $table->dropColumn('referencia_1');
            $table->dropColumn('referencia_2');
            $table->dropColumn('horario');
            $table->dropColumn('eps');
            $table->dropColumn('pension');
            $table->dropColumn('banco');
            $table->dropColumn('numero_cuenta');
            $table->dropColumn('cargo');
            $table->dropColumn('perfil');
            $table->dropColumn('caja');
            $table->dropColumn('imagen');
            $table->dropColumn('estado');
        });
    }
};
