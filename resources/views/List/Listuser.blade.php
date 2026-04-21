@extends('layouts.app')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12">

                <div class="card card-rounded shadow-sm">
                    <div class="card-body">

                        {{-- ENCABEZADO --}}
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h4 class="card-title mb-0">Lista de Usuarios CD</h4>
                                <small class="text-muted">Usuarios registrados en el sistema</small>
                            </div>

                            <a href="{{ route('usuarios.create') }}" class="btn btn-primary btn-sm">
                                <i class="mdi mdi-account-plus"></i> Nuevo Usuario
                            </a>
                        </div>

                        {{-- TABLA --}}
                        <div class="table-responsive mt-4">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr class="text-center">
                                        <th>Foto</th>
                                        <th class="text-start">Nombre</th>
                                        <th class="text-start">Apellido</th>
                                        <th class="text-start">Email</th>
                                        <th>Estado</th>
                                        <th>Fecha Registro</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>

                                <tbody>
                                @foreach($usuarios as $user)
                                    <tr class="text-center">

                                        {{-- FOTO --}}
                                        <td>
                                            <img
                                                src="{{ asset('img/B/face8.png') }}"
                                                alt="usuario"
                                                width="42"
                                                height="42"
                                                class="rounded-circle shadow-sm">
                                        </td>

                                        {{-- DATOS --}}
                                        <td class="text-start fw-semibold">
                                            {{ $user->name }}
                                        </td>

                                        <td class="text-start">
                                            {{ $user->LastName }}
                                        </td>

                                        <td class="text-start text-muted">
                                            {{ $user->email }}
                                        </td>

                                        {{-- ESTADO --}}
                                        <td>
                                            @if($user->activo)
                                                <span class="badge bg-success px-3 py-2">Activo</span>
                                            @else
                                                <span class="badge bg-danger px-3 py-2">Inactivo</span>
                                            @endif
                                        </td>

                                        {{-- FECHA --}}
                                        <td>
                                            <small class="text-muted">
                                                {{ $user->created_at->format('d M Y') }}
                                            </small>
                                        </td>

                                        {{-- ACCIONES --}}
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">

                                                {{-- CAMBIAR ESTADO --}}
                                                <form action="{{ route('usuarios.cambiarEstado', $user->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button
                                                        type="submit"
                                                        class="btn btn-outline-secondary btn-sm"
                                                        title="Cambiar estado">
                                                        <i class="mdi mdi-sync"></i>
                                                    </button>
                                                </form>

                                                {{-- EDITAR --}}
                                                <a
                                                    href="{{ route('usuarios.edit', $user->id) }}"
                                                    class="btn btn-outline-primary btn-sm"
                                                    title="Editar usuario">
                                                    <i class="mdi mdi-pencil"></i>
                                                </a>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- PAGINACIÓN --}}
                        <div class="d-flex justify-content-center mt-4">
                            {{ $usuarios->onEachSide(1)->links('pagination::bootstrap-5') }}
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
