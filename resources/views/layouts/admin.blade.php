<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>@yield('title', 'OpcionHelp')</title>

  <!-- ✅ CSS del template StarAdmin -->
  <link rel="stylesheet" href="{{ asset('staradmin-2-free/src/assets/vendors/feather/feather.css') }}">
  <link rel="stylesheet" href="{{ asset('staradmin-2-free/src/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('staradmin-2-free/src/assets/vendors/ti-icons/css/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('staradmin-2-free/src/assets/vendors/font-awesome/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('staradmin-2-free/src/assets/vendors/css/vendor.bundle.base.css') }}">
  <link rel="stylesheet" href="{{ asset('staradmin-2-free/src/assets/css/style.css') }}">
  <link rel="shortcut icon" href="{{ asset('staradmin-2-free/src/assets/images/favicon.png') }}" />

  @stack('styles')
</head>

<body>
  <div class="container-scroller">
    @include('partials.navbar')

    <div class="container-fluid page-body-wrapper">
      @include('partials.sidebar')

      <div class="main-panel">
        <div class="content-wrapper">
          @yield('content')
        </div>

        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">
              © {{ date('Y') }} OpcionHelp. Todos los derechos reservados.
            </span>
          </div>
        </footer>
      </div>
    </div>
  </div>

  <!-- ✅ Scripts base -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('staradmin-2-free/src/assets/vendors/js/vendor.bundle.base.js') }}"></script>

  <!-- ⚠️ Desactivamos scripts conflictivos -->
  {{-- <script src="{{ asset('staradmin-2-free/src/assets/js/template.js') }}"></script> --}}
  {{-- <script src="{{ asset('staradmin-2-free/src/assets/js/hoverable-collapse.js') }}"></script> --}}
  <script src="{{ asset('staradmin-2-free/src/assets/js/off-canvas.js') }}"></script>
  <script src="{{ asset('staradmin-2-free/src/assets/js/settings.js') }}"></script>

  <!-- ✅ Script limpio -->
  <script>
  document.addEventListener("DOMContentLoaded", function () {
    console.log("✅ DOM listo");

    // Inicializar dropdowns (perfil)
    document.querySelectorAll('[data-bs-toggle="dropdown"]').forEach(el => new bootstrap.Dropdown(el));

    // 🔹 Collapse del sidebar 100% Bootstrap
    document.querySelectorAll('.sidebar [data-bs-toggle="collapse"]').forEach(trigger => {
      trigger.addEventListener("click", function (e) {
        const targetSelector = this.getAttribute("href");
        const targetEl = document.querySelector(targetSelector);
        if (!targetEl) return;

        const isShown = targetEl.classList.contains('show');

        // Cerrar otros abiertos
        document.querySelectorAll('.sidebar .collapse.show').forEach(openMenu => {
          if (openMenu !== targetEl) {
            openMenu.classList.remove('show');
            openMenu.previousElementSibling?.querySelector('.menu-arrow')?.classList.remove('rotate');
          }
        });

        // Alternar actual
        targetEl.classList.toggle('show', !isShown);
        this.querySelector('.menu-arrow')?.classList.toggle('rotate', !isShown);

        console.log(isShown ? '🔽 Cerrando menú' : '🔼 Abriendo menú', targetSelector);
      });
    });

    console.log("✅ Script finalizado correctamente.");
  });
  </script>

  @stack('scripts')

  <style>
    /* ✅ Sidebar Collapse limpio */
    .sidebar .collapse {
      display: none;
      overflow: hidden;
      transition: all 0.3s ease;
    }
    .sidebar .collapse.show {
      display: block;
    }

    .sidebar .sub-menu {
      padding-left: 1.8rem;
      background: rgba(255,255,255,0.05);
      border-left: 2px solid #1F3BB3;
    }

    .sidebar .sub-menu .nav-link {
      font-size: 0.9rem;
      padding: 6px 16px;
    }

    .menu-arrow {
      transition: transform 0.3s ease;
    }

    .menu-arrow.rotate {
      transform: rotate(90deg);
    }
  </style>
</body>
</html>
