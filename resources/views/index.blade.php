@extends('layouts.app')

@section('content')
  <!-- Hero -->
  <header class="hero position-relative d-flex align-items-center justify-content-center overflow-hidden">
    <video class="hero-video" autoplay muted loop playsinline>
      <source src="{{ asset('assets/video/plants.mp4') }}" type="video/mp4">
    </video>
    <div class="hero-overlay"></div>
    <div class="container position-relative text-center hero-content py-5">
      <span class="badge bg-success bg-opacity-25 text-success border border-success border-opacity-25 px-3 py-2 rounded-pill mb-3 fade-in-delay">
        <i class="bi bi-stars me-1"></i> Expertos en Cultivo & Autocultivo
      </span>
      <h1 class="display-3 fw-bold mb-3 fade-in-delay">Cultiva. Optimiza. Disfruta.</h1>
      <p class="lead mb-4 fade-in-delay2 mx-auto" style="max-width: 650px;">
        Nutrientes de alta gama, iluminación LED eficiente y sustratos balanceados para un crecimiento vigoroso y potente.
      </p>
      <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
        <a href="{{ url('/shop') }}" class="btn btn-gradient btn-lg px-4 shadow">
          <i class="bi bi-bag-fill me-1"></i> Entrar a la Tienda
        </a>
        <a href="#destacados" class="btn btn-outline-theme btn-lg px-4 scroll-link">
          <i class="bi bi-arrow-down-circle me-1"></i> Ver Destacados
        </a>
      </div>
    </div>
    <div class="scroll-indicator small">Desliza para explorar</div>
  </header>

  <!-- Beneficios -->
  <section class="py-5 section-alt border-top border-bottom border-opacity-10">
    <div class="container">
      <div class="row row-cols-2 row-cols-md-4 g-3 g-md-4 text-center justify-content-center benefits-row">
        <div class="col">
          <div class="mini-feature reveal">
            <i class="bi bi-flower3 icon-gradient" aria-hidden="true"></i>
            <p>100% Orgánico</p>
            <span class="text-secondary small">Certificación eco</span>
          </div>
        </div>
        <div class="col">
          <div class="mini-feature reveal">
            <i class="bi bi-lightning-charge-fill icon-gradient"></i>
            <p>Máxima Potencia</p>
            <span class="text-secondary small">Cosechas abundantes</span>
          </div>
        </div>
        <div class="col">
          <div class="mini-feature reveal">
            <i class="bi bi-truck icon-gradient"></i>
            <p>Envíos Rápidos</p>
            <span class="text-secondary small">Empaque 100% discreto</span>
          </div>
        </div>
        <div class="col">
          <div class="mini-feature reveal">
            <i class="bi bi-chat-dots-fill icon-gradient"></i>
            <p>Asesoría Experta</p>
            <span class="text-secondary small">Soporte por WhatsApp</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Destacados -->
  <section id="destacados" class="py-6 container">
    <div class="text-center mb-5">
      <h2 class="section-title reveal">Líneas Destacadas</h2>
      <p class="text-secondary mb-0 reveal">Productos seleccionados para maximizar la salud y rendimiento de tu cultivo</p>
    </div>
    <div class="row g-4">
      @foreach($featuredProducts as $product)
      <div class="col-12 col-md-4">
        <article class="feature-card reveal">
          <div class="img-wrapper">
            <img src="{{ \Illuminate\Support\Str::startsWith($product->image, ['http', 'https']) ? $product->image : asset($product->image ?? 'assets/img/placeholder.webp') }}" 
                 alt="{{ $product->name }}" 
                 class="img-zoom" />
            <span class="badge bg-success bg-opacity-75 text-white position-absolute top-0 end-0 m-3 px-2 py-1 rounded-pill small">
              Destacado
            </span>
          </div>
          <div class="d-flex flex-column flex-grow-1">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <span class="badge bg-secondary bg-opacity-25 text-secondary rounded-pill small">
                {{ $product->category ?? 'Cultivo' }}
              </span>
              <span class="fs-5 fw-bold text-gradient">
                ${{ number_format($product->price, 0, ',', '.') }}
              </span>
            </div>
            <h5 class="fw-bold mb-2">{{ $product->name }}</h5>
            <p class="small text-secondary text-truncate-2 flex-grow-1 mb-3">{{ $product->description }}</p>
            <div class="d-flex gap-2">
              <a href="{{ url('/shop') }}#product-{{ $product->id }}" class="btn btn-gradient btn-sm flex-grow-1">
                <i class="bi bi-cart-plus me-1"></i> Comprar
              </a>
              <a href="{{ url('/shop') }}#product-{{ $product->id }}" class="btn btn-outline-theme btn-sm px-3">
                <i class="bi bi-eye"></i>
              </a>
            </div>
          </div>
        </article>
      </div>
      @endforeach
      
      @if($featuredProducts->isEmpty())
      <div class="col-12 text-center py-5">
        <p class="text-secondary">Próximamente nuevos productos destacados.</p>
        <a href="{{ url('/shop') }}" class="btn btn-gradient">Ver catálogo en tienda</a>
      </div>
      @endif
    </div>
  </section>

  <!-- CTA Banner -->
  <section class="py-6 position-relative gradient-band text-white overflow-hidden my-4 mx-3 rounded-4 shadow-lg">
    <div class="container text-center position-relative py-3">
      <span class="badge bg-white bg-opacity-25 text-white px-3 py-2 rounded-pill mb-3">
        <i class="bi bi-shield-check me-1"></i> Compra Segura & Despachos a Todo Chile
      </span>
      <h2 class="display-5 fw-bold mb-3 text-white">¿Listo para optimizar tu cultivo hoy?</h2>
      <p class="lead mb-4 text-white-50 mx-auto" style="max-width: 600px;">
        Arma tu carrito, cotiza directamente y recibe atención personalizada paso a paso.
      </p>
      <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
        <a href="{{ url('/shop') }}" class="btn btn-light btn-lg px-5 fw-bold shadow">
          <i class="bi bi-shop me-1 text-success"></i> Ir al Catálogo Completo
        </a>
        <a href="{{ url('/contact') }}" class="btn btn-outline-light btn-lg px-4 fw-semibold">
          <i class="bi bi-whatsapp me-1"></i> Contactar Asesor
        </a>
      </div>
    </div>
  </section>
@endsection
