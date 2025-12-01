@extends('layouts.app')

@section('content')
<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-lg-12">
          <br>
        <br/>
        <div class="card card-rounded">
          <div class="card-body">

            {{-- Encabezado con botón --}}
            <div class="d-flex justify-content-between align-items-center mb-3">  
    <h1 class="mb-4">Inventario de Activos</h1>

             <a href="{{ route('activos.create') }}" class="btn btn-primary">
                <i class="mdi mdi-account-plus"></i> Agregar Activo
              </a>

            </div>

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
                <td>{{ $activo->categoriaInventario->nombre ?? '-' }}</td>
                <td>{{ $activo->estado }}</td>
                {{-- <td>{{ $activo->usuario->name ?? '-' }}</td> --}}
                <td>{{ $activo->usuario ? $activo->usuario->name . ' ' . $activo->usuario->LastName : '-' }}</td>

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
                            <a href="{{ route('activos.historial', $activo->id) }}" 
            class="btn btn-sm btn-info">
              Historial
          </a>

                              <!-- Mantenimiento -->
                              <a href="{{ route('historial.create', $activo->id) }}" class="btn btn-warning mb-3">
              🛠 Realizar Mantenimiento
          </a>


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
                           <option value="{{ $user->id }}">
    {{ $user->name }} {{ $user->LastName }}
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
