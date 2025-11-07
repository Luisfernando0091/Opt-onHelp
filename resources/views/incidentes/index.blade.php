@extends('layouts.app')

@section('content')
<div class="container-fluid page-body-wrapper">
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-12 grid-margin stretch-card">
          <div class="card card-rounded">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title mb-0">Lista de Incidentes</h4>
                <a href="{{ route('incidentes.create') }}" class="btn btn-primary btn-sm">
                  <i class="mdi mdi-plus-circle-outline me-1"></i> Nuevo Incidente
                </a>
              </div>

              <p class="card-description">
                Incidentes registrados en el sistema
              </p>

              <div id="tabla-incidentes">
                @include('incidentes.partials.lista', ['incidentes' => $incidentes])
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>


  </div>
</div>
@endsection


