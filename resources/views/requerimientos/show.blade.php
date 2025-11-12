@extends('layouts.app')

@section('title', 'Detalle del Requerimiento')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card card-rounded shadow-lg border-0">
                    
                    {{-- 🔹 Encabezado --}}
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-file-earmark-text me-2"></i> 
                            Detalle del Requerimiento
                        </h5>
                        <a href="{{ route('requerimientos.index') }}" class="btn btn-light btn-sm">
                            <i class="bi bi-arrow-left"></i> Volver
                        </a>
                    </div>

                    {{-- 🔹 Contenido --}}
                    <div class="card-body">
                        
                        {{-- 🔸 Sección principal --}}
                        <table class="table table-borderless table-sm align-middle">
                            <tbody>
                                <tr>
                                    <th class="text-end w-25">Código:</th>
                                    <td class="fw-semibold">{{ $requerimiento->codigo }}</td>
                                    <th class="text-end w-25">Requerimiento:</th>
                                    <td>{{ $requerimiento->titulo }}</td>
                                </tr>

                                <tr>
                                    <th class="text-end">Estado:</th>
                                    <td>
                                        <span class="badge 
                                            @if($requerimiento->estado == 'Pendiente') bg-warning text-dark
                                            @elseif($requerimiento->estado == 'En proceso') bg-info text-white
                                            @elseif($requerimiento->estado == 'Finalizado') bg-success text-white
                                            @else bg-secondary text-white @endif">
                                            {{ $requerimiento->estado }}
                                        </span>
                                    </td>
                                    <th class="text-end">Prioridad:</th>
                                    <td>
                                        <span class="badge 
                                            @if($requerimiento->prioridad == 'Alta') bg-danger
                                            @elseif($requerimiento->prioridad == 'Media') bg-warning text-dark
                                            @elseif($requerimiento->prioridad == 'Baja') bg-secondary
                                            @else bg-light text-dark @endif">
                                            {{ $requerimiento->prioridad }}
                                        </span>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="text-end">Fecha de Solicitud:</th>
                                    <td>{{ \Carbon\Carbon::parse($requerimiento->fecha_reporte)->format('d/m/Y H:i') }}</td>
                                    <th class="text-end">Solicitante:</th>
                                    <td>{{ $requerimiento->usuario?->name ?? 'No asignado' }}</td>
                                </tr>

                                <tr>
                                    <th class="text-end">Responsable / Técnico:</th>
                                    <td>{{ $requerimiento->tecnico?->name ?? 'No asignado' }}</td>
                                    <th class="text-end">Fecha de Cierre:</th>
                                    <td>
                                        {{ $requerimiento->fecha_cierre 
                                            ? \Carbon\Carbon::parse($requerimiento->fecha_cierre)->format('d/m/Y H:i') 
                                            : '—' }}
                                    </td>
                                </tr>

                                {{-- Si tu requerimiento tiene “tipo” o “categoría” --}}
                                @if(!empty($requerimiento->tipo))
                                <tr>
                                    <th class="text-end">Tipo de Requerimiento:</th>
                                    <td colspan="3">{{ $requerimiento->tipo }}</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>

                        {{-- 🔹 Descripción --}}
                        <div class="mt-4">
                            <h6 class="fw-bold text-primary">Descripción del Requerimiento</h6>
                            <div class="border rounded p-3 bg-light mt-2">
                                {{ $requerimiento->descripcion ?? '— Sin descripción registrada —' }}
                            </div>
                        </div>

                        {{-- 🔹 Solución / Respuesta --}}
                        <div class="mt-4">
                            <h6 class="fw-bold text-success">Solución / Respuesta</h6>
                            <div class="border rounded p-3 bg-light mt-2">
                                {{ $requerimiento->solucion ?? '— Sin solución registrada —' }}
                            </div>
                        </div>

                    </div> {{-- fin card-body --}}
                </div>
            </div>
        </div>
    </div>
</div>
    </div>
</div>
@endsection
