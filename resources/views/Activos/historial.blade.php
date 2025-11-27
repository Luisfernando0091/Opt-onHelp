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
        </tr>
    </thead>
    <tbody>
        @foreach($activo->historial as $h)
        <tr>
            <td>{{ $h->created_at->format('d/m/Y H:i') }}</td>
            <td>{{ $h->usuario->name ?? 'Sistema' }}</td>
            <td>{{ $h->accion }}</td>
            <td>{{ $h->observacion }}</td>

            {{-- Información del activo --}}
            <td>{{ $h->activo->nombre }}</td>
            <td>{{ $h->activo->marca }}</td>
            <td>{{ $h->activo->serial }}</td>
            <td>{{ $h->activo->estado }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
