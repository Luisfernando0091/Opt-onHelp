<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'OpcionHelp') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- 🔹 CSS StarAdmin -->
    <link rel="stylesheet" href="{{ asset('staradmin-2-free/src/assets/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('staradmin-2-free/src/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('staradmin-2-free/src/assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('staradmin-2-free/src/assets/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('staradmin-2-free/src/assets/vendors/typicons/typicons.css') }}">
    <link rel="stylesheet" href="{{ asset('staradmin-2-free/src/assets/vendors/simple-line-icons/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('staradmin-2-free/src/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">

    <link rel="stylesheet" href="{{ asset('staradmin-2-free/src/assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('staradmin-2-free/src/assets/css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('staradmin-2-free/src/assets/images/favicon.png') }}" />
    
<style>
  .navbar .dropdown-menu {
    top: 60px !important;
    right: 10px !important;
    left: auto !important;
    position: absolute !important;
    z-index: 1050 !important;
    border-radius: 10px;
    border: none;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  }

  /* 🔹 Sidebar y menú */
  .sidebar .collapse {
    display: none;
    height: 0;
    overflow: hidden;
    transition: all 0.3s ease;
  }

  .sidebar .collapse.show {
    display: block !important;
    height: auto !important;
  }

  .sidebar .sub-menu {
    padding-left: 1.8rem;
    background: rgba(255,255,255,0.05);
    border-left: 2px solid #1F3BB3;
  }

  .sidebar .sub-menu .nav-link {
    font-size: 0.9rem;
    padding: 6px 16px;
    display: block;
  }

  .menu-arrow {
    transition: transform 0.3s ease;
  }

  .menu-arrow.rotate {
    transform: rotate(90deg);
  }

  /* 🔹 Gráfico */
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
 <style>
  /* 🔹 Corrige el comportamiento visual del collapse del sidebar */
  .sidebar .collapse {
    display: none !important;
    overflow: hidden;
    transition: all 0.3s ease;
  }

  .sidebar .collapse.show {
    display: block !important;
  }

  /* 🔹 Submenús con un poquito de estilo */
  .sidebar .sub-menu {
    padding-left: 1.8rem;
    background: rgba(255, 255, 255, 0.05);
    border-left: 2px solid #1F3BB3;
  }

  .sidebar .sub-menu .nav-link {
    font-size: 0.9rem;
    padding: 6px 16px;
    display: block;
  }

  /* 🔹 Flecha animada */
  .menu-arrow {
    transition: transform 0.3s ease;
  }
  .nav-item .collapse.show ~ .menu-arrow {
    transform: rotate(90deg);
  }
</style>

    @stack('styles')
</head>

<body>
    {{-- <div id="app">
        <main class="py-4">
            @yield('content')
        </main>
    </div> --}}
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
@yield('content')

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

 
    <!-- ✅ StarAdmin JS -->
    <script src="{{ asset('staradmin-2-free/src/assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('staradmin-2-free/src/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('staradmin-2-free/src/assets/js/off-canvas.js') }}"></script>
    {{-- <script src="{{ asset('staradmin-2-free/src/assets/js/template.js') }}"></script> --}}
    <script src="{{ asset('staradmin-2-free/src/assets/js/settings.js') }}"></script>
    <script src="{{ asset('staradmin-2-free/src/assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('staradmin-2-free/src/assets/js/todolist.js') }}"></script>

    <!-- ⚠️ Elimina dashboard.js porque genera errores -->
    {{-- <script src="{{ asset('staradmin-2-free/src/assets/js/dashboard.js') }}"></script> --}}

  


    @stack('scripts')
   
</body>
</html>
