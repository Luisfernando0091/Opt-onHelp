@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">

    <h1 class="text-2xl font-bold mb-4">Agregar Nuevo Activo</h1>

    <form action="{{ route('activos.store') }}" method="POST" class="space-y-4 bg-white p-6 rounded shadow">
        @csrf

        <div>
            <label class="block font-medium">Nombre <span class="text-red-500">*</span></label>
            <input type="text" name="nombre" class="border p-2 w-full" required>
        </div>

        <div>
            <label class="block font-medium">Tipo <span class="text-red-500">*</span></label>
            <input type="text" name="tipo" class="border p-2 w-full" required>
        </div>

        <div>
            <label class="block font-medium">Marca</label>
            <input type="text" name="marca" class="border p-2 w-full">
        </div>

        <div>
            <label class="block font-medium">Modelo</label>
            <input type="text" name="modelo" class="border p-2 w-full">
        </div>

        <div>
            <label class="block font-medium">Serial <span class="text-red-500">*</span></label>
            <input type="text" name="serial" class="border p-2 w-full" required>
        </div>

        <div>
            <label class="block font-medium">Categoría</label>
            <input type="text" name="categoria" class="border p-2 w-full">
        </div>

        <div>
            <label class="block font-medium">Característica</label>
            <input type="text" name="caracteristica" class="border p-2 w-full">
        </div>

        <div>
            <label class="block font-medium">Descripción</label>
            <textarea name="descripcion" class="border p-2 w-full" rows="3"></textarea>
        </div>

        <div>
            <label class="block font-medium">Estado</label>
            <select name="estado" class="border p-2 w-full">
                <option value="Disponible" selected>Disponible</option>
                <option value="Asignado">Asignado</option>
                <option value="Mantenimiento">Mantenimiento</option>
            </select>
        </div>

        <div>
            <label class="block font-medium">Asignado a</label>
            <select name="asignado_a" class="border p-2 w-full">
                <option value="">-- Ninguno --</option>
                @foreach($usuarios as $usuario)
                    <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Guardar</button>
        </div>

    </form>
</div>
@endsection
