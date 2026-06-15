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
        Schema::table('mangueras', function (Blueprint $table) {
            $table->foreignId('tipo_combustible_id')->nullable()->constrained('tipos_combustible')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mangueras', function (Blueprint $table) {
            $table->dropForeign(['tipo_combustible_id']);
            $table->dropColumn('tipo_combustible_id');
        });
    }
};
