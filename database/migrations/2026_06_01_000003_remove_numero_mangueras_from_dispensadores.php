<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dispensadores', function (Blueprint $table) {
            $table->dropColumn('numero_mangueras');
        });
    }

    public function down(): void
    {
        Schema::table('dispensadores', function (Blueprint $table) {
            $table->integer('numero_mangueras')->default(8);
        });
    }
};
