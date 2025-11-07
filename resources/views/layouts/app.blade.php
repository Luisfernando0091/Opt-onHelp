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
    <div id="app">
        <main class="py-4">
            @yield('content')
        </main>
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
