@extends('layouts.app')

@section('content')
<div class="main-panel">
  <div class="content-wrapper">
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
  </div>
  </div>


{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const ctx = document.getElementById('doughnutChart').getContext('2d');
  const doughnutChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: ['Pendiente', 'En Proceso', 'Cerrado'],
      datasets: [{
        data: [{{ $pendientes }}, {{ $en_proceso }}, {{ $cerrados }}],
        backgroundColor: ['#cc0000', '#3498db', '#2ecc71'],
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
