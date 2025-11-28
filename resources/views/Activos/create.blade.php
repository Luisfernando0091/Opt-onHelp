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
              <i class="mdi mdi-desktop-classic me-2"></i> Registrar nuevo Activo
            </h4>

            <form action="{{ route('activos.store') }}" method="POST">
              @csrf

              <div class="row">

                {{-- Nombre --}}
                <div class="col-md-6 mb-3">
                  <label class="form-label">Nombre <span class="text-danger">*</span></label>
                  <input type="text" name="nombre" class="form-control" required>
                </div>

                {{-- Tipo --}}
                <div class="col-md-6 mb-3">
                  <label class="form-label">Tipo <span class="text-danger">*</span></label>
                  <input type="text" name="tipo" class="form-control" required>
                </div>

                {{-- Marca --}}
                <div class="col-md-6 mb-3">
                  <label class="form-label">Marca</label>
                  <input type="text" name="marca" class="form-control">
                </div>

                {{-- Modelo --}}
                <div class="col-md-6 mb-3">
                  <label class="form-label">Modelo</label>
                  <input type="text" name="modelo" class="form-control">
                </div>

                {{-- Serial --}}
                <div class="col-md-6 mb-3">
                  <label class="form-label">Serial <span class="text-danger">*</span></label>
                  <input type="text" name="serial" class="form-control" required>
                </div>

                {{-- Categoría --}}
<select name="categoria" class="form-control" required>
    <option value="">Seleccione categoría</option>
    @foreach ($categorias_inventario as $cat)
        <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
    @endforeach
</select>




                {{-- Característica --}}
                <div class="col-md-12 mb-3">
                  <label class="form-label">Característica</label>
                  <input type="text" name="caracteristica" class="form-control">
                </div>

                {{-- Descripción --}}
                <div class="col-md-12 mb-3">
                  <label class="form-label">Descripción</label>
                  <textarea name="descripcion" class="form-control" rows="3"></textarea>
                </div>

                {{-- Estado --}}
                <div class="col-md-4 mb-3">
                  <label class="form-label">Estado</label>
                  <select name="estado" class="form-select">
                    <option value="Disponible" selected>Disponible</option>
                    <option value="Asignado">Asignado</option>
                    <option value="Mantenimiento">Mantenimiento</option>
                  </select>
                </div>

                   <div class="col-md-4 mb-3">
                  <label class="form-label">Ubicacion</label>
<select name="ubicacion_id" class="form-control" required>
    <option value="">Seleccione ubicación</option>
    @foreach ($ubicaciones as $ubicacion)
        <option value="{{ $ubicacion->id }}">{{ $ubicacion->nombre }}</option>
    @endforeach
</select>
</div>
                {{-- Asignado a --}}
                <div class="col-md-8 mb-3">
                  <label class="form-label">Asignado a</label>
                  <select name="asignado_a" class="form-select">
                    <option value="">-- Ninguno --</option>
                   
        @foreach($usuarios as $usuario)
            <option value="{{ $usuario->id }}">
                {{ $usuario->name }} {{ $usuario->LastName }}
            </option>
        @endforeach
                  </select>
                </div>

              </div>

              {{-- Botones --}}
              <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-primary me-2">
                  <i class="mdi mdi-content-save"></i> Guardar
                </button>
                <a href="{{ route('activos.index') }}" class="btn btn-secondary">
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
  </div>
@endsection
