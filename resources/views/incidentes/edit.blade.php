@extends('layouts.app')

@section('title', 'Editar Incidente')

@section('content')
<div class="main-panel">
  <div class="content-wrapper">
    <div class="row justify-content-center">
      <div class="col-lg-12">
          <br>
        <br/>
        <div class="card card-rounded shadow border-0">
          
          {{-- 🔹 Encabezado --}}
          <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i> Editar Incidente</h5>
            <a href="{{ route('incidentes.index') }}" class="btn btn-light btn-sm">
              <i class="bi bi-arrow-left"></i> Volver
            </a>
          </div>

          {{-- 🔹 Formulario --}}
          <div class="card-body">
            <form action="{{ route('incidentes.update', $incidente->id) }}" method="POST">
              @csrf
              @method('PUT')

              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="codigo" class="form-label fw-bold">Código</label>
                  <input type="text" class="form-control" value="{{ $incidente->codigo }}" disabled>
                </div>
                <div class="col-md-6">
                  <label for="titulo" class="form-label fw-bold">Título</label>
                  <input type="text" name="titulo" id="titulo" 
                         class="form-control @error('titulo') is-invalid @enderror"
                         value="{{ old('titulo', $incidente->titulo) }}">
                  @error('titulo')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <div class="mb-3">
                <label for="descripcion" class="form-label fw-bold">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="3"
                          class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion', $incidente->descripcion) }}</textarea>
                @error('descripcion')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="row mb-3">
                <div class="col-md-4">
                  <label for="estado" class="form-label fw-bold">Estado</label>
                  <select name="estado" id="estado" class="form-select">
                    <option value="Pendiente" {{ $incidente->estado == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="En proceso" {{ $incidente->estado == 'En proceso' ? 'selected' : '' }}>En proceso</option>
                    <option value="A la espera" {{ $incidente->estado == 'A la espera' ? 'selected' : '' }}>A la espera</option>
                    <option value="Finalizado" {{ $incidente->estado == 'Finalizado' ? 'selected' : '' }}>Finalizado</option>
                  </select>
                </div>

                <div class="col-md-4">
                  <label for="prioridad" class="form-label fw-bold">Prioridad</label>
                  <select name="prioridad" id="prioridad" class="form-select">
                    <option value="Baja" {{ $incidente->prioridad == 'Baja' ? 'selected' : '' }}>Baja</option>
                    <option value="Media" {{ $incidente->prioridad == 'Media' ? 'selected' : '' }}>Media</option>
                    <option value="Alta" {{ $incidente->prioridad == 'Alta' ? 'selected' : '' }}>Alta</option>
                    <option value="Crítica" {{ $incidente->prioridad == 'Crítica' ? 'selected' : '' }}>Crítica</option>
                  </select>
                </div>

                <div class="col-md-4">
                  <label for="tecnico_id" class="form-label fw-bold">Técnico Asignado</label>
                  <select name="tecnico_id" id="tecnico_id" class="form-select">
                    <option value="">— No asignado —</option>
                    @foreach(\App\Models\User::role('tecnico')->get() as $tecnico)
                      <option value="{{ $tecnico->id }}" {{ $incidente->tecnico_id == $tecnico->id ? 'selected' : '' }}>
                        {{ $tecnico->name }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="mb-3">
                <label for="solucion" class="form-label fw-bold">Solución</label>
                <textarea name="solucion" id="solucion" rows="3"
                          class="form-control @error('solucion') is-invalid @enderror">{{ old('solucion', $incidente->solucion) }}</textarea>
                @error('solucion')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="mt-4 d-flex justify-content-end gap-2">
                <button type="submit" class="btn btn-success">
                  <i class="bi bi-check-circle"></i> Guardar Cambios
                </button>
                <a href="{{ route('incidentes.index') }}" class="btn btn-secondary">
                  <i class="bi bi-x-circle"></i> Cancelar
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
</div>
@endsection
