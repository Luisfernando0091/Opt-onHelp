@extends('layouts.app')

@section('content')
<div class="main-panel">
  <div class="content-wrapper py-4">
    <div class="row">
      <div class="col-lg-12">
        <br>
        <br/>
        <div class="card shadow-sm border-0 rounded-4">
          <div class="card-body">
            <h4 class="fw-bold text-primary mb-4">
              <i class="mdi mdi-clipboard-list-outline me-2"></i> Lista de Requerimientos
            </h4>

            <div class="table-responsive">
              <table class="table table-hover table-bordered align-middle">
                <thead class="table-light">
                  <tr>
                    <th>ID</th>
                    <th>Código</th>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Prioridad</th>
                    <th>Usuario</th>
                    <th>Técnico</th>
                    <th>Fecha Reporte</th>
                    <th>Fecha Cierre</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($requerimientos as $req)
                  <tr>
                    <td>{{ $req->id }}</td>
                    <td>{{ $req->codigo }}</td>
                    <td>{{ $req->titulo }}</td>
                    <td>{{ Str::limit($req->descripcion, 50) }}</td>
                    <td>
                      <span class="badge 
                        @switch($req->estado)
                          @case('Pendiente') bg-warning text-dark @break
                          @case('En proceso') bg-info text-white @break
                          @case('A la espera') bg-secondary text-white @break
                          @case('Finalizado') bg-success text-white @break
                          @default bg-light text-dark
                        @endswitch">
                        {{ $req->estado }}
                      </span>
                    </td>
                    <td>{{ ucfirst($req->prioridad) }}</td>
                    <td>{{ $req->usuario->name ?? '—' }}</td>
                    <td>{{ $req->tecnico->name ?? '—' }}</td>
                    <td>{{ \Carbon\Carbon::parse($req->fecha_reporte)->format('d M Y') }}</td>
                    <td>{{ $req->fecha_cierre ? \Carbon\Carbon::parse($req->fecha_cierre)->format('d M Y') : '—' }}</td>
                    <td>
                      <a href="{{ route('requerimientos.show', $req->id) }}" class="btn btn-info btn-sm text-white">
                        <i class="mdi mdi-eye"></i>
                      </a>
                      <a href="{{ route('requerimientos.edit', $req->id) }}" class="btn btn-warning btn-sm text-white">
                        <i class="mdi mdi-pencil"></i>
                      </a>
                      <form action="{{ route('requerimientos.destroy', $req->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este requerimiento?')">
                          <i class="mdi mdi-delete"></i>
                        </button>
                      </form>
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="11" class="text-center text-muted py-3">
                      No hay requerimientos registrados.
                    </td>
                  </tr>
                  @endforelse
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
