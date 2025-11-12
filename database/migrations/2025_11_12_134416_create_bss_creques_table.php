<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bss_creque', function (Blueprint $table) {
            $table->string('CODIGO', 10)->primary(); // Ejemplo: RA-0001
            $table->string('nombre_caso', 255);
            $table->unsignedBigInteger('usuario_id')->nullable(); // Usuario de alta
            $table->timestamps();

            // Relaciones (opcional)
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bss_creque');
    }
};
