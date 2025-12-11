@extends('layouts.app')

@section('content')
<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-lg-12">
        <br><br>

        <div class="card card-rounded shadow-sm border-0">
          <div class="card-header bg-primary text-white card-rounded-top">
            <h4 class="mb-0">Editar Usuario</h4>
          </div>

          <div class="card-body">

            <form method="POST" action="{{ route('usuarios.update', $usuario->id) }}">
              @csrf
              @method('PUT')

              {{-- Nombre --}}
              <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end">Nombre</label>
                <div class="col-md-6">
                  <input type="text"
                         name="name"
                         class="form-control @error('name') is-invalid @enderror"
                         value="{{ old('name', $usuario->name) }}"
                         required>

                  @error('name')
                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                  @enderror
                </div>
              </div>

              {{-- Apellido --}}
              <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end">Apellido</label>
                <div class="col-md-6">
                  <input type="text"
                         name="LastName"
                         class="form-control @error('LastName') is-invalid @enderror"
                         value="{{ old('LastName', $usuario->LastName) }}"
                         required>

                  @error('LastName')
                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                  @enderror
                </div>
              </div>

              {{-- Email --}}
              <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end">Correo</label>
                <div class="col-md-6">
                  <input type="email"
                         name="email"
                         class="form-control @error('email') is-invalid @enderror"
                         value="{{ old('email', $usuario->email) }}"
                         required>

                  @error('email')
                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                  @enderror
                </div>
              </div>

              {{-- Rol --}}
              <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end">Rol</label>
                <div class="col-md-6">
                  <select name="role"
                          class="form-select @error('role') is-invalid @enderror"
                          required>

                    @foreach($roles as $role)
                      <option value="{{ $role->name }}"
                             {{ optional($usuario->roles->first())->name == $role->name ? 'selected' : '' }}
>
                        {{ ucfirst($role->name) }}
                      </option>
                    @endforeach
                  </select>

                  @error('role')
                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                  @enderror
                </div>
              </div>

              {{-- Botón --}}
              <div class="row mb-0">
                <div class="col-md-6 offset-md-4">
                  <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
                  <a href="{{ route('usuarios.index') }}" class="btn btn-secondary ms-2">Cancelar</a>
                </div>
              </div>

            </form>

          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
