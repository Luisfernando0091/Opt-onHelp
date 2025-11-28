<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    Schema::table('activos', function (Blueprint $table) {
        DB::statement("
            ALTER TABLE activos 
            MODIFY estado ENUM('Disponible', 'Asignado', 'Mantenimiento', 'Baja') 
            NOT NULL DEFAULT 'Disponible'
        ");
    });
}

public function down()
{
    Schema::table('activos', function (Blueprint $table) {
        DB::statement("
            ALTER TABLE activos 
            MODIFY estado ENUM('Disponible', 'Asignado', 'Mantenimiento') 
            NOT NULL DEFAULT 'Disponible'
        ");
    });
}

};
