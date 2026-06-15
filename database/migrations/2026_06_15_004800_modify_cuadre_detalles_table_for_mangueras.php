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
        Schema::table('cuadre_detalles', function (Blueprint $table) {
            $table->foreignId('manguera_id')->nullable()->constrained('mangueras')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cuadre_detalles', function (Blueprint $table) {
            $table->dropForeign(['manguera_id']);
            $table->dropColumn('manguera_id');
        });
    }
};
