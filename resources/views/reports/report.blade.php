@extends('layouts.app')

@section('content')
<div class="main-panel">
  <div class="content-wrapper">

    <div class="row">
      <div class="col-lg-12">

        <div class="card card-rounded shadow-sm">
          <div class="card-body">

            {{-- 🔍 FILTROS Y OPCIONES --}}
            <h4 class="mb-4 fw-bold">Reporte de Tickets</h4>

            <form method="GET" action="{{ route('reportes.incidentes') }}" class="mb-4">
              <div class="row g-3">

                <div class="col-md-3">
                  <label class="form-label">Desde</label>
                  <input type="date" name="fecha_desde" class="form-control form-control-sm"
                         value="{{ request('fecha_desde') }}">
                </div>

                <div class="col-md-3">
                  <label class="form-label">Hasta</label>
                  <input type="date" name="fecha_hasta" class="form-control form-control-sm"
                         value="{{ request('fecha_hasta') }}">
                </div>

                {{-- <div class="col-md-3">
                  <label class="form-label">Mes</label>
                  <select name="mes" class="form-select form-select-sm">
                    <option value="">-- Todos los meses --</option>
                    @foreach (range(1,12) as $m)
                      <option value="{{ $m }}" {{ request('mes') == $m ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                      </option>
                    @endforeach
                  </select>
                </div> --}}

                <div class="col-md-3">
                  <label class="form-label">Tipo de Ticket</label>
                  <select name="tipo" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="incidente" {{ $tipo == 'incidente' ? 'selected' : '' }}>Incidente</option>
                    <option value="requerimiento" {{ $tipo == 'requerimiento' ? 'selected' : '' }}>Requerimiento</option>
                  </select>
                </div>

                <div class="col-12 d-flex justify-content-between mt-2">
                  <div>
                    <button type="submit" class="btn btn-primary btn-sm">
                      <i class="mdi mdi-filter"></i> Filtrar
                    </button>
                    <a href="{{ route('reportes.incidentes') }}" class="btn btn-secondary btn-sm">
                      <i class="mdi mdi-refresh"></i> Limpiar
                    </a>
                  </div>

                 <div>
    <a href="{{ route('incidentes.export.pdf', array_merge(request()->all(), ['tipo' => request('tipo')])) }}" 
      class="btn btn-danger btn-sm">
      <i class="mdi mdi-file-pdf"></i> PDF
    </a>

    <a href="{{ route('incidentes.export.excel', array_merge(request()->all(), ['tipo' => request('tipo')])) }}" 
      class="btn btn-success btn-sm">
      <i class="mdi mdi-file-excel"></i> Excel
    </a>
</div>

                </div>

              </div>
            </form>

            {{-- 🧾 TABLA --}}
              <div class="table-responsive">

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
                @forelse($data as $incidente)
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
                      ⚠️ No hay registros con los filtros seleccionados
                    </td>
                  </tr>
                @endforelse
              </tbody>

            </table>

          </div>
        </div>

      </div>
    </div>
 </div> </div>
  </div>
</div>
@endsection
