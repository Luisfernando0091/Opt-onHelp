<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivosTable extends Migration
{
    public function up()
    {
        Schema::create('activos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // nombre del activo
            $table->string('tipo'); // monitor, teclado, impresora, etc.
            $table->string('marca')->nullable();
            $table->string('modelo')->nullable();
            $table->string('serial')->unique();
            $table->string('categoria')->nullable(); // categoría del activo
            $table->string('caracteristica')->nullable(); // característica específica
            $table->text('descripcion')->nullable(); // ubicación, piso, observaciones
            $table->enum('estado', ['Disponible', 'Asignado', 'Mantenimiento'])->default('Disponible');
            $table->foreignId('asignado_a')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('activos');
    }
}
