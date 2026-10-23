<footer class="footer pt-5 mt-5">
    <div class="container">
        <div class="row g-4 mb-4">
            <div class="col-12 col-md-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="brand-icon" style="width: 32px; height: 32px; font-size: 1.1rem;">
                        <i class="bi bi-flower3"></i>
                    </div>
                    <span class="fw-bold fs-5 brand-text">GrowShop</span>
                </div>
                <p class="small text-secondary mb-3">Insumos, medios de cultivo, iluminación LED y tecnología especializada para maximizar el rendimiento de tus plantas.</p>
                <div class="d-flex gap-2">
                    <a href="https://www.facebook.com" target="_blank" aria-label="Facebook" class="social-link">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="https://www.instagram.com" target="_blank" aria-label="Instagram" class="social-link">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="https://www.twitter.com" target="_blank" aria-label="Twitter" class="social-link">
                        <i class="bi bi-twitter-x"></i>
                    </a>
                </div>
            </div>
            <div class="col-6 col-md-2">
                <h6 class="fw-bold mb-3">Secciones</h6>
                <ul class="list-unstyled small m-0 footer-links d-flex flex-column gap-2">
                    <li><a href="{{ url('/') }}" class="footer-link">Inicio</a></li>
                    <li><a href="{{ url('/shop') }}" class="footer-link">Tienda</a></li>
                    <li><a href="{{ url('/contact') }}" class="footer-link">Contacto</a></li>
                </ul>
            </div>
            <div class="col-6 col-md-3">
                <h6 class="fw-bold mb-3">Soporte</h6>
                <ul class="list-unstyled small m-0 footer-links d-flex flex-column gap-2">
                    <li><a href="#" class="footer-link">Preguntas frecuentes</a></li>
                    <li><a href="#" class="footer-link">Envíos y Despachos</a></li>
                    <li><a href="#" class="footer-link">Garantía y Devoluciones</a></li>
                </ul>
            </div>
            <div class="col-12 col-md-3">
                <h6 class="fw-bold mb-3">Atención Directa</h6>
                <ul class="list-unstyled small text-secondary m-0 d-flex flex-column gap-2">
                    <li class="d-flex align-items-center gap-2">
                        <i class="bi bi-envelope text-success"></i> 
                        <span>soporte@growshop.cl</span>
                    </li>
                    <li class="d-flex align-items-center gap-2">
                        <i class="bi bi-whatsapp text-success"></i> 
                        <span>+56 9 1234 5678</span>
                    </li>
                    <li class="d-flex align-items-center gap-2">
                        <i class="bi bi-geo-alt text-success"></i> 
                        <span>Santiago, Chile</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="border-top border-opacity-10 pt-4 pb-4 d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2 small text-secondary">
            <span>&copy; {{ date('Y') }} GrowShop. Todos los derechos reservados.</span>
            <span>Cultivo profesional, seguro y eficiente</span>
        </div>
    </div>
</footer>
