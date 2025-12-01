@extends('layouts.app')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <br><br>

                <div class="card card-rounded shadow-sm border-0">
                    <div class="card-header bg-primary text-white card-rounded-top">
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

                        {{-- Formulario --}}
                        <form action="{{ route('historial.store', $activo->id) }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="observacion" class="form-label">Observación del mantenimiento</label>
                                <textarea name="observacion" id="observacion" class="form-control" rows="4" placeholder="Escribe aquí la observación..." required></textarea>
                            </div>

                            {{-- Selección de cambio de piezas --}}
                            <div class="mb-3">
                                <label for="selectCambioPiezas" class="form-label">¿Se cambiaron piezas?</label>
                                <select id="selectCambioPiezas" name="cambio_piezas" class="form-select" required>
                                    <option value="no" selected>No</option>
                                    <option value="si">Sí</option>
                                </select>
                            </div>

                            {{-- Campo para piezas (se muestra si elige "sí") --}}
                            <div class="mb-3 d-none" id="contenedor-piezas">
                                <label>Piezas reemplazadas</label>
                                <input type="text" name="piezas" class="form-control" placeholder="Ej: Disco duro, RAM">
                            </div>

                            <div class="d-flex justify-content-between">
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
{{-- Script funcional --}}
<script>
document.getElementById('selectCambioPiezas').addEventListener('change', function () {
    const mostrar = this.value === 'si';
    document.getElementById('contenedor-piezas').classList.toggle('d-none', !mostrar);
});
</script>

@endsection
