@extends('layouts.app')

@section('content')
<div class="main-panel">
  <div class="content-wrapper py-4">

    {{-- Dashboard principal --}}
    <div class="row g-4">
      <div class="col-lg-12">
        <br><br/>
        <div class="card shadow-sm border-0 rounded-4">
          <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-4">
              <h4 class="fw-bold text-primary mb-0">
                <i class="mdi mdi-chart-bar me-2"></i> Casos Registrados
              </h4>
              <span class="badge bg-gradient-primary px-3 py-2 fs-6">Reporte General</span>
            </div>

            {{-- Contadores (unificados: incidentes + requerimientos) --}}
            <div class="row text-center mt-3">
              <div class="col-md-4 mb-3">
                <div class="p-3 bg-light rounded-4 shadow-sm">
                  <h6 class="text-muted mb-2">Pendientes</h6>
                  <h2 class="fw-bold text-danger mb-0">
                    {{ $tickets_por_estado['Pendiente'] ?? 0 }}
                  </h2>
                </div>
              </div>

              <div class="col-md-4 mb-3">
                <div class="p-3 bg-light rounded-4 shadow-sm">
                  <h6 class="text-muted mb-2">En Proceso</h6>
                  <h2 class="fw-bold text-warning mb-0">
                    {{ $tickets_por_estado['En proceso'] ?? 0 }}
                  </h2>
                </div>
              </div>

              <div class="col-md-4 mb-3">
                <div class="p-3 bg-light rounded-4 shadow-sm">
                  <h6 class="text-muted mb-2">Cerrados</h6>
                  <h2 class="fw-bold text-success mb-0">
                    {{ ($tickets_por_estado['Cerrado'] ?? 0) + ($tickets_por_estado['Finalizado'] ?? 0) }}
                  </h2>
                </div>
              </div>
            </div>

            <hr class="my-4">

            {{-- Total de casos --}}
            <div class="text-center">
              <h6 class="text-muted mb-1">Total de casos</h6>
              <h3 class="fw-bold text-primary">
                {{ $tickets_por_estado->sum() }}
              </h3>
            </div>

            {{-- Tiempo promedio --}}
            <div class="text-center mt-4">
              <h6 class="text-muted mb-1">Tiempo promedio de resolución</h6>
              <h4 class="fw-bold text-info">
                {{ $tiempo_promedio }}
              </h4>
            </div>

          </div>
        </div>
      </div>
    </div>


    {{-- ====================  DOS GRÁFICOS DONUT ==================== --}}
    <div class="row mt-4">

      {{-- Donut 1: Tickets por Estado --}}
      <div class="col-lg-6">
        <div class="card shadow-sm border-0 rounded-4">
          <div class="card-body text-center">
            <h4 class="fw-bold text-dark mb-2">
              <i class="mdi mdi-chart-donut-variant me-2 text-primary"></i>Tickets por Estado
            </h4>
            <p class="text-muted mb-3">Estados combinados (Incidentes + Requerimientos)</p>

            <div class="chart-container mx-auto" style="height: 300px; width: 300px;">
              <canvas id="doughnutChartEstados"></canvas>
            </div>
          </div>
        </div>
      </div>

      {{-- Donut 2: Tickets por Tipo --}}
      <div class="col-lg-6">
        <div class="card shadow-sm border-0 rounded-4">
          <div class="card-body text-center">
            <h4 class="fw-bold text-dark mb-2">
              <i class="mdi mdi-chart-donut-variant me-2 text-success"></i>Tickets por Tipo
            </h4>
            <p class="text-muted mb-3">Incidentes vs Requerimientos</p>

            <div class="chart-container mx-auto" style="height: 300px; width: 300px;">
              <canvas id="doughnutChartTipos"></canvas>
            </div>
          </div>
        </div>
      </div>

    </div>



    {{-- === Area Chart mensual === --}}
    <div class="row mt-4">
      <div class="col-lg-12">
        <div class="card shadow-sm border-0 rounded-4">
          <div class="card-body text-center">
            <h4 class="fw-bold text-dark mb-3">
              <i class="mdi mdi-chart-areaspline me-2 text-info"></i> Tickets por Mes
            </h4>
            <p class="text-muted mb-4">Incidentes y Requerimientos</p>

            <div class="chart-container mx-auto" style="height: 340px; width: 100%;">
              <canvas id="areaChart"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
   </div>
    </div>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  // === Donut Estados ===
  new Chart(document.getElementById('doughnutChartEstados'), {
    type: 'doughnut',
    data: {
      labels: ['Pendiente', 'En proceso', 'Cerrado', 'Finalizado'],
      datasets: [{
        data: [
          {{ $tickets_por_estado['Pendiente'] ?? 0 }},
          {{ $tickets_por_estado['En proceso'] ?? 0 }},
          {{ $tickets_por_estado['Cerrado'] ?? 0 }},
          {{ $tickets_por_estado['Finalizado'] ?? 0 }}
        ],
        backgroundColor: ['#ef4444', '#facc15', '#22c55e', '#38bdf8'],
        borderColor: '#fff',
        borderWidth: 3,
        hoverOffset: 12
      }]
    },
    options: {
      cutout: '65%',
      plugins: { legend: { position: 'bottom' } }
    }
  });


  // === Donut Tipos ===
  new Chart(document.getElementById('doughnutChartTipos'), {
    type: 'doughnut',
    data: {
      labels: ['Incidentes', 'Requerimientos'],
      datasets: [{
        data: [
          {{ array_sum($incidentes) }},
          {{ array_sum($requerimientos) }}
        ],
        backgroundColor: ['#3b82f6', '#10b981'],
        borderColor: '#fff',
        borderWidth: 3,
        hoverOffset: 12
      }]
    },
    options: {
      cutout: '65%',
      plugins: { legend: { position: 'bottom' } }
    }
  });


  // === Area Chart ===
  new Chart(document.getElementById('areaChart'), {
    type: 'line',
    data: {
      labels: @json($meses),
      datasets: [
        {
          label: 'Incidentes',
          data: @json($incidentes),
          borderColor: '#ef4444',
          backgroundColor: 'rgba(239, 68, 68, 0.25)',
          fill: true,
          tension: 0.4
        },
        {
          label: 'Requerimientos',
          data: @json($requerimientos),
          borderColor: '#3b82f6',
          backgroundColor: 'rgba(59, 130, 246, 0.25)',
          fill: true,
          tension: 0.4
        }
      ]
    },
    options: { plugins: { legend: { position: 'bottom' } } }
  });
</script>

@endsection
