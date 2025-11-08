@extends('layouts.app')

@section('content')

  
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="row">
          <div class="col-lg-12">
            <div class="card card-rounded">
              <div class="card-body">
                            <h4 class="card-title mb-3">Registrar nuevo incidente</h4>
                               <form method="POST" action="{{ route('incidentes.store') }}">
                @csrf
              <h4 class="card-title">Lista de Usuarios</h4>
              <p class="card-description">Usuarios registrados en el sistema</p>

              <div class="table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th> Foto </th>
                      <th> Nombre </th>
                      <th> Email </th>
                      <th> Rol </th>
                      <th> Teléfono </th>
                      <th> Estado </th>
                      <th> Fecha Registro </th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($usuarios as $user)
                      <tr>
                        <td class="py-1">
                          <img src="{{ asset('img/B/face8.png') }}"
                          alt="user" width="40" height="40" class="rounded-circle" alt="user" />
                        </td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->roleData->name ?? 'Sin rol' }}</td>
                        <td>{{ $user->phone ?? '-' }}</td>
                        <td>
                          @if($user->activo)
                            <label class="badge badge-success">Activo</label>
                          @else
                            <label class="badge badge-danger">Inactivo</label>
                          @endif
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



@endsection
