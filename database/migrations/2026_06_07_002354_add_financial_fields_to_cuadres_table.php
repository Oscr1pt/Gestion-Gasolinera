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
        Schema::table('cuadres', function (Blueprint $table) {
            $table->decimal('efectivo', 12, 2)->default(0);
            $table->decimal('boucher', 12, 2)->default(0);
            $table->decimal('credito', 12, 2)->default(0);
            $table->decimal('moneda', 12, 2)->default(0);
            $table->decimal('gastos', 12, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cuadres', function (Blueprint $table) {
            $table->dropColumn(['efectivo', 'boucher', 'credito', 'moneda', 'gastos']);
        });
    }
};
