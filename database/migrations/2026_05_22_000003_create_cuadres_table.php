<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cuadres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estacion_id')->constrained('estaciones')->cascadeOnDelete();
            $table->foreignId('turno_id')->constrained('turnos')->cascadeOnDelete();
            $table->date('fecha');
            $table->decimal('lectura_inicial', 12, 3);
            $table->decimal('lectura_final', 12, 3);
            $table->decimal('total_galones', 12, 3)->nullable();
            $table->decimal('total_ventas', 12, 2)->nullable();
            $table->decimal('efectivo', 12, 2)->default(0);
            $table->decimal('boucher', 12, 2)->default(0);
            $table->decimal('credito', 12, 2)->default(0);
            $table->decimal('gastos', 12, 2)->default(0);
            $table->decimal('monedaje', 12, 2)->default(0);
            $table->decimal('total_final', 12, 2)->nullable();
            $table->timestamps();

            $table->unique(['estacion_id', 'turno_id', 'fecha']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cuadres');
    }
};
