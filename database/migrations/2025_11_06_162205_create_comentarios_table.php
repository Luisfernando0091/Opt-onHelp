<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('incidente_id')->constrained('incidentes')->onDelete('cascade');
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->text('comentario');
            $table->enum('tipo', ['Usuario', 'Técnico', 'Sistema'])->default('Técnico');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('comentarios');
    }
};
