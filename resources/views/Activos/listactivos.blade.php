@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Inventario de Activos</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Marca</th>
                <th>Serial</th>
                <th>Categoría</th>
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
                <td>{{ $activo->categoria }}</td>
                <td>{{ $activo->estado }}</td>
                <td>{{ $activo->usuario->name ?? '-' }}</td>
                <td>

                    <!-- Asignar -->
                    <button class="btn btn-sm btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#asignarModal"
                        data-id="{{ $activo->id }}"
                        data-nombre="{{ $activo->nombre }}">
                        Asignar
                    </button>

                    <!-- Historial -->
                    <button class="btn btn-sm btn-secondary"
                        data-bs-toggle="modal"
                        data-bs-target="#historialModal"
                        data-id="{{ $activo->id }}">
                        Historial
                    </button>

                    <!-- Mantenimiento -->
                    <button class="btn btn-warning btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#mantenimientoModal"
                        data-id="{{ $activo->id }}"
                        data-nombre="{{ $activo->nombre }}">
                        Mantenimiento
                    </button>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


{{-- ====================================== --}}
{{-- ========== MODAL ASIGNAR ============= --}}
{{-- ====================================== --}}
<div class="modal fade" id="asignarModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="asignarForm" method="POST" action="">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Asignar Activo</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <div class="modal-body">
            <input type="hidden" name="activo_id" id="activo_id">

            <div class="mb-3">
                <label for="user_id" class="form-label">Usuario</label>
                <select name="user_id" id="user_id" class="form-select">
                    @foreach($usuarios as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Observación</label>
                <textarea name="observacion" class="form-control"></textarea>
            </div>
          </div>

          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Asignar</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          </div>
        </div>
    </form>
  </div>
</div>


{{-- ====================================== --}}
{{-- ========== MODAL HISTORIAL =========== --}}
{{-- ====================================== --}}
<div class="modal fade" id="historialModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Historial del Activo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="historialBody">
        Cargando historial...
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


{{-- ====================================== --}}
{{-- ======= MODAL MANTENIMIENTO ========== --}}
{{-- ====================================== --}}
<div class="modal fade" id="mantenimientoModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="mantenimientoForm" method="POST" action="">
        @csrf
        <input type="hidden" id="m_activo_id" name="activo_id">

        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Mantenimiento</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <div class="modal-body">
            <label class="form-label">Detalle del mantenimiento:</label>
<textarea class="form-control" name="observacion" required></textarea>
          </div>

          <div class="modal-footer">
            <button type="submit" class="btn btn-warning">Guardar</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          </div>
        </div>

    </form>
  </div>
</div>

@endsection


@section('scripts')
<script>
    // Modal asignar
    document.getElementById('asignarModal').addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var nombre = button.getAttribute('data-nombre');
        this.querySelector('#activo_id').value = id;
        this.querySelector('.modal-title').textContent = 'Asignar: ' + nombre;
        this.querySelector('#asignarForm').action = '/activo/' + id + '/asignar';
    });


    // Modal historial
    document.getElementById('historialModal').addEventListener('show.bs.modal', function (event) {
        var id = event.relatedTarget.getAttribute('data-id');
        var body = this.querySelector('#historialBody');
        body.innerHTML = 'Cargando...';

        fetch('/activo/' + id + '/historial')
            .then(response => response.text())
            .then(html => body.innerHTML = html);
    });


    // Modal mantenimiento
    document.getElementById('mantenimientoModal').addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var nombre = button.getAttribute('data-nombre');
        this.querySelector('#m_activo_id').value = id;
        this.querySelector('.modal-title').textContent = 'Mantenimiento: ' + nombre;
        this.querySelector('#mantenimientoForm').action = '/activo/' + id + '/mantenimiento';
    });
</script>
@endsection
