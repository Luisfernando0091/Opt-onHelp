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
        $table->unsignedBigInteger('ubicacion_id')->nullable()->after('asignado_a');
        $table->foreign('ubicacion_id')->references('id')->on('ubicaciones')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('activos', function (Blueprint $table) {
        $table->dropForeign(['ubicacion_id']);
        $table->dropColumn('ubicacion_id');
    });
}


    /**
     * Reverse the migrations.
    */
    
};
