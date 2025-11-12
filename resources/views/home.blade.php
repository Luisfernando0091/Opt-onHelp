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

            {{-- Contadores --}}
            <div class="row text-center mt-3">
              <div class="col-md-4 mb-3">
                <div class="p-3 bg-light rounded-4 shadow-sm">
                  <h6 class="text-muted mb-2">Pendientes</h6>
                  <h2 class="fw-bold text-danger mb-0">{{ $pendientes }}</h2>
                </div>
              </div>
              <div class="col-md-4 mb-3">
                <div class="p-3 bg-light rounded-4 shadow-sm">
                  <h6 class="text-muted mb-2">En Proceso</h6>
                  <h2 class="fw-bold text-warning mb-0">{{ $en_proceso }}</h2>
                </div>
              </div>
              <div class="col-md-4 mb-3">
                <div class="p-3 bg-light rounded-4 shadow-sm">
                  <h6 class="text-muted mb-2">Cerrados</h6>
                  <h2 class="fw-bold text-success mb-0">{{ $cerrados }}</h2>
                </div>
              </div>
            </div>

            <hr class="my-4">

            <div class="text-center">
              <h6 class="text-muted mb-1">Total de casos</h6>
              <h3 class="fw-bold text-primary">
                {{ $pendientes + $en_proceso + $cerrados }}
              </h3>
            </div>

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

    {{-- Gráfico Donut --}}
    <div class="row mt-4">
      <div class="col-lg-12">
        <div class="card shadow-sm border-0 rounded-4">
          <div class="card-body text-center">
            <h4 class="fw-bold text-dark mb-2">
              <i class="mdi mdi-chart-donut-variant me-2 text-primary"></i>Tickets por Estado
            </h4>
            <p class="text-muted">Bienvenido al sistema <strong>OpcionHelp</strong></p>

            <div class="chart-container position-relative mx-auto" style="height: 320px; width: 320px;">
              <canvas id="doughnutChart"></canvas>
            </div>

            <div id="doughnutChart-legend" class="mt-3"></div>
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
            <p class="text-muted mb-4">Distribución mensual de Incidentes y Requerimientos</p>

            <div class="chart-container position-relative mx-auto" style="height: 340px; width: 100%;">
              <canvas id="areaChart"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
 </div>
</div>
  </div> {{-- /.content-wrapper --}}
</div> {{-- /.main-panel --}}

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // === Donut Chart ===
  const ctx = document.getElementById('doughnutChart').getContext('2d');
  new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: ['Pendiente', 'En Proceso', 'Cerrado'],
      datasets: [{
        data: [{{ $pendientes }}, {{ $en_proceso }}, {{ $cerrados }}],
        backgroundColor: ['#ef4444', '#facc15', '#22c55e'],
        borderColor: '#fff',
        borderWidth: 3,
        hoverOffset: 12
      }]
    },
    options: {
      responsive: true,
      cutout: '65%',
      plugins: {
        legend: {
          position: 'bottom',
          labels: {
            color: '#444',
            font: { size: 14, weight: '600' },
            padding: 20
          }
        }
      }
    }
  });

  // === Area Chart ===
  const ctxArea = document.getElementById('areaChart').getContext('2d');
  new Chart(ctxArea, {
    type: 'line',
    data: {
      labels: @json($meses),
      datasets: [
        {
          label: 'Incidentes',
          data: @json($incidentes),
          borderColor: '#ef4444',
          backgroundColor: 'rgba(239,68,68,0.2)',
          fill: true,
          tension: 0.4
        },
        {
          label: 'Requerimientos',
          data: @json($requerimientos),
          borderColor: '#3b82f6',
          backgroundColor: 'rgba(59,130,246,0.2)',
          fill: true,
          tension: 0.4
        }
      ]
    },
    options: {
      responsive: true,
      scales: {
        y: { beginAtZero: true, ticks: { precision: 0 } }
      },
      plugins: { legend: { position: 'bottom' } }
    }
  });
</script>
@endsection
