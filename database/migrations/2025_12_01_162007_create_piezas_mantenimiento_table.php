<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('piezas_mantenimiento', function (Blueprint $table) {
            $table->id(); // id autoincremental
            $table->string('nombre'); // nombre de la pieza
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('piezas_mantenimiento');
    }
};
