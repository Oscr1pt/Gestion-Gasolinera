<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cuadre_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cuadre_id')->constrained('cuadres')->cascadeOnDelete();
            $table->foreignId('tipo_combustible_id')->constrained('tipos_combustible')->cascadeOnDelete();
            $table->decimal('numeracion_inicial', 12, 3);
            $table->decimal('numeracion_final', 12, 3);
            $table->decimal('galones', 12, 3)->nullable();
            $table->decimal('precio', 10, 2);
            $table->decimal('total', 12, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cuadre_detalles');
    }
};
