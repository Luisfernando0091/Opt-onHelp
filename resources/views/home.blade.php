@extends('layouts.app')

@section('content')
<!-- 🔹 CSS -->


<!-- 🔹 Estilos personalizados -->


<div class="container-scroller">

  <!-- 🔹 NAVBAR -->
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

        <!-- 🔹 NUEVO MENÚ “GENERAR TICKET” -->
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center justify-content-between"
             href="#menu-ticket"
             data-bs-toggle="collapse"
             {{-- data-bs-target="#menu-ticket" --}}
             role="button"
             aria-expanded="false"
             aria-controls="menu-ticket">
            <div>
              <i class="menu-icon mdi mdi-cellphone-link"></i>
              <span class="menu-title">Generar Ticket</span>
            </div>
            <i class="mdi mdi-chevron-right menu-arrow"></i>
          </a>

          <div class="collapse" id="menu-ticket" >
            <ul class="nav flex-column sub-menu ps-4">
              <li class="nav-item">
                <a class="nav-link" href="#" >Incidente</a>
              </li>
              <li class="nav-item">
                <a class="nav-link"  href="#">Requerimiento</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Typography</a>
              </li>
            </ul>
          </div>
        </li>
      </ul>
    </nav>

    <!-- 🔹 CONTENIDO -->
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

<!-- ✅ Librerías base -->

<!-- 🔹 Script final limpio -->


@endsection
