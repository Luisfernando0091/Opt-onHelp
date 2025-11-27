@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Registrar Mantenimiento</h3>
    <hr>

    <p><strong>Activo:</strong> {{ $activo->nombre }}</p>
    <p><strong>Serie:</strong> {{ $activo->serial }}</p>
    <p><strong>Marca:</strong> {{ $activo->marca }}</p>

    <form action="{{ route('historial.store', $activo->id) }}" method="POST">
        @csrf

        <div class="mb-3">
         <div class="form-group">
    <label for="observacion">Observación del mantenimiento</label>
    <textarea name="observacion" id="observacion" class="form-control" required></textarea>
</div>

        <button class="btn btn-primary">Guardar</button>
        <a href="{{ route('historial.activos.create', $activo->id) }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</div>
</div>
@endsection
