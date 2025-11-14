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
              <h4 class="card-title mb-0">Lista de Usuarios</h4>
              <a href="{{ route('usuarios.create') }}" class="btn btn-primary btn-sm">
                <i class="mdi mdi-account-plus"></i> Nuevo Usuario
              </a>
            </div>

            <p class="card-description">Usuarios registrados en el sistema</p>

            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Foto</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Teléfono</th>
                    <th>Estado</th>
                    <th>Fecha Registro</th>
                  </tr>
                </thead>
                <tbody>
                 @foreach($usuarios as $user)
<tr>
    <td class="py-1">
        <img src="{{ asset('img/B/face8.png') }}" alt="user" width="40" height="40" class="rounded-circle" />
    </td>
    <td>{{ $user->name }}</td>
    <td>{{ $user->email }}</td>
    <td>{{ $user->roleData->name ?? 'Sin rol' }}</td>
    <td>{{ $user->phone ?? '-' }}</td>

    <!-- 🌟 AQUÍ VA EL BOTÓN DE ESTADO 🌟 -->
    <td>
        <form action="{{ route('usuarios.cambiarEstado', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            @if($user->activo)
                <button class="btn btn-sm btn-success" type="submit">Activo</button>
            @else
                <button class="btn btn-sm btn-danger" type="submit">Inactivo</button>
            @endif
        </form>
    </td>

    <td>{{ $user->created_at->format('d M Y') }}</td>
</tr>
@endforeach

                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
 </div>
</div>
@endsection
