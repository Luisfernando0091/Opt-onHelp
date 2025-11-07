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
    <link rel="stylesheet" href="{{ asset('staradmin-2-free/src/assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('staradmin-2-free/src/assets/css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('staradmin-2-free/src/assets/images/favicon.png') }}" />

    @stack('styles')
</head>

<body>
    <div id="app">
        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- ✅ Dependencias principales -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- ✅ StarAdmin JS -->
    <script src="{{ asset('staradmin-2-free/src/assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('staradmin-2-free/src/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('staradmin-2-free/src/assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('staradmin-2-free/src/assets/js/template.js') }}"></script>
    <script src="{{ asset('staradmin-2-free/src/assets/js/settings.js') }}"></script>
    <script src="{{ asset('staradmin-2-free/src/assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('staradmin-2-free/src/assets/js/todolist.js') }}"></script>

    <!-- ⚠️ Elimina dashboard.js porque genera errores -->
    {{-- <script src="{{ asset('staradmin-2-free/src/assets/js/dashboard.js') }}"></script> --}}

    <!-- ✅ Fix para el dropdown del perfil -->
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        const dropdowns = document.querySelectorAll('[data-bs-toggle="dropdown"]');
        dropdowns.forEach(el => {
          new bootstrap.Dropdown(el);
        });
      });
    </script>

    @stack('scripts')
</body>
</html>
