@extends('layouts.app')

@section('content')
<div class="container-fluid page-body-wrapper">
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="card card-rounded">
            <div class="card-body">
              <h4 class="card-title mb-3">Registrar nuevo incidente</h4>

              <form method="POST" action="{{ route('incidentes.store') }}">
                @csrf

                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Código</label>
                    <input type="text" name="codigo" class="form-control" required>
                  </div>

                  <div class="col-md-6 mb-3">
                    <label class="form-label">Título</label>
                    <input type="text" name="titulo" class="form-control" required>
                  </div>
                </div>

                <div class="mb-3">
                  <label class="form-label">Descripción</label>
                  <textarea name="descripcion" class="form-control" rows="3"></textarea>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Estado</label>
                    <select name="estado" class="form-select" required>
                      <option value="Abierto">Abierto</option>
                      <option value="En Proceso">En Proceso</option>
                      <option value="Cerrado">Cerrado</option>
                    </select>
                  </div>

                  <div class="col-md-6 mb-3">
                    <label class="form-label">Prioridad</label>
                    <select name="prioridad" class="form-select" required>
                      <option value="Alta">Alta</option>
                      <option value="Media">Media</option>
                      <option value="Baja">Baja</option>
                    </select>
                  </div>
                </div>

                <div class="mb-3">
                  <label class="form-label">Fecha de reporte</label>
                  <input type="date" name="fecha_reporte" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('incidentes.index') }}" class="btn btn-secondary">Cancelar</a>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
