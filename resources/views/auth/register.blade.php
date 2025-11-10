@extends('layouts.app')

@section('content')
<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
     <div class="col-lg-12">

      <div class="card">
        <div class="card-header">{{ __('Registrar Usuario') }}</div>

        <div class="card-body">
          <form method="POST" action="{{ route('usuarios.store') }}">
            @csrf

            {{-- Nombre --}}
            <div class="row mb-3">
              <label for="name" class="col-md-4 col-form-label text-md-end">Nombre</label>
              <div class="col-md-6">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                       name="name" value="{{ old('name') }}" required autocomplete="given-name" autofocus>
                @error('name')
                  <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
              </div>
            </div>

            {{-- Apellido --}}
            <div class="row mb-3">
              <label for="LastName" class="col-md-4 col-form-label text-md-end">Apellido</label>
              <div class="col-md-6">
                <input id="LastName" type="text" class="form-control @error('LastName') is-invalid @enderror"
                       name="LastName" value="{{ old('LastName') }}" required autocomplete="family-name">
                @error('LastName')
                  <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
              </div>
            </div>

            {{-- Rol --}}
            <div class="row mb-3">
              <label for="role" class="col-md-4 col-form-label text-md-end">Rol</label>
              <div class="col-md-6">
                <select id="role" name="role" class="form-select @error('role') is-invalid @enderror" required>
                  <option value="">-- Seleccione un rol --</option>
                  @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                      {{ ucfirst($role->name) }}
                    </option>
                  @endforeach
                </select>
                @error('role')
                  <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
              </div>
            </div>

            {{-- Email --}}
            <div class="row mb-3">
              <label for="email" class="col-md-4 col-form-label text-md-end">Correo</label>
              <div class="col-md-6">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                       name="email" value="{{ old('email') }}" required autocomplete="email">
                @error('email')
                  <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
              </div>
            </div>

            {{-- Contraseña --}}
            <div class="row mb-3">
              <label for="password" class="col-md-4 col-form-label text-md-end">Contraseña</label>
              <div class="col-md-6">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                       name="password" required autocomplete="new-password">
                @error('password')
                  <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
              </div>
            </div>

            {{-- Confirmar contraseña --}}
            <div class="row mb-3">
              <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Confirmar Contraseña</label>
              <div class="col-md-6">
                <input id="password-confirm" type="password" class="form-control"
                       name="password_confirmation" required autocomplete="new-password">
              </div>
            </div>

            <div class="row mb-0">
              <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">Registrar</button>
              </div>
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
