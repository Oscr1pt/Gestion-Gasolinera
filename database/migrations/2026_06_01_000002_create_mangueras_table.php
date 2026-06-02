<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mangueras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lado_id')->constrained('lados')->cascadeOnDelete();
            $table->integer('numero'); // 1, 2, 3, 4
            $table->boolean('habilitado')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mangueras');
    }
};
