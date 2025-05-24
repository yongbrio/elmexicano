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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_producto')->unique();
            $table->foreignId('categoria')->nullable()->constrained('categorias')->nullOnDelete();
            $table->foreignId('tipo_impuesto')->nullable()->constrained('tipo_afectacion_impuesto')->nullOnDelete();
            $table->text('descripcion')->nullable();
            $table->foreignId('unidad_medida')->nullable()->constrained('unidades_medida')->nullOnDelete();
            $table->double('costo_unitario')->nullable();
            $table->double('precio_unitario_con_iva')->nullable();
            $table->double('precio_unitario_sin_iva')->nullable();
            $table->string('imagen')->nullable();
            $table->double('comision')->nullable();
            $table->foreignId('tipo_producto')->nullable()->constrained('tipo_producto')->nullOnDelete();
            $table->foreignId('registrado_por')->nullable()->constrained('users')->nullOnDelete();
            $table->integer('estado')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
