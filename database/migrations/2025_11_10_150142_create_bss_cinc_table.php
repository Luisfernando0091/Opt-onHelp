<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Bss_Cinc', function (Blueprint $table) {
            $table->id();                          // id autoincremental
            $table->string('CODIGO', 20)->unique(); // código legible, único
            $table->string('nombre_caso', 255);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Bss_Cinc');
    }
};
