@extends('layouts.app')

@section('title', 'Acceso Administrador | GrowShop')

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center py-6 position-relative overflow-hidden" style="padding-top: 100px;">
    <!-- Luces ambientales de fondo -->
    <div class="position-absolute" style="top: 25%; left: 50%; transform: translate(-50%, -50%); width: 550px; height: 550px; background: radial-gradient(circle, rgba(70, 193, 105, 0.22) 0%, rgba(53, 160, 230, 0.1) 50%, transparent 70%); filter: blur(70px); pointer-events: none; z-index: 0;"></div>

    <div class="container position-relative" style="z-index: 1;">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-5 col-xl-4">
                
                <!-- Tarjeta Glassmorphic de Login Adaptable -->
                <div class="glass p-4 p-sm-5 rounded-4 shadow-lg position-relative">
                    
                    <div class="text-center mb-4">
                        <div class="auth-icon-badge">
                            <div class="auth-icon-glow"></div>
                            <div class="auth-icon-inner">
                                <i class="bi bi-shield-lock-fill"></i>
                            </div>
                        </div>
                        <h2 class="h3 fw-bold mb-1">Acceso Administrador</h2>
                        <p class="text-secondary small mb-0">Gestión de inventario y catálogo GrowShop</p>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger bg-danger bg-opacity-10 border-danger border-opacity-25 text-danger small rounded-3 mb-4 d-flex align-items-center" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                            <div>{{ $errors->first() }}</div>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success bg-success bg-opacity-10 border-success border-opacity-25 text-success small rounded-3 mb-4 d-flex align-items-center" role="alert">
                            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                            <div>{{ session('success') }}</div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
                        @csrf

                        <!-- Campo Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label small text-secondary fw-semibold mb-1 d-block">Correo Electrónico</label>
                            <div class="gs-input-group @error('email') is-invalid @enderror">
                                <span class="gs-input-icon">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input type="email" 
                                       class="gs-input-field" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       placeholder="admin@growshop.cl" 
                                       required 
                                       autofocus 
                                       autocomplete="email">
                            </div>
                        </div>

                        <!-- Campo Contraseña -->
                        <div class="mb-4">
                            <label for="password" class="form-label small text-secondary fw-semibold mb-1 d-block">Contraseña</label>
                            <div class="gs-input-group @error('password') is-invalid @enderror">
                                <span class="gs-input-icon">
                                    <i class="bi bi-key"></i>
                                </span>
                                <input type="password" 
                                       class="gs-input-field" 
                                       id="password" 
                                       name="password" 
                                       placeholder="••••••••" 
                                       required 
                                       autocomplete="current-password">
                                <button type="button" class="gs-input-action" id="togglePasswordBtn" aria-label="Mostrar contraseña">
                                    <i class="bi bi-eye" id="togglePasswordIcon"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Recordarme -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check gs-checkbox m-0 d-flex align-items-center gap-2">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label text-secondary small user-select-none" for="remember">
                                    Mantener sesión activa
                                </label>
                            </div>
                        </div>

                        <!-- Botón de Envío -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-gradient btn-lg fw-semibold shadow py-2">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Entrar al Inventario
                            </button>
                        </div>
                    </form>

                </div>

                <div class="text-center mt-4">
                    <a href="{{ url('/') }}" class="text-secondary small text-decoration-none">
                        <i class="bi bi-arrow-left me-1"></i> Volver a la Tienda
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('togglePasswordBtn');
    const passwordInput = document.getElementById('password');
    const icon = document.getElementById('togglePasswordIcon');

    if (toggleBtn && passwordInput && icon) {
        toggleBtn.addEventListener('click', function () {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    }
});
</script>
@endsection
