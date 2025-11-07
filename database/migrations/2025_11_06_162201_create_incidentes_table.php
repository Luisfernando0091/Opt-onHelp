<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('incidentes', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 20)->unique();
            $table->string('titulo', 255);
            $table->text('descripcion');
            $table->enum('estado', ['Pendiente', 'En proceso', 'A la espera', 'Finalizado'])->default('Pendiente');
            $table->enum('prioridad', ['Baja', 'Media', 'Alta', 'Crítica'])->default('Media');
            
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('tecnico_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('categoria_id')->nullable()->constrained('categorias')->onDelete('set null');
            
            $table->dateTime('fecha_reporte')->useCurrent();
            $table->dateTime('fecha_cierre')->nullable();
            $table->text('solucion')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('incidentes');
    }
};
