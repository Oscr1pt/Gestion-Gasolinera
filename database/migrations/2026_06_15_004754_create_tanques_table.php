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
        Schema::create('tanques', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // Ej: Gasolina Regular (Mitad 1)
            $table->foreignId('tipo_combustible_id')->constrained('tipos_combustible')->cascadeOnDelete();
            $table->decimal('capacidad_maxima', 12, 3)->default(0);
            $table->decimal('existencia_actual', 12, 3)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tanques');
    }
};
