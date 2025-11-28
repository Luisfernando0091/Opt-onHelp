@extends('layouts.app')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row ">
        <div class="col-lg-12">

              <br/><br/>
                
                {{-- Card principal --}}
                <div class="card card-rounded shadow-sm border-0">
                    <div class="card-header bg-primary  mb-3 text-white card-rounded-top">
                        <h4 class="mb-0">Registrar Mantenimiento</h4>
                    </div>

                    <div class="card-body">

                        {{-- Información del activo --}}
                        <div class="mb-4">
                            <h5>Detalle del Activo</h5>
                            <hr>
                            <div class="row">
                                <div class="col-md-6"><strong>Activo:</strong> {{ $activo->nombre }}</div>
                                <div class="col-md-6"><strong>Serie:</strong> {{ $activo->serial }}</div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6"><strong>Marca:</strong> {{ $activo->marca }}</div>
                                <div class="col-md-6"><strong>Estado:</strong> {{ $activo->estado }}</div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6"><strong>Ubicación:</strong> {{ $activo->ubicacion->nombre ?? 'Sin ubicación' }}</div>
                                <div class="col-md-6"><strong>Asignado:</strong> 
                                    {{ trim(($activo->usuario->name ?? '') . ' ' . ($activo->usuario->LastName ?? '')) ?: 'Sin asignar' }}
                                </div>
                            </div>
                        </div>

                        {{-- Formulario de mantenimiento --}}
                        <form action="{{ route('historial.store', $activo->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="observacion" class="form-label">Observación del mantenimiento</label>
                                <textarea ea name="observacion" id="observacion" class="form-control" rows="4" placeholder="Escribe aquí la observación..." required></textarea>
                            </div>

                            <div class="d-flex justify-content-between">
                                {{-- <a href="{{ route('historial.create', $activo->id) }}" class="btn btn-secondary">Cancelar</a> --}}
                                <button type="submit" class="btn btn-success">Guardar</button>
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
