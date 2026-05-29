<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $duplicados = DB::table('empleados')
            ->select('telefono')
            ->groupBy('telefono')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('telefono');

        foreach ($duplicados as $telefono) {
            $ids = DB::table('empleados')
                ->where('telefono', $telefono)
                ->orderBy('id')
                ->pluck('id')
                ->slice(1);

            foreach ($ids as $id) {
                DB::table('empleados')
                    ->where('id', $id)
                    ->update(['telefono' => $telefono . '-dup-' . $id]);
            }
        }

        Schema::table('empleados', function (Blueprint $table) {
            $table->unique('telefono');
        });
    }

    public function down(): void
    {
        Schema::table('empleados', function (Blueprint $table) {
            $table->dropUnique(['telefono']);
        });
    }
};
