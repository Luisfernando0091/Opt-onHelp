@extends('layouts.app')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <br/><br/>

                <div class="card card-rounded shadow-sm border-0">
                    <div class="card-body">

                        <h4 class="mb-3">Historial del Activo</h4>

                        {{-- Información del activo --}}
                        <div class="mb-4">
                            <p><strong>Activo:</strong> {{ $activo->nombre }}</p>
                            <p><strong>Serie:</strong> {{ $activo->serial }}</p>
                            <p><strong>Marca:</strong> {{ $activo->marca }}</p>
                              <p><strong>Estado:</strong> {{ $activo->estado }}</p>
                                <p><strong>Ubicación:</strong> {{ $activo->ubicacion->nombre ?? 'Sin ubicación' }}</p>
{{-- <p><strong>Asignado:</strong> {{ $activo->usuario->name ?? 'Sin asignar' }}</p> --}}
<p><strong>Asignado:</strong> 
    {{ trim(($activo->usuario->name ?? '') . ' ' . ($activo->usuario->lastname ?? '')) ?: 'Sin asignar' }}
</p>

                        </div>

                        {{-- Botón de mantenimiento --}}
                        <a href="{{ route('historial.create', $activo->id) }}" 
                           class="btn btn-warning mb-3">
                            🛠 Realizar Mantenimiento
                        </a>

                        <hr>

                        {{-- Tabla de historial --}}
                        @if($activo->historial->isEmpty())
                            <p class="text-center text-muted">Sin historial registrado.</p>
                        @else
                            <table class="table table-striped table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Usuario</th>
                                        <th>Acción</th>
                                        <th>Observación</th>
                                        <th>Nombre</th>
                                        <th>Marca</th>
                                        <th>Serial</th>
                                        <th>Estado</th>
                                        <th>Cambio de piesas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($activo->historial as $h)
                                    <tr>
                                        <td>{{ $h->created_at->format('d/m/Y H:i') }}</td>
                                        <td>{{ $h->usuario->name ?? 'Sistema' }}</td>
                                        <td>{{ $h->accion }}</td>
                                        <td>{{ $h->observacion }}</td>
                                        <td>{{ $h->activo->nombre }}</td>
                                        <td>{{ $h->activo->marca }}</td>
                                        <td>{{ $h->activo->serial }}</td>
                                        <td>{{ $h->activo->estado }}</td>
                                        <td>{{ $h->pieza->nombre ?? '—' }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
</div>

@endsection
