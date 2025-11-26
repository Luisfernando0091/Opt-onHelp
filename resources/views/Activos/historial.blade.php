@if($activo->historial->isEmpty())
    <p class="text-center text-muted">Sin historial registrado.</p>
@else
<table class="table table-striped">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Usuario</th>
            <th>Acción</th>
            <th>Detalle</th>
        </tr>
    </thead>
    <tbody>
        @foreach($activo->historial as $h)
        <tr>
            <td>{{ $h->created_at->format('d/m/Y H:i') }}</td>
            <td>{{ $h->usuario->name ?? 'Sistema' }}</td>
            <td>{{ $h->accion }}</td>
            <td>{{ $h->detalle }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
