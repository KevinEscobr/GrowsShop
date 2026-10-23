<nav class="navbar navbar-expand-lg gs-navbar fixed-top">
  <div class="container">
    <a class="navbar-brand" href="{{ url('/') }}">
      <div class="brand-icon">
        <i class="bi bi-flower3"></i>
      </div>
      <span class="brand-text">GrowShop</span>
    </a>

    <!-- Botón móvil para colapsar menú -->
    <button class="navbar-toggler border-0 p-2 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Navegación">
      <i class="bi bi-list fs-2 text-secondary"></i>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav ms-auto align-items-lg-center gap-1 gap-lg-2 my-2 my-lg-0">
        <li class="nav-item">
          <a class="nav-link gs-nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
            Inicio
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link gs-nav-link {{ request()->is('shop*') ? 'active' : '' }}" href="{{ url('/shop') }}">
            Tienda
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link gs-nav-link {{ request()->is('contact') ? 'active' : '' }}" href="{{ url('/contact') }}">
            Contacto
          </a>
        </li>
        

        @auth
        <li class="nav-item">
          <a href="{{ route('products.index') }}" class="nav-link gs-nav-link {{ request()->is('dashboard*') ? 'active' : '' }}">
            <i class="bi bi-boxes me-1 text-success"></i> Inventario
          </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 gs-nav-link" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="badge bg-success bg-opacity-25 text-success border border-success border-opacity-25 py-1 px-2 rounded-pill">
              <i class="bi bi-person-fill me-1"></i> {{ Auth::user()->name }}
            </span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end glass border border-opacity-10 shadow" aria-labelledby="adminDropdown">
            <li><a class="dropdown-item small" href="{{ route('products.index') }}"><i class="bi bi-boxes me-2 text-success"></i> Panel Inventario</a></li>
            <li><a class="dropdown-item small" href="{{ route('products.create') }}"><i class="bi bi-plus-circle me-2 text-info"></i> Agregar Producto</a></li>
            <li><hr class="dropdown-divider border-opacity-10"></li>
            <li>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item small text-danger">
                  <i class="bi bi-box-arrow-right me-2"></i> Cerrar Sesión
                </button>
              </form>
            </li>
          </ul>
        </li>
        @endauth

        <!-- Toggle Modo Oscuro / Claro y Carrito -->
        <li class="nav-item d-flex align-items-center gap-2 ms-lg-2 pt-2 pt-lg-0">
          <!-- Botón Switch Tema -->
          <button id="themeToggleBtn" class="theme-toggle-btn" type="button" aria-label="Cambiar a modo claro/oscuro" title="Cambiar tema">
            <i class="bi bi-sun-fill theme-icon-sun"></i>
            <i class="bi bi-moon-stars-fill theme-icon-moon"></i>
          </button>

          <!-- Botón Carrito con Contador Dinámico -->
          <a href="#cartCanvas" data-bs-toggle="offcanvas" class="btn btn-sm btn-gradient fw-semibold d-inline-flex align-items-center gap-1.5 shadow-sm" aria-label="Abrir Carrito">
            <i class="bi bi-bag"></i>
            <span>Carrito</span>
            <span id="navCartCount" class="badge bg-white text-dark rounded-pill px-1.5 py-0.5 ms-1 fw-bold d-none" style="font-size: 0.72rem;">0</span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
