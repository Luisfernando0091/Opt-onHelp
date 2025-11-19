@extends('layouts.app')

@section('title', 'Editar Requerimiento')

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
            <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i> Editar Requerimiento</h5>
            <a href="{{ route('requerimientos.index') }}" class="btn btn-light btn-sm">
              <i class="bi bi-arrow-left"></i> Volver
            </a>
          </div>

          {{-- 🔹 Formulario --}}
          <div class="card-body">
            <form action="{{ route('requerimientos.update', $requerimiento->id) }}" method="POST">
              @csrf
              @method('PUT')

              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="codigo" class="form-label fw-bold">Código</label>
                  <input type="text" class="form-control" value="{{ $requerimiento->codigo }}" disabled>
                </div>
                <div class="col-md-6">
                  <label for="titulo" class="form-label fw-bold">Requerimiento</label>
                  <input type="text" name="titulo" id="titulo" 
                         class="form-control @error('titulo') is-invalid @enderror"
                         value="{{ old('titulo', $requerimiento->titulo) }}">
                  @error('titulo')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <div class="mb-3">
                <label for="descripcion" class="form-label fw-bold">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="3"
                          class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion', $requerimiento->descripcion) }}</textarea>
                @error('descripcion')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              {{-- Si tu tabla requerimientos tiene “tipo” o “categoría” --}}
              <div class="row mb-3">
                {{-- <div class="col-md-4">
                  <label for="tipo" class="form-label fw-bold">Tipo de Requerimiento</label>
                  <select name="tipo" id="tipo" class="form-select">
                    <option value="Funcional" {{ $requerimiento->tipo == 'Funcional' ? 'selected' : '' }}>Funcional</option>
                    <option value="Técnico" {{ $requerimiento->tipo == 'Técnico' ? 'selected' : '' }}>Técnico</option>
                    <option value="Otro" {{ $requerimiento->tipo == 'Otro' ? 'selected' : '' }}>Otro</option>
                  </select>
                </div> --}}

                <div class="col-md-4">
                  <label for="estado" class="form-label fw-bold">Estado</label>
                  <select name="estado" id="estado" class="form-select">
                    <option value="Pendiente" {{ $requerimiento->estado == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="En proceso" {{ $requerimiento->estado == 'En proceso' ? 'selected' : '' }}>En proceso</option>
                    <option value="Finalizado" {{ $requerimiento->estado == 'Finalizado' ? 'selected' : '' }}>Finalizado</option>
                  </select>
                </div>

                <div class="col-md-4">
                  <label for="prioridad" class="form-label fw-bold">Prioridad</label>
                  <select name="prioridad" id="prioridad" class="form-select">
                    <option value="Baja" {{ $requerimiento->prioridad == 'Baja' ? 'selected' : '' }}>Baja</option>
                    <option value="Media" {{ $requerimiento->prioridad == 'Media' ? 'selected' : '' }}>Media</option>
                    <option value="Alta" {{ $requerimiento->prioridad == 'Alta' ? 'selected' : '' }}>Alta</option>
                  </select>
            
              </div>
                <div class="col-md-4">
                  <label for="tecnico_id" class="form-label fw-bold">Técnico Asignado</label>
                  <select name="tecnico_id" id="tecnico_id" class="form-select">
                    <option value="">— No asignado —</option>
                    @foreach(\App\Models\User::role('tecnico')->get() as $tecnico)
                      <option value="{{ $tecnico->id }}" {{ $requerimiento->tecnico_id == $tecnico->id ? 'selected' : '' }}>
                        {{ $tecnico->name }}
                      </option>
                    @endforeach
                  </select>
                </div>


              <div class="mb-3">
                <label for="solucion" class="form-label fw-bold">Detalles / Solución</label>
                <textarea name="solucion" id="solucion" rows="3"
                          class="form-control @error('solucion') is-invalid @enderror">{{ old('solucion', $requerimiento->solucion) }}</textarea>
                @error('solucion')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="mt-4 d-flex justify-content-end gap-2">
                <button type="submit" class="btn btn-success">
                  <i class="bi bi-check-circle"></i> Guardar Cambios
                </button>
                <a href="{{ route('requerimientos.index') }}" class="btn btn-secondary">
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
