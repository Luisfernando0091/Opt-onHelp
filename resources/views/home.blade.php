@extends('layouts.app')

@section('content')
<!-- 🔹 CSS -->
<link rel="stylesheet" href="{{ asset('staradmin-2-free/src/assets/vendors/feather/feather.css') }}">
<link rel="stylesheet" href="{{ asset('staradmin-2-free/src/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
<link rel="stylesheet" href="{{ asset('staradmin-2-free/src/assets/vendors/ti-icons/css/themify-icons.css') }}">
<link rel="stylesheet" href="{{ asset('staradmin-2-free/src/assets/vendors/font-awesome/css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('staradmin-2-free/src/assets/vendors/css/vendor.bundle.base.css') }}">
<link rel="stylesheet" href="{{ asset('staradmin-2-free/src/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('staradmin-2-free/src/assets/css/style.css') }}">

<!-- 🔹 Estilos personalizados -->
<style>
  /* 🔹 Corrige posición del dropdown de usuario */
  .navbar .dropdown-menu {
    top: 60px !important; /* baja el menú 60px desde el top */
    right: 10px !important;
    left: auto !important;
    position: absolute !important;
    z-index: 1050 !important; /* asegura que se vea encima de todo */
    border-radius: 10px;
    border: none;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  }

  /* 🔹 Ajusta el tamaño y centrado del gráfico */
  #doughnutChart {
    width: 260px !important;
    height: 260px !important;
    display: block;
    margin: 0 auto;
  }

  .card-body {
    text-align: center;
  }
</style>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    // ✅ Forzamos inicialización del dropdown manualmente
    const dropdownTriggerList = [].slice
      .call(document.querySelectorAll('[data-bs-toggle="dropdown"]'))
      .map(function (dropdownTriggerEl) {
        return new bootstrap.Dropdown(dropdownTriggerEl);
      });

    console.log("✅ Dropdown perfil inicializado correctamente");
  });
</script>


<div class="container-scroller">

  <!-- 🔹 NAVBAR SUPERIOR -->
  <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
      <a class="navbar-brand brand-logo" href="#">
        <img src="{{ asset('img/A/logo.png') }}" alt="logo" />
      </a>
    </div>

    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="UserDropdown" role="button"
             data-bs-toggle="dropdown" aria-expanded="false">
            <img class="img-xs rounded-circle" src="{{ asset('img/B/face8.png') }}" alt="Profile image">
          </a>

          <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="UserDropdown">
            <li class="dropdown-header text-center">
              <p class="mb-1 mt-2 fw-semibold">{{ Auth::user()->name ?? 'Usuario' }}</p>
              <p class="fw-light text-muted small mb-0">{{ Auth::user()->email ?? 'correo@ejemplo.com' }}</p>
              <p class="fw-light text-muted small mb-0">{{ Auth::user()->role ?? '' }}</p>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#"><i class="mdi mdi-account-outline text-primary me-2"></i> Perfil</a></li>
            <li>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item">
                  <i class="mdi mdi-power text-primary me-2"></i>Salir
                </button>
              </form>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>

  <!-- 🔹 CONTENEDOR PRINCIPAL -->
  <div class="container-fluid page-body-wrapper">

    <!-- 🔹 SIDEBAR -->
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
      <ul class="nav">
        <li class="nav-item">
          <a class="nav-link" href="#">
            <i class="mdi mdi-grid-large menu-icon"></i>
            <span class="menu-title">Dashboard</span>
          </a>
        </li>

        <li class="nav-item nav-category">Gestión</li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('usuarios.index') }}">
            <i class="menu-icon mdi mdi-account-multiple"></i>
            <span class="menu-title">Usuarios</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="#">
            <i class="menu-icon mdi mdi-file-document"></i>
            <span class="menu-title">Reportes</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">
            <i class="menu-icon mdi mdi-cellphone-link"></i>
            <span class="menu-title">Generar Incidente</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">
            <i class="menu-icon mdi mdi-folder-account"></i>
            <span class="menu-title">Generar Requerimiento</span>
          </a>
        </li>
      </ul>
    </nav>

    <!-- 🔹 CONTENIDO PRINCIPAL -->
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="row">
          <div class="col-lg-12">
            <div class="card card-rounded">
              <div class="card-body">
                <h4 class="card-title">Resumen</h4>
                <p class="card-description">Bienvenido al sistema OpcionHelp</p>
                <div class="row flex-grow">
                  <div class="col-12 grid-margin stretch-card">
                    <div class="card card-rounded">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-lg-12 text-center">
                            <h4 class="card-title card-title-dash mb-3">Type By Amount</h4>
                            <div class="chart-container">
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
          </div>
        </div>
      </div>

      <!-- 🔹 FOOTER -->
      <footer class="footer">
        <div class="d-sm-flex justify-content-center justify-content-sm-between">
          <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">
            © {{ date('Y') }} OpcionHelp. Todos los derechos reservados Área TI.
          </span>
        </div>
      </footer>
    </div>
  </div>
</div>

<!-- 🔹 JS -->
<script src="{{ asset('staradmin-2-free/src/assets/vendors/js/vendor.bundle.base.js') }}"></script>
<script src="{{ asset('staradmin-2-free/src/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('staradmin-2-free/src/assets/js/off-canvas.js') }}"></script>
<script src="{{ asset('staradmin-2-free/src/assets/js/template.js') }}"></script>
<script src="{{ asset('staradmin-2-free/src/assets/js/settings.js') }}"></script>
<script src="{{ asset('staradmin-2-free/src/assets/js/hoverable-collapse.js') }}"></script>
<script src="{{ asset('staradmin-2-free/src/assets/js/todolist.js') }}"></script>
<script src="{{ asset('staradmin-2-free/src/assets/vendors/chart.js/chart.umd.js') }}"></script>

<!-- 🔹 Script del dropdown + gráfico -->
<script>
document.addEventListener("DOMContentLoaded", function () {
  // Dropdown del perfil
  const dropdownTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="dropdown"]'));
  dropdownTriggerList.forEach(el => new bootstrap.Dropdown(el));

  // Gráfico circular
  const ctx = document.getElementById("doughnutChart");
  if (ctx) {
    new Chart(ctx, {
      type: "doughnut",
      data: {
        labels: ["Usuarios", "Reportes", "Gestión"],
        datasets: [{
          data: [40, 30, 30],
          backgroundColor: ["#1F3BB3", "#FDD0C7", "#52CDFF"],
          borderWidth: 0
        }]
      },
      options: {
        cutout: "70%",
        plugins: {
          legend: {
            display: true,
            position: "bottom",
            labels: {
              boxWidth: 15,
              padding: 15
            }
          }
        }
      }
    });
  }
});
</script>

@endsection
