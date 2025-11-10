@extends('layouts.app')

@section('content')
<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-lg-12">
        <div class="card card-rounded">

          {{-- 🔍 Filtros de búsqueda --}}
                      {{-- <h4 class="card-title mb-0">Lista de Tickets generados</h4> --}}


          {{-- 🧾 Tabla de resultados --}}
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                  <form method="GET" action="{{ route('reportes.incidentes') }}" class="row g-3 mb-4">
            <div class="col-md-3">
              <label for="fecha_desde" class="form-label">Desde</label>
              <input type="date" name="fecha_desde" id="fecha_desde" class="form-control"
                     value="{{ request('fecha_desde') }}">
            </div>

            <div class="col-md-3">
              <label for="fecha_hasta" class="form-label">Hasta</label>
              <input type="date" name="fecha_hasta" id="fecha_hasta" class="form-control"
                     value="{{ request('fecha_hasta') }}">
            </div>

            <div class="col-md-3">
              <label for="mes" class="form-label">Filtrar por mes</label>
              <select name="mes" id="mes" class="form-select">
                <option value="">-- Todos los meses --</option>
                @foreach (range(1,12) as $m)
                  <option value="{{ $m }}" {{ request('mes') == $m ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                  </option>
                @endforeach
              </select>
            </div>

            <div class="col-md-3 d-flex align-items-end gap-2">
              <button type="submit" class="btn btn-primary btn-sm">
                <i class="mdi mdi-filter"></i> Filtrar
              </button>
              <a href="{{ route('reportes.incidentes') }}" class="btn btn-secondary btn-sm">
                <i class="mdi mdi-refresh"></i> Limpiar
              </a>
            </div>
          </form>
              <div class="d-flex gap-2">
<a href="{{ route('incidentes.export.pdf', request()->only(['fecha_desde', 'fecha_hasta', 'mes'])) }}" 
   class="btn btn-danger btn-sm">
  <i class="mdi mdi-file-pdf me-1"></i> Exportar PDF
</a>

<a href="{{ route('incidentes.export.excel', request()->only(['fecha_desde', 'fecha_hasta', 'mes'])) }}" 
   class="btn btn-success btn-sm">
  <i class="mdi mdi-file-excel me-1"></i> Exportar Excel
</a>


{{-- <a href="{{ route('incidentes.export.excel', request()->only(['fecha_desde', 'fecha_hasta', 'mes'])) }}" 
   class="btn btn-success btn-sm">
  <i class="mdi mdi-file-excel me-1"></i> Excel
</a> --}}

              </div>
            </div>

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
                  </tr>
                @empty
                  <tr>
                    <td colspan="10" class="text-center text-muted py-3">
                      No hay incidentes registrados 
                      <p>
                      </p>
                      ⚠️⚠️ No se podra descargar archivos⚠️⚠️
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div> <!-- /.card-body -->

        </div> <!-- /.card -->
      </div> <!-- /.col -->
    </div> <!-- /.row -->
  </div> <!-- /.content-wrapper -->
</div> <!-- /.main-panel -->
  </div> <!-- /.content-wrapper -->
</div> <!-- /.main-panel -->
@endsection
