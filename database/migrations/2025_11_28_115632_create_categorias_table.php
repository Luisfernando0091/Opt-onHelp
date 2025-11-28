<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categoria_inventario', function (Blueprint $table) {
            $table->id();  // autoincrementable
            $table->string('nombre')->unique(); // nombre de la categoría
            $table->text('descripcion')->nullable(); // opcional (por si quieres)
            $table->timestamps(); // created_at y updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categoria_inventario');
    }
};
