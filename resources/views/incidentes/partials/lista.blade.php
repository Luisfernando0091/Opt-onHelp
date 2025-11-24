<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
       {{-- <h5 class="mb-0 fw-bold">Listado de Incidentes</h5> --}}
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Código</th>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Prioridad</th>
                    <th>Usuario</th>
                    <th>Técnico</th>
                    <th>Fecha Reporte</th>
                    <th>Fecha Cierre</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse($incidentes as $incidente)
                    <tr>
                        <td>{{ $incidente->id }}</td>
                        <td class="fw-semibold text-primary">{{ $incidente->codigo }}</td>
                        <td class="fw-semibold">{{ $incidente->titulo }}</td>
                        <td>{{ Str::limit($incidente->descripcion, 50) }}</td>

                        <td>
                            <span class="badge rounded-pill 
                                @switch($incidente->estado)
                                    @case('Pendiente') bg-warning text-dark @break
                                    @case('En proceso') bg-info text-white @break
                                    @case('A la espera') bg-secondary text-white @break
                                    @case('Finalizado') bg-success text-white @break
                                    @default bg-light text-dark
                                @endswitch">
                                {{ $incidente->estado }}
                            </span>
                        </td>

                        <td>{{ ucfirst($incidente->prioridad) }}</td>
                        <td>{{ $incidente->usuario->name ?? '—' }}</td>
                        <td>{{ $incidente->tecnico->name ?? '—' }}</td>

                        <td>{{ $incidente->fecha_reporte ? \Carbon\Carbon::parse($incidente->fecha_reporte)->format('d M Y') : '—' }}</td>
                        <td>{{ $incidente->fecha_cierre ? \Carbon\Carbon::parse($incidente->fecha_cierre)->format('d M Y') : '—' }}</td>

                        <td class="text-center">

                            <a href="{{ route('incidentes.show', $incidente->id) }}" 
                               class="btn btn-info btn-sm text-white" title="Ver">
                                <i class="mdi mdi-eye"></i>
                            </a>

                            <a href="{{ route('incidentes.edit', $incidente->id) }}" 
                               class="btn btn-warning btn-sm text-white" title="Editar">
                                <i class="mdi mdi-pencil"></i>
                            </a>

                            <form action="{{ route('incidentes.destroy', $incidente->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" 
                                    onclick="return confirm('¿Eliminar este incidente?')" title="Eliminar">
                                    <i class="mdi mdi-delete"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="11" class="text-center text-muted py-3">
                            No hay incidentes registrados. <br>
                            <small>"NO SE PODRÁ DESCARGAR INFORMACIÓN."</small>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINACIÓN DEFAULT DE LARAVEL --}}
    <div class="card-footer bg-white d-flex justify-content-center py-3">
{{ $incidentes->links('pagination::bootstrap-5') }}
    </div>
    <style>
    /* Ocultar el texto: Showing X to Y of Z results */
    .small.text-muted {
        display: none !important;
    }
</style>

      </div>
</div>
