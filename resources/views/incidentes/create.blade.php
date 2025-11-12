@extends('layouts.app')

@section('content')
<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-lg-12">
        <br><br/>
        <div class="card card-rounded shadow-sm border-0">
          <div class="card-body">
            <h4 class="card-title mb-3 text-primary">
              <i class="mdi mdi-alert-circle-outline me-2"></i> Registrar nuevo incidente
            </h4>

            <form method="POST" action="{{ route('incidentes.store') }}">
              @csrf

              {{-- Código --}}
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Código del incidente</label>
                  <input type="text" class="form-control" value="{{ $nuevoCodigo }}" readonly>
                </div>

                <div class="col-md-6 mb-3">
                  <label class="form-label">Tipo de incidente</label>
                  <select name="codigo" id="codigo" class="form-select" required>
                    <option value="">-- Seleccione un tipo de incidente --</option>
                    @foreach($tiposIncidentes as $tipo)
                      <option value="{{ $tipo->CODIGO }}">{{ $tipo->CODIGO }} - {{ $tipo->nombre_caso }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              {{-- Descripción --}}
              <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control" rows="3"></textarea>
              </div>

              {{-- Estado, prioridad, técnico --}}
              <div class="row">
                <div class="col-md-4 mb-3">
                  <label class="form-label">Estado</label>
                  <input type="text" name="estado" class="form-control" value="Pendiente" readonly>
                </div>
                <div class="col-md-4 mb-3">
                  <label class="form-label">Prioridad</label>
                  <select name="prioridad" class="form-select" required>
                    <option value="Alta">Alta</option>
                    <option value="Media">Media</option>
                    <option value="Baja">Baja</option>
                  </select>
                </div>
                <div class="col-md-4 mb-3">
                  <label class="form-label">Técnico disponible</label>
                  <select name="tecnico_id" class="form-select" required>
                    <option value="">-- Seleccione un técnico --</option>
                    @foreach($tecnicos as $tecnico)
                      <option value="{{ $tecnico->id }}">{{ $tecnico->name }} {{ $tecnico->LastName }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              {{-- Fecha --}}
              <div class="mb-3">
                <label class="form-label">Fecha de reporte</label>
                <input type="date" name="fecha_reporte" class="form-control" required>
              </div>

              {{-- Botones --}}
              <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary me-2">
                  <i class="mdi mdi-content-save"></i> Guardar
                </button>
                <a href="{{ route('incidentes.index') }}" class="btn btn-secondary">
                  <i class="mdi mdi-cancel"></i> Cancelar
                </a>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
@endsection
