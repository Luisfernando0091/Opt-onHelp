
<table class="table table-hover table-bordered align-middle">
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
      <td>{{ $incidente->codigo }}</td>
      <td>{{ $incidente->titulo }}</td>
      <td>{{ Str::limit($incidente->descripcion, 50) }}</td>
      <td>
        <span class="badge 
          {{ $incidente->estado === 'Abierto' ? 'bg-success' : 
             ($incidente->estado === 'Cerrado' ? 'bg-secondary' : 'bg-warning') }}">
          {{ $incidente->estado }}
        </span>
      </td>
      <td>{{ ucfirst($incidente->prioridad) }}</td>
      <td>{{ $incidente->usuario->name ?? '—' }}</td>
      <td>{{ $incidente->tecnico->name ?? '—' }}</td>
      <td>{{ \Carbon\Carbon::parse($incidente->fecha_reporte)->format('d M Y') }}</td>
      <td>{{ $incidente->fecha_cierre ? \Carbon\Carbon::parse($incidente->fecha_cierre)->format('d M Y') : '—' }}</td>
      <td>
        <a href="{{ route('incidentes.show', $incidente->id) }}" class="btn btn-info btn-sm text-white">
          <i class="mdi mdi-eye"></i>
        </a>
        <a href="{{ route('incidentes.edit', $incidente->id) }}" class="btn btn-warning btn-sm text-white">
          <i class="mdi mdi-pencil"></i>
        </a>
        <form action="{{ route('incidentes.destroy', $incidente->id) }}" method="POST" class="d-inline">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este incidente?')">
            <i class="mdi mdi-delete"></i>
          </button>
        </form>
      </td>
    </tr>
    @empty
    <tr>
      <td colspan="11" class="text-center text-muted py-3">
        No hay incidentes registrados.
      </td>
    </tr>
    @endforelse
  </tbody>
</table>

</div>

        </div>
      </div>
    </div>
  </div>
</div>
</div>