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
            $table->string('nombre');
            $table->string('codigo_barras')->nullable()->unique();
            $table->decimal('precio_venta', 10, 2);
            $table->decimal('costo', 10, 2)->default(0);
            $table->integer('stock_actual')->default(0);
            $table->string('categoria')->default('Otros');
            $table->string('imagen_url')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
