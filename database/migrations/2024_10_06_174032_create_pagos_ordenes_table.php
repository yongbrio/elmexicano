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
        if (!Schema::hasTable('pagos_ordenes')) {
            Schema::create('pagos_ordenes', function (Blueprint $table) {
                $table->id();
                $table->string('orden');
                $table->string('fecha');
                $table->integer('id_empresa');
                $table->string('nombre_empresa');
                $table->integer('id_cuenta_banco');
                $table->string('numero_cuenta_banco');
                $table->integer('id_sucursal');
                $table->string('nombre_sucursal');
                $table->integer('id_forma_pago');
                $table->string('nombre_forma_pago');
                $table->integer('id_estado_pago');
                $table->string('nombre_estado_pago');
                $table->integer('dias_plazo_pago');
                $table->string('monto');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos_ordenes');
    }
};
