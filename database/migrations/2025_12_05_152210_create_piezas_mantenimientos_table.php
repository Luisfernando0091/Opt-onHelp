<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('historial_activos', function (Blueprint $table) {
            $table->foreignId('pieza_id')
                  ->nullable()
                  ->constrained('piezas_mantenimiento')
                  ->nullOnDelete()
                  ->after('activo_id');
        });
    }

    public function down()
    {
        Schema::table('historial_activos', function (Blueprint $table) {
            $table->dropForeign(['pieza_id']);
            $table->dropColumn('pieza_id');
        });
    }
};
