<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item">
      <a class="nav-link" href="{{ route('home') }}">
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

    <!-- ✅ Generar Ticket -->
    <li class="nav-item">
      <a class="nav-link d-flex align-items-center justify-content-between"
         href="#menu-ticket"
         data-bs-toggle="collapse"
         role="button"
         aria-expanded="false"
         aria-controls="menu-ticket">
        <div>
          <i class="menu-icon mdi mdi-cellphone-link"></i>
          <span class="menu-title">Generar Ticket</span>
        </div>
        <i class="mdi mdi-chevron-right menu-arrow"></i>
      </a>

      <div class="collapse" id="menu-ticket" data-bs-parent="#sidebar">
        <ul class="nav flex-column sub-menu ps-4">
          <li class="nav-item">
            <a class="nav-link" href="#">Incidente</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Requerimiento</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Typography</a>
          </li>
        </ul>
      </div>
    </li>
  </ul>
</nav>
