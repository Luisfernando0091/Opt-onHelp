<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>@yield('title', 'OpcionHelp')</title>

  <!-- CSS del template StarAdmin -->


  <link rel="stylesheet" href="{{ asset('staradmin-2-free/src/assets/vendors/feather/feather.css') }}">
  <link rel="stylesheet" href="{{ asset('staradmin-2-free/src/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('staradmin-2-free/src/assets/vendors/ti-icons/css/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('staradmin-2-free/src/assets/vendors/font-awesome/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('staradmin-2-free/src/assets/vendors/css/vendor.bundle.base.css') }}">
  <link rel="stylesheet" href="{{ asset('staradmin-2-free/src/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
  <link rel="stylesheet" href="{{ asset('staradmin-2-free/src/assets/css/style.css') }}">
  <link rel="shortcut icon" href="{{ asset('staradmin-2-free/src/assets/images/favicon.png') }}" />

  @stack('styles')
</head>

<body>
  <div class="container-scroller">

    {{-- 🔹 Navbar superior --}}
    @include('partials.navbar')

    <div class="container-fluid page-body-wrapper">

      {{-- 🔹 Sidebar lateral --}}
      @include('partials.sidebar')

      {{-- 🔹 Contenido dinámico --}}
      <div class="main-panel">
        <div class="content-wrapper">
          @yield('content')
        </div>

        {{-- 🔹 Footer --}}
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

  <!-- JS del template -->
  <script src="{{ asset('staradmin-2-free/src/assets/vendors/js/vendor.bundle.base.js') }}"></script>
  <script src="{{ asset('staradmin-2-free/src/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
  <script src="{{ asset('staradmin-2-free/src/assets/js/off-canvas.js') }}"></script>
  <script src="{{ asset('staradmin-2-free/src/assets/js/template.js') }}"></script>
  <script src="{{ asset('staradmin-2-free/src/assets/js/settings.js') }}"></script>
  <script src="{{ asset('staradmin-2-free/src/assets/js/hoverable-collapse.js') }}"></script>
  <script src="{{ asset('staradmin-2-free/src/assets/js/todolist.js') }}"></script>

  @stack('scripts')
</body>
</html>
