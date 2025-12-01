@extends('layouts.app')

@section('content')
<div class="main-panel">
  <div class="content-wrapper">

    <div class="card shadow-sm border-0">
      <div class="card-body">

        {{-- Encabezado --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h2 class="fw-bold mb-0 text-primary">Inventario de Activos</h2>
        </div>

        {{-- FILTROS --}}
<form method="GET" action="{{ route('activos.wies') }}" class="row g-3 mb-4">

  <div class="col-md-4">
    <label class="form-label fw-semibold">Categoría</label>
    <select name="categoria_id" class="form-select">
      <option value="">Todas</option>
      @foreach($categorias as $categoria)
        <option value="{{ $categoria->id }}" 
          {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
          {{ $categoria->nombre }}
        </option>
      @endforeach
    </select>
  </div>

  <div class="col-md-4">
    <label class="form-label fw-semibold">Ubicación</label>
    <select name="ubicacion_id" class="form-select">
      <option value="">Todas</option>
      @foreach($ubicaciones as $ubicacion)
        <option value="{{ $ubicacion->id }}" 
          {{ request('ubicacion_id') == $ubicacion->id ? 'selected' : '' }}>
          {{ $ubicacion->nombre }}
        </option>
      @endforeach
    </select>
  </div>

  <div class="col-md-4 d-flex align-items-end">
    <button type="submit" class="btn btn-primary w-100">
      Filtrar
    </button>
  </div>
</form>

        {{-- Tabla --}}
        <div class="table-responsive">
          <table class="table table-hover align-middle text-center">
            <thead class="table-primary text-dark">
              <tr>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Marca</th>
                <th>Serial</th>
                <th>Categoría</th>
                <th>Estado</th>
                <th>Asignado a</th>
                <th>Ubicación</th>
              </tr>
            </thead>

            <tbody>
              @foreach($activos as $activo)
              <tr>
                <td class="fw-semibold">{{ $activo->nombre }}</td>
                <td>{{ $activo->tipo }}</td>
                <td>{{ $activo->marca }}</td>
                <td>{{ $activo->serial }}</td>
                <td>{{ $activo->categoriaInventario->nombre ?? '-' }}</td>

                {{-- Estado con badge --}}
                <td>
                  @php
                    $estadoColor = match($activo->estado) {
                      'Asignado' => 'success',
                      'Disponible' => 'primary',
                      'Baja' => 'danger',
                      default => 'secondary'
                    };
                  @endphp

                  <span class="badge bg-{{ $estadoColor }} px-3 py-2">
                    {{ $activo->estado }}
                  </span>
                </td>

                <td>{{ $activo->usuario ? $activo->usuario->name . ' ' . $activo->usuario->LastName : '-' }}</td>

                <td>{{ $activo->ubicacion->nombre ?? '-' }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

      </div>
    </div>

  </div>
  </div>
  
</div>
@endsection
