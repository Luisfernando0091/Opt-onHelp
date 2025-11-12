@extends('layouts.app')

@section('content')
{{-- <div class="container-fluid page-body-wrapper"> --}}
  <div class="main-panel">
      <div class="content-wrapper">
        <div class="row">
          <div class="col-lg-12">
            <br>
              </br/>
            <div class="card card-rounded">
              <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h4 class="card-title mb-0">Lista de Incidentes</h4>
              <div class="d-flex gap-2">
                {{-- <a href="{{ route('incidentes.export.pdf') }}" class="btn btn-danger btn-sm">
                  <i class="mdi mdi-file-pdf me-1"></i> Exportar PDF
                </a> --}}
                {{-- <a href="{{ route('incidentes.export.excel') }}" class="btn btn-success btn-sm">
                  <i class="mdi mdi-file-excel me-1"></i> Exportar Excel
                </a> --}}
                <a href="{{ route('incidentes.create') }}" class="btn btn-primary ">
                  <i class="mdi mdi-plus-circle-outline me-1"></i> Nuevo Incidente
                </a>
              </div>
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
{{-- </div> --}}
@endsection


