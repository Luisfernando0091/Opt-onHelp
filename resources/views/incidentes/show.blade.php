@extends('layouts.app')

@section('title', 'Detalle del Incidente')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card card-rounded shadow-lg border-0">
                    
                    {{-- 🔹 Encabezado --}}
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-exclamation-triangle me-2"></i> 
                            Detalle del Incidente
                        </h5>
                        <a href="{{ route('incidentes.index') }}" class="btn btn-light btn-sm">
                            <i class="bi bi-arrow-left"></i> Volver
                        </a>
                    </div>

                    {{-- 🔹 Contenido --}}
                    <div class="card-body">
                        
                        {{-- Sección principal --}}
                        <table class="table table-borderless table-sm align-middle">
                            <tbody>
                                <tr>
                                    <th class="text-end w-25">Código:</th>
                                    <td class="fw-semibold">{{ $incidente->codigo }}</td>
                                    <th class="text-end w-25">Título:</th>
                                    <td>{{ $incidente->titulo }}</td>
                                </tr>

                                <tr>
                                    <th class="text-end">Estado:</th>
                                    <td>
                                        <span class="badge 
                                            @if($incidente->estado == 'Abierto') bg-warning 
                                            @elseif($incidente->estado == 'En Progreso') bg-info 
                                            @elseif($incidente->estado == 'Cerrado') bg-success 
                                            @else bg-secondary @endif">
                                            {{ $incidente->estado }}
                                        </span>
                                    </td>
                                    <th class="text-end">Prioridad:</th>
                                    <td>
                                        <span class="badge 
                                            @if($incidente->prioridad == 'Alta') bg-danger 
                                            @elseif($incidente->prioridad == 'Media') bg-warning 
                                            @else bg-secondary @endif">
                                            {{ $incidente->prioridad }}
                                        </span>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="text-end">Fecha de Reporte:</th>
                                    <td>{{ \Carbon\Carbon::parse($incidente->fecha_reporte)->format('d/m/Y H:i') }}</td>
                                    <th class="text-end">Usuario:</th>
                                    <td>{{ $incidente->usuario?->name ?? 'No asignado' }}</td>
                                </tr>

                                <tr>
                                    <th class="text-end">Técnico:</th>
                                    <td>{{ $incidente->tecnico?->name ?? 'No asignado' }}</td>
                                    <th class="text-end">Fecha de Cierre:</th>
                                    <td>
                                        {{ $incidente->fecha_cierre 
                                            ? \Carbon\Carbon::parse($incidente->fecha_cierre)->format('d/m/Y H:i') 
                                            : '—' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        {{-- 🔹 Descripción --}}
                        <div class="mt-4">
                            <h6 class="fw-bold text-primary">Descripción del Incidente</h6>
                            <div class="border rounded p-3 bg-light mt-2">
                                {{ $incidente->descripcion ?? '— Sin descripción registrada —' }}
                            </div>
                        </div>

                        {{-- 🔹 Solución --}}
                        <div class="mt-4">
                            <h6 class="fw-bold text-success">Solución Aplicada</h6>
                            <div class="border rounded p-3 bg-light mt-2">
                                {{ $incidente->solucion ?? '— Sin solución registrada —' }}
                            </div>
                        </div>

                        {{-- 🔹 Botones inferiores --}}
                        {{-- <div class="mt-4 d-flex justify-content-end gap-2">
                            <a href="{{ route('incidentes.export.pdf') }}" class="btn btn-danger btn-sm">
                                <i class="bi bi-file-earmark-pdf"></i> Exportar PDF
                            </a>
                            <a href="{{ route('incidentes.export.excel') }}" class="btn btn-success btn-sm">
                                <i class="bi bi-file-earmark-excel"></i> Exportar Excel
                            </a>
                            <a href="{{ route('incidentes.index') }}" class="btn btn-secondary btn-sm">
                                <i class="bi bi-arrow-left"></i> Regresar
                            </a>
                        </div> --}}

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    </div>
</div>
@endsection
