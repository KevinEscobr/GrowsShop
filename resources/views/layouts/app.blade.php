<!DOCTYPE html>
<html lang="es" data-theme="dark" data-bs-theme="dark">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title', 'GrowShop - Cultiva con Estilo')</title>
  <meta name="description" content="GrowShop: Insumos, sustratos, fertilizantes y tecnología para tus cultivos." />
  <meta name="theme-color" content="#0c0f12" id="metaThemeColor">

  <!-- Prevención instantánea de FOUC (Flash of Unstyled Content) de tema -->
  <script>
    (function() {
      try {
        const stored = localStorage.getItem('gs_theme');
        const sysDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        const theme = stored || (sysDark ? 'dark' : 'light');
        document.documentElement.setAttribute('data-theme', theme);
        document.documentElement.setAttribute('data-bs-theme', theme);
      } catch (e) {}
    })();
  </script>

  <!-- Google Fonts: Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Bootstrap 5.3 & Icons -->
  <link rel="preconnect" href="https://cdn.jsdelivr.net" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

  <!-- GrowShop Theme Stylesheet -->
  <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}?v=3.0" />
  @yield('styles')
</head>
<body>
  
  @include('components.navbar')

  <main>
    @yield('content')
  </main>

  @include('components.footer')

  <!-- Offcanvas Carrito Ultra Moderno -->
  <div class="offcanvas offcanvas-end cart-panel shadow-lg" tabindex="-1" id="cartCanvas" aria-labelledby="cartCanvasLabel">
    <!-- Header del Carrito -->
    <div class="offcanvas-header cart-drawer-header d-flex align-items-center justify-content-between">
      <div class="d-flex align-items-center gap-2">
        <div class="cart-drawer-icon">
          <i class="bi bi-bag-check-fill"></i>
        </div>
        <div>
          <h5 class="offcanvas-title fw-bold mb-0 lh-1" id="cartCanvasLabel">Mi Carrito</h5>
          <span class="text-secondary small" id="cartSubtitle">GrowShop Chile</span>
        </div>
      </div>
      <div class="d-flex align-items-center gap-2">
        <span class="badge cart-count-pill" id="cartHeaderCount">0 ítems</span>
        <button type="button" class="btn-close cart-close-btn" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
      </div>
    </div>

    <!-- Barra Dinámica de Envío Gratis -->
    <div class="shipping-meter-box" id="shippingMeterContainer">
      <div class="shipping-meter-header">
        <i class="bi bi-truck text-success fs-6"></i>
        <span id="shippingMeterText" class="fw-semibold">Calculando envío...</span>
      </div>
      <div class="shipping-meter-track">
        <div class="shipping-meter-fill" id="shippingMeterBar" style="width: 0%;"></div>
      </div>
    </div>

    <!-- Cuerpo del Carrito (Scrollable) -->
    <div class="offcanvas-body d-flex flex-column p-0">
      <div id="cartItems" class="cart-items-container flex-grow-1">
        <!-- Renderizado dinámicamente por cart.js -->
      </div>

      <!-- Resumen y Acciones del Carrito -->
      <div class="cart-drawer-footer">
        <div class="cart-summary-line">
          <span>Subtotal</span>
          <span id="cartSubtotal" class="fw-semibold text-body">$0</span>
        </div>
        <div class="cart-summary-line">
          <span>Despacho</span>
          <span id="cartShippingBadge" class="badge bg-secondary bg-opacity-25 text-secondary">Calculado al checkout</span>
        </div>
        <div class="cart-summary-line">
          <span>IVA Estimado (19%)</span>
          <span id="cartTax" class="fw-semibold text-body">$0</span>
        </div>
        <div class="cart-summary-line total-line">
          <span>Total Estimado</span>
          <span id="cartTotal" class="text-gradient fs-4">$0</span>
        </div>

        <div class="d-grid gap-2">
          <button id="whatsappBtn" class="btn btn-whatsapp py-2.5 shadow-sm">
            <i class="bi bi-whatsapp fs-5"></i> Pedir por WhatsApp
          </button>
          <div class="d-flex gap-2">
            <button id="checkoutBtn" class="btn btn-outline-theme btn-sm flex-grow-1">
              <i class="bi bi-credit-card me-1"></i> Pagar con Tarjeta (Demo)
            </button>
            <button id="clearCartBtn" class="btn btn-outline-danger btn-sm px-3" title="Vaciar carrito" aria-label="Vaciar carrito">
              <i class="bi bi-trash3"></i>
            </button>
          </div>
        </div>

        <!-- Badges de Confianza -->
        <div class="cart-trust-badges">
          <div class="cart-trust-badge">
            <i class="bi bi-box-seam text-success"></i> Empaque Discreto
          </div>
          <div class="cart-trust-badge">
            <i class="bi bi-shield-check text-info"></i> Compra Segura
          </div>
          <div class="cart-trust-badge">
            <i class="bi bi-truck text-warning"></i> Todo Chile
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Pasarela Demo Adaptable al Tema (Global) -->
  <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content glass border border-opacity-10 shadow-lg">
        <div class="modal-header border-bottom border-opacity-10">
          <h5 class="modal-title fw-bold d-flex align-items-center gap-2" id="paymentModalLabel">
            <i class="bi bi-shield-check text-success fs-4"></i> Pago Simulado (Demo)
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body small">
          <p class="text-secondary mb-3">Integración con Transbank Webpay, MercadoPago y Khipu con confirmación instantánea.</p>
          <div class="p-3 rounded-3 bg-body-tertiary border border-opacity-10 mb-3">
            <span class="fw-bold d-block mb-2">Resumen de tu pedido:</span>
            <ul id="paymentSummary" class="list-unstyled mb-0 d-flex flex-column gap-1 text-secondary"></ul>
          </div>
          <div class="d-flex justify-content-between align-items-center fs-5 fw-bold p-3 rounded-3 bg-success bg-opacity-10 text-success border border-success border-opacity-25">
            <span>Total a Pagar:</span>
            <span id="paymentTotal">$0</span>
          </div>
        </div>
        <div class="modal-footer border-top border-opacity-10">
          <button type="button" class="btn btn-outline-theme btn-sm" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-gradient btn-sm" onclick="alert('¡Compra de demostración simulada con éxito!')">
            <i class="bi bi-check-circle me-1"></i> Simular Aprobación
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal para agrandar imágenes -->
  <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content bg-transparent border-0">
        <div class="modal-body p-0 text-center position-relative">
          <button type="button" class="btn-close position-absolute top-0 end-0 m-3 shadow-lg bg-white rounded-circle p-2" data-bs-dismiss="modal" aria-label="Cerrar" style="z-index: 10;"></button>
          <img src="" id="modalImage" class="img-fluid rounded-4 shadow-lg" alt="Zoom">
        </div>
      </div>
    </div>
  </div>

  <!-- Botón flotante carrito -->
  <button class="cart-fab btn btn-gradient shadow" type="button" data-bs-toggle="offcanvas" data-bs-target="#cartCanvas" aria-label="Abrir Carrito">
    <span class="position-relative">
      <i class="bi bi-bag fs-5"></i>
      <span id="cartCountBadge" class="badge bg-danger position-absolute top-0 start-100 translate-middle p-1 d-none"></span>
    </span>
  </button>

  <script>
    document.addEventListener('click', function(e) {
      if (e.target.classList.contains('img-zoom')) {
        const modal = new bootstrap.Modal(document.getElementById('imageModal'));
        document.getElementById('modalImage').src = e.target.src;
        modal.show();
      }
    });
  </script>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('assets/js/main.js') }}?v=2.0"></script>
  <script src="{{ asset('assets/js/cart.js') }}?v=3.0"></script>
  @yield('scripts')
</body>
</html>
