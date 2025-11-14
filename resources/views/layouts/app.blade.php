<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'OpcionHelp') }}</title>

  <!-- 🔹 Fuentes -->
  <link rel="dns-prefetch" href="//fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=Nunito:400,600,700" rel="stylesheet">

  <!-- 🔹 Estilos Base StarAdmin -->
  <link rel="stylesheet" href="{{ asset('staradmin-2-free/src/assets/vendors/feather/feather.css') }}">
  <link rel="stylesheet" href="{{ asset('staradmin-2-free/src/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('staradmin-2-free/src/assets/vendors/ti-icons/css/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('staradmin-2-free/src/assets/vendors/font-awesome/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('staradmin-2-free/src/assets/vendors/simple-line-icons/css/simple-line-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('staradmin-2-free/src/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
  <link rel="stylesheet" href="{{ asset('staradmin-2-free/src/assets/vendors/css/vendor.bundle.base.css') }}">
  <link rel="stylesheet" href="{{ asset('staradmin-2-free/src/assets/css/style.css') }}">
  <link rel="shortcut icon" href="{{ asset('staradmin-2-free/src/assets/images/favicon.png') }}"/>

  <!-- 🔹 Estilos personalizados -->
  <style>
    /* === SIDEBAR === */
    .sidebar {
      background: #fff;
      border-right: 1px solid #e9ecef;
      width: 250px;
      min-height: 100vh;
      transition: all 0.3s ease;
    }
    .sidebar .nav-link {
      display: flex;
      align-items: center;
      padding: 10px 20px;
      color: #555;
      font-weight: 500;
      border-radius: 8px;
      transition: all 0.2s ease-in-out;
    }
    .sidebar .nav-link:hover {
      background-color: #f4f6f8;
      color: #1F3BB3;
      transform: translateX(3px);
    }
    .sidebar .nav-link.active-link {
      background-color: #e7f1ff;
      color: #1F3BB3;
      font-weight: 600;
    }
    .sidebar .menu-icon {
      font-size: 1.3rem;
      margin-right: 0.75rem;
      color: #6c757d;
    }
    .sidebar .nav-link.active-link .menu-icon {
      color: #1F3BB3;
    }
    .sidebar .toggle-icon {
      font-size: 1.1rem;
      color: #888;
      transition: transform 0.3s ease;
    }
    .sidebar .nav-link[aria-expanded="true"] .toggle-icon {
      transform: rotate(90deg);
      color: #1F3BB3;
    }
    .sidebar .sub-menu {
      padding-left: 2rem;
      background: rgba(0, 0, 0, 0.02);
      border-left: 2px solid #1F3BB3;
    }
    .sidebar .sub-menu .nav-link {
      font-size: 0.9rem;
      color: #777;
    }
    .sidebar .sub-menu .nav-link:hover {
      color: #1F3BB3;
    }

    /* === LOGO DEL SIDEBAR === */
    .sidebar-header {
      background-color: #fff;
      padding: 1rem 1rem;
      border-bottom: 1px solid #e9ecef;
      text-align: center;
    }
    .sidebar-header img {
      max-width: 140px;
      height: auto;
      display: inline-block;
      margin: 0 auto;
      transition: transform 0.18s ease;
    }
    .sidebar-header img:hover {
      transform: scale(1.03);
    }

    /* === CONTENIDO === */
    .content-wrapper {
      background-color: #f8f9fc;
        padding: 2.5rem 2rem 2rem; /* agrega espacio arriba */

      padding: 2rem;
      min-height: calc(100vh - 64px);
    }

    /* === FOOTER === */
    .footer {
      background: #fff;
      border-top: 1px solid #e9ecef;
      padding: 0.75rem 1rem;
      font-size: 0.85rem;
    }

    /* === PERFIL (SIDEBAR) === */
    #menu-perfil .card {
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 3px 8px rgba(0,0,0,0.04);
    }
    #menu-perfil .rounded-circle {
      border: 1px solid #e9ecef;
    }
    #menu-perfil a {
      color: #374151;
    }
    #menu-perfil a:hover {
      color: #1F3BB3;
      text-decoration: none;
    }
    #menu-perfil .btn-outline-danger {
      border-color: #f87171;
      color: #f87171;
    }
    #menu-perfil .btn-outline-danger:hover {
      background: #f87171;
      color: #fff;
      border-color: #f87171;
    }

    /* 🔹 Corrige espacio superior sobrante */
    .page-body-wrapper,
    .main-panel,
    .content-wrapper {
      margin-top: 0 !important;
      padding-top: 0 !important;
    }

    /* responsive */
    @media (max-width: 576px) {
      .sidebar-header img { max-width: 110px; }
      .sidebar { width: 220px; }
    }
  </style>

  @stack('styles')
</head>

<body>
  <div class="container-scroller">

    <!-- 🔹 CONTENEDOR PRINCIPAL -->
    <div class="container-fluid page-body-wrapper">

      <!-- 🔹 SIDEBAR -->
      <nav class="sidebar sidebar-offcanvas shadow-sm border-end" id="sidebar">
        <div class="sidebar-header">
          <img src="{{ asset('img/A/logo.png') }}" alt="logo" />
        </div>

        <ul class="nav flex-column mt-3">
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('home') ? 'active-link' : '' }}" href="{{ route('home') }}">
              <i class="mdi mdi-view-dashboard-outline menu-icon"></i>
              <span>Dashboard</span>
            </a>
          </li>

          <li class="nav-item mt-3 text-uppercase text-muted small ps-4">Gestión</li>

         @role('admin')
<li class="nav-item">
  <a class="nav-link {{ request()->routeIs('usuarios.index') ? 'active-link' : '' }}" href="{{ route('usuarios.index') }}">
    <i class="mdi mdi-account-multiple-outline menu-icon"></i>
    <span>Usuarios</span>
  </a>
</li>
@endrole


          <li class="nav-item">
            <a class="nav-link" href="{{ route('reportes.incidentes') }}">
              <i class="mdi mdi-file-chart menu-icon"></i>
              <span>Reportes</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link collapsed d-flex justify-content-between align-items-center"
               href="#menu-ticket" data-bs-toggle="collapse" aria-expanded="false">
              <div><i class="mdi mdi-lifebuoy menu-icon"></i> Generar Ticket</div>
              <i class="mdi mdi-chevron-right toggle-icon"></i>
            </a>
            <div class="collapse" id="menu-ticket">
              <ul class="nav flex-column sub-menu ps-4">
                <li><a class="nav-link py-1" href="{{ route('incidentes.index') }}">Incidente</a></li>
                <li><a class="nav-link py-1" href="{{ route('requerimientos.index') }}">Requerimiento</a></li>
              </ul>
            </div>
          </li>

          <!-- ===== PERFIL / CUENTA ===== -->
          <li class="nav-item mt-4">
            <a class="nav-link d-flex justify-content-between align-items-center"
               href="#menu-perfil" data-bs-toggle="collapse" aria-expanded="false" role="button">
              <div class="d-flex align-items-center">
                <i class="mdi mdi-account-circle menu-icon"></i>
                <span>Cuenta</span>
              </div>
              <i class="mdi mdi-chevron-right toggle-icon"></i>
            </a>

            <div class="collapse" id="menu-perfil" data-bs-parent="#sidebar">
              <div class="card bg-transparent border-0 p-3">
                <div class="d-flex align-items-center mb-2">
                  <img src="{{ asset('img/B/face8.png') }}" alt="profile" class="rounded-circle" style="width:44px;height:44px;object-fit:cover;">
                  <div class="ms-3">
                    <div class="fw-bold">{{ Auth::user()->name ?? 'Usuario' }}</div>
                    <div class="text-muted small">{{ Auth::user()->email ?? '' }}</div>
                  </div>
                </div>

                <ul class="list-unstyled mb-0">
                  <li>
                    <a href="#" class="d-block py-1 text-decoration-none text-dark">
                      <i class="mdi mdi-account-outline me-2"></i> Ver Perfil
                    </a>
                  </li>
                  <li class="mt-2">
                    <form method="POST" action="{{ route('logout') }}">
                      @csrf
                      <button type="submit" class="btn btn-sm btn-outline-danger w-100 d-flex align-items-center justify-content-center">
                        <i class="mdi mdi-power me-2"></i> Cerrar sesión
                      </button>
                    </form>
                  </li>
                </ul>
              </div>
            </div>
          </li>
        </ul>
      </nav>

      <!-- 🔹 CONTENIDO -->
      @yield('content')

      <!-- 🔹 FOOTER -->
      <footer class="footer text-center text-muted">
        © {{ date('Y') }} OpcionHelp. Todos los derechos reservados · Área TI.
      </footer>
    </div>
  </div>

  <!-- 🔹 Scripts -->
  <script src="{{ asset('staradmin-2-free/src/assets/vendors/js/vendor.bundle.base.js') }}"></script>
  <script src="{{ asset('staradmin-2-free/src/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
  <script src="{{ asset('staradmin-2-free/src/assets/js/off-canvas.js') }}"></script>
  <script src="{{ asset('staradmin-2-free/src/assets/js/settings.js') }}"></script>
  <script src="{{ asset('staradmin-2-free/src/assets/js/hoverable-collapse.js') }}"></script>
  <script src="{{ asset('staradmin-2-free/src/assets/js/todolist.js') }}"></script>

  @stack('scripts')
</body>
</html>
