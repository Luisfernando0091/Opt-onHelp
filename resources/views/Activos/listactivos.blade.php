@extends('layouts.app')

@section('content')
<div class="main-panel">
  <div class="content-wrapper">

    <div class="card">
      <div class="card-body">

        <div class="d-flex justify-content-between mb-3">
          <h4>Inventario de Activos</h4>
          <a href="{{ route('activos.create') }}" class="btn btn-primary">
            + Nuevo Activo
          </a>
        </div>

        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Tipo</th>
              <th>Marca</th>
              <th>Serial</th>
              <th>Estado</th>
              <th>Asignado a</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($activos as $activo)
            <tr>
              <td>{{ $activo->nombre }}</td>
              <td>{{ $activo->tipo }}</td>
              <td>{{ $activo->marca }}</td>
              <td>{{ $activo->serial }}</td>
              <td>{{ $activo->estado }}</td>
              <td>
                {{ $activo->usuario
                    ? $activo->usuario->name.' '.$activo->usuario->LastName
                    : '-' }}
              </td>
              <td>
                <!-- ✅ BOTÓN CORRECTO BOOTSTRAP 5 -->
                <button
                  class="btn btn-sm btn-success"
                  data-bs-toggle="modal"
                  data-bs-target="#asignarModal"
                  data-id="{{ $activo->id }}"
                  data-nombre="{{ $activo->nombre }}"
                >
                  Asignar
                </button>
                 <!-- HISTORIAL -->
    <a href="{{ route('activos.historial', $activo->id) }}"
       class="btn btn-sm btn-info mb-1">
        <i class="mdi mdi-history"></i>
    </a>

    <!-- MANTENIMIENTO -->
  <a href="{{ route('historial.create', $activo->id) }}"
       class="btn btn-sm btn-warning mb-1">
        <i class="mdi mdi-tools"></i>
    </a>

              </td>
            </tr>
            @endforeach
          </tbody>
        </table>

      </div>
    </div>

  </div>
</div>

<!-- ================= MODAL ASIGNAR ================= -->
<div class="modal fade" id="asignarModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" id="asignarForm">
      @csrf

      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Asignar activo</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">

          <div class="mb-3">
            <label class="form-label">Asignar a usuario</label>
            <select name="asignado_a" class="form-control" required>
              <option value="">Seleccione usuario</option>
              @foreach($usuarios as $usuario)
                <option value="{{ $usuario->id }}">
                  {{ $usuario->name }} {{ $usuario->LastName }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Observación</label>
            <textarea name="observacion" class="form-control"></textarea>
          </div>

        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Asignar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            Cancelar
          </button>
        </div>
      </div>
    </form>
  </div>
</div>
 </div> </div>
@endsection

@push('scripts')
<script>
document.getElementById('asignarModal')
  .addEventListener('show.bs.modal', function (event) {

    const button = event.relatedTarget
    const id = button.getAttribute('data-id')
    const nombre = button.getAttribute('data-nombre')

    this.querySelector('.modal-title').textContent =
      'Asignar: ' + nombre

    document.getElementById('asignarForm')
      .action = '/activos/' + id + '/asignar'
})
</script>
@endpush
