@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detalle del Activo</h2>

    <ul class="list-group mb-3">
        <li class="list-group-item"><strong>Nombre:</strong> {{ $activo->nombre }}</li>
        <li class="list-group-item"><strong>Serie:</strong> {{ $activo->serial }}</li>
        <li class="list-group-item"><strong>Marca:</strong> {{ $activo->marca }}</li>
        <li class="list-group-item"><strong>Estado:</strong> {{ $activo->estado }}</li>
    </ul>

    <a href="{{ route('activos.historial', $activo->id) }}" class="btn btn-info">
        Ver Historial
    </a>

    <a href="{{ route('activos.index') }}" class="btn btn-secondary">
        Volver
    </a>
</div>
@endsection
