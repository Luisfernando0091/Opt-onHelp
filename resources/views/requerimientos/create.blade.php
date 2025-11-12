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
              <i class="mdi mdi-file-plus-outline me-2"></i> Registrar nuevo requerimiento
            </h4>

            <form method="POST" action="{{ route('requerimientos.store') }}">
              @csrf

              <div class="row">
                {{-- Código del requerimiento --}}
                <div class="col-md-6 mb-3">
                  <label class="form-label">Código del requerimiento</label>
                  <input type="text" class="form-control" value="{{ $nuevoCodigo }}" readonly>
                </div>

                {{-- Categoría --}}
                <div class="col-md-6 mb-3">
                  <label class="form-label">Tipo de requerimiento</label>
                 <select name="codigo" id="codigo" class="form-select" required>
  <option value="">-- Seleccione un requerimiento --</option>
  @foreach($tiposRequerimientos as $tipo)
    <option value="{{ $tipo->CODIGO }}">{{ $tipo->nombre_caso }}</option>
  @endforeach
</select>

                </div>
              </div>

              </div>

              {{-- Título --}}
              {{-- <div class="mb-3">
                <label class="form-label">Título</label>
                <input type="text" name="titulo" class="form-control" placeholder="Ingrese el título del requerimiento" required>
              </div> --}}

              {{-- Descripción --}}
              <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control" rows="3" placeholder="Describa el requerimiento..." required></textarea>
              </div>

              {{-- Estado, prioridad y técnico --}}
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
                  <label class="form-label">Técnico asignado</label>
                  <select name="tecnico_id" class="form-select">
                    <option value="">-- Seleccione un técnico --</option>
                    @foreach($tecnicos as $tecnico)
                      <option value="{{ $tecnico->id }}">
                        {{ $tecnico->name }} {{ $tecnico->LastName }}
                      </option>
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
                <a href="{{ route('requerimientos.index') }}" class="btn btn-secondary">
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
@endsection
