@extends('layouts.app')

@section('content')
<div class="main-panel">
  <div class="content-wrapper">

    {{-- Leave Report con contadores --}}
    <div class="row mb-4">
      <div class="col-lg-12">
        <div class="card card-rounded">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h4 class="card-title card-title-dash">Casos Registrados</h4>
              <span class="badge bg-primary">Reporte General</span>
            </div>

            <div class="row text-center mt-4">
              <div class="col-md-4">
                <h5>Pendientes</h5>
                <h3 class="text-danger">{{ $pendientes }}</h3>
              </div>
              <div class="col-md-4">
                <h5>En Proceso</h5>
                <h3 class="text-warning">{{ $en_proceso }}</h3>
              </div>
              <div class="col-md-4">
                <h5>Cerrados</h5>
                <h3 class="text-success">{{ $cerrados }}</h3>
              </div>
            </div>

            <hr class="my-4">

            <div class="text-center">
              <h5>Total de casos: 
                <strong class="text-primary">{{ $pendientes + $en_proceso + $cerrados }}</strong>
              </h5>
            </div>

            <div class="text-center mt-4">
              <h5>Tiempo promedio de resolución:</h5>
              <h4 class="text-info">{{ $tiempo_promedio }} horas</h4>
            </div>

          </div>
        </div>
      </div>
    </div>

    {{-- Tickets por Estado (gráfico existente) --}}
    <div class="row">
      <div class="col-lg-12">
        <div class="card card-rounded">
          <div class="card-body text-center">
            <h4 class="card-title mb-3">Tickets por Estado</h4>
            <p class="card-description">Bienvenido al sistema OpcionHelp</p>

            <div class="chart-container" style="height: 300px; width: 300px; margin: 0 auto;">
              <canvas id="doughnutChart"></canvas>
            </div>

            <div id="doughnutChart-legend" class="mt-3 text-center"></div>
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
  // Gráfico Tickets por Estado
  const ctx = document.getElementById('doughnutChart').getContext('2d');
  new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: ['Pendiente', 'En Proceso', 'Cerrado'],
      datasets: [{
        data: [{{ $pendientes }}, {{ $en_proceso }}, {{ $cerrados }}],
        backgroundColor: ['#cc0000', '#f1c40f', '#2ecc71'],
        borderWidth: 2
      }]
    },
    options: {
      responsive: true,
      cutout: '70%',
      plugins: {
        legend: {
          position: 'bottom',
          labels: { color: '#555', font: { size: 14 } }
        }
      }
    }
  });
</script>
@endsection
