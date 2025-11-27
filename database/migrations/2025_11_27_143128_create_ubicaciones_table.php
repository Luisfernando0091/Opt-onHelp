<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // Dentro del archivo de migración (ubicaciones)

public function up(): void
{
    Schema::create('ubicaciones', function (Blueprint $table) {
        $table->id(); // Columna 'id' (clave primaria, auto-incrementable)
        
        // Columna para el nombre del departamento/ubicación
        $table->string('nombre', 100)->unique(); 
        
        $table->timestamps(); // Columnas 'created_at' y 'updated_at'
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ubicaciones');
    }
};