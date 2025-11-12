@extends('layouts.app')

@section('content')
<div class="main-panel">
  <div class="content-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold mb-0 text-primary">Requerimientos</h4>

      {{-- Botón visible solo para usuarios con rol usuario o admin --}}
      @if(auth()->user()->hasRole('usuario') || auth()->user()->hasRole('admin'))
        <a href="{{ route('requerimientos.create') }}" class="btn btn-primary shadow-sm">
          <i class="mdi mdi-plus-circle-outline me-1"></i> Nuevo Requerimiento
        </a>
      @endif
    </div>

    {{-- Incluye la tabla de requerimientos --}}
    @include('requerimientos.partials.listar')
  </div>
</div>
@endsection
