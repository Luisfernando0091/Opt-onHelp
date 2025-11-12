<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('requerimientos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->string('estado')->default('Pendiente');
            $table->string('prioridad')->nullable();
            $table->unsignedBigInteger('usuario_id')->nullable();
            $table->unsignedBigInteger('tecnico_id')->nullable();
            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->dateTime('fecha_reporte')->nullable();
            $table->dateTime('fecha_cierre')->nullable();
            $table->text('solucion')->nullable();
            $table->timestamps();

            // 🔗 Relaciones (si existen)
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('tecnico_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('set null');
        });
    }

    public function down(): void {
        Schema::dropIfExists('requerimientos');
    }
};
