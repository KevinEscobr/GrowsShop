@extends('layouts.app')

@section('title', 'Contacto & Asesoría | GrowShop')

@section('content')
<main class="pb-6" style="min-height: 85vh;">
    <section class="container py-6">
        <div class="mb-5 text-center">
            <span class="badge bg-success bg-opacity-25 text-success border border-success border-opacity-25 px-3 py-1 rounded-pill mb-2">
                <i class="bi bi-chat-dots me-1"></i> Atención Especializada
            </span>
            <h1 class="section-title mb-2">Hablemos de tu Cultivo</h1>
            <p class="text-secondary mb-0 mx-auto" style="max-width: 600px;">
                Asesoría técnica personalizada para potenciar tu producción, elegir nutrientes o resolver dudas técnicas. Escríbenos y te responderemos a la brevedad.
            </p>
        </div>

        <div class="row g-4 g-lg-5">
            <!-- Info de contacto -->
            <div class="col-12 col-lg-5 d-flex flex-column gap-4">
                <div class="feature-card h-100">
                    <h5 class="fw-bold mb-3 d-flex align-items-center gap-2">
                        <i class="bi bi-geo-alt-fill text-success"></i> Datos de Contacto
                    </h5>
                    <ul class="list-unstyled small mb-0 d-flex flex-column gap-3">
                        <li class="d-flex gap-3 align-items-start">
                            <div class="icon-gradient" style="font-size:1.4rem; width:2.6rem; height:2.6rem;"><i class="bi bi-geo-alt"></i></div>
                            <div>
                                <div class="fw-bold">Ubicación y Despachos</div>
                                <div class="text-secondary">Envíos a todo Chile con empaque 100% discreto</div>
                            </div>
                        </li>
                        <li class="d-flex gap-3 align-items-start">
                            <div class="icon-gradient" style="font-size:1.4rem; width:2.6rem; height:2.6rem;"><i class="bi bi-envelope"></i></div>
                            <div>
                                <div class="fw-bold">Correo Electrónico</div>
                                <a href="mailto:soporte@growshop.cl" class="text-gradient fw-semibold">soporte@growshop.cl</a>
                            </div>
                        </li>
                        <li class="d-flex gap-3 align-items-start">
                            <div class="icon-gradient" style="font-size:1.4rem; width:2.6rem; height:2.6rem;"><i class="bi bi-whatsapp"></i></div>
                            <div>
                                <div class="fw-bold">WhatsApp Directo</div>
                                <a href="https://wa.me/56912345678" target="_blank" class="text-gradient fw-semibold">+56 9 1234 5678</a>
                            </div>
                        </li>
                        <li class="d-flex gap-3 align-items-start">
                            <div class="icon-gradient" style="font-size:1.4rem; width:2.6rem; height:2.6rem;"><i class="bi bi-clock"></i></div>
                            <div>
                                <div class="fw-bold">Horario de Atención</div>
                                <div class="text-secondary">Lunes a Viernes: 9:00 a 19:00 • Sábados: 10:00 a 15:00</div>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="feature-card">
                    <h6 class="fw-bold mb-3">Atajos Rápidos</h6>
                    <div class="d-grid gap-2">
                        <a class="btn btn-gradient btn-sm" href="{{ url('/shop') }}">
                            <i class="bi bi-bag-check me-1"></i> Ir al Catálogo
                        </a>
                        <a class="btn btn-outline-theme btn-sm" href="{{ url('/') }}#destacados">
                            <i class="bi bi-star me-1"></i> Ver Productos Destacados
                        </a>
                        <a class="btn btn-outline-theme btn-sm" href="https://wa.me/56912345678" target="_blank">
                            <i class="bi bi-whatsapp me-1 text-success"></i> Chatear por WhatsApp
                        </a>
                    </div>
                </div>
            </div>

            <!-- Formulario de Contacto -->
            <div class="col-12 col-lg-7">
                <div class="glass p-4 p-md-5 rounded-4 h-100 shadow-sm">
                    <h3 class="h4 fw-bold mb-4 d-flex align-items-center gap-2">
                        <i class="bi bi-envelope-paper-fill text-success"></i> Envíanos un Mensaje
                    </h3>
                    <form id="contactForm" novalidate class="contact-form">
                        <div class="mb-3">
                            <label for="name" class="form-label small fw-semibold">Nombre Completo</label>
                            <input type="text" class="form-control gs-input" id="name" name="name" placeholder="Tu nombre" required minlength="2" />
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label small fw-semibold">Correo Electrónico</label>
                            <input type="email" class="form-control gs-input" id="email" name="email" placeholder="tu@email.com" required />
                        </div>
                        <div class="mb-3">
                            <label for="topic" class="form-label small fw-semibold">Asunto o Consulta</label>
                            <select id="topic" name="topic" class="form-select gs-input" required>
                                <option value="" selected disabled>Selecciona el motivo</option>
                                <option value="asesoria">Asesoría de cultivo (nutrientes, sustratos)</option>
                                <option value="pedido">Estado de mi pedido / despacho</option>
                                <option value="producto">Consulta de stock o producto</option>
                                <option value="otro">Otras consultas</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label small fw-semibold">Mensaje o Detalle</label>
                            <textarea id="message" class="form-control gs-input" name="message" rows="5" placeholder="Cuéntanos en qué podemos ayudarte..." required minlength="10"></textarea>
                        </div>
                        <div class="d-flex flex-column flex-sm-row gap-3 align-items-sm-center justify-content-between mb-3 pt-2">
                            <div class="form-check gs-checkbox m-0 small text-secondary">
                                <input class="form-check-input" type="checkbox" value="1" id="privacyCheck" required checked>
                                <label class="form-check-label user-select-none" for="privacyCheck">
                                    Acepto el tratamiento de datos y privacidad.
                                </label>
                            </div>
                            <button type="submit" class="btn btn-gradient px-4 fw-semibold shadow-sm">
                                <i class="bi bi-send me-1"></i> Enviar Mensaje
                            </button>
                        </div>
                        <div id="errorMessage" class="alert alert-danger py-2 px-3 small d-none"></div>
                        <div id="successMessage" class="alert alert-success py-3 px-3 small d-none rounded-3 d-flex align-items-center gap-2">
                            <i class="bi bi-check-circle-fill fs-5"></i>
                            <div>¡Gracias por tu mensaje! Nos pondremos en contacto contigo dentro de las próximas 24 horas.</div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('contactForm');
        const successBox = document.getElementById('successMessage');
        if (!form) return;
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            if (successBox) {
                successBox.classList.remove('d-none');
            }
            form.reset();
        });
    });
</script>
@endsection
