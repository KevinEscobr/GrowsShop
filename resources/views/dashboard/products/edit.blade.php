@extends('layouts.app')

@section('title', 'Editar Producto | Dashboard')

@section('content')
<main class="pt-5" style="min-height: 85vh;">
    <section class="container py-6">
        <div class="mb-4" style="max-width: 760px; margin: 0 auto;">
            <a href="{{ route('products.index') }}" class="btn btn-outline-theme btn-sm mb-3">
                <i class="bi bi-arrow-left me-1"></i> Volver al inventario
            </a>
            <h1 class="section-title mb-1">Editar Producto</h1>
            <p class="text-secondary small mb-0">Actualiza las existencias, precios o detalles de "{{ $product->name }}"</p>
        </div>

        <div class="glass p-4 p-md-5 rounded-4 shadow-sm" style="max-width: 760px; margin: 0 auto;">
            <form action="{{ route('products.update', $product) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-4">
                    <div class="col-md-8">
                        <label class="form-label small fw-semibold">
                            <i class="bi bi-tag-fill text-success me-1"></i> Nombre del Producto
                        </label>
                        <input type="text" name="name" class="form-control gs-input" required value="{{ $product->name }}" autofocus>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small fw-semibold">
                            <i class="bi bi-folder-fill text-success me-1"></i> Categoría
                        </label>
                        <input type="text" name="category" class="form-control gs-input" value="{{ $product->category }}" list="categoriesList">
                        <datalist id="categoriesList">
                            <option value="Sustratos">
                            <option value="Nutrientes">
                            <option value="Iluminación">
                            <option value="Accesorios">
                            <option value="Semillas">
                        </datalist>
                    </div>

                    <div class="col-12">
                        <label class="form-label small fw-semibold">
                            <i class="bi bi-card-text text-success me-1"></i> Descripción
                        </label>
                        <textarea name="description" class="form-control gs-input" rows="4">{{ $product->description }}</textarea>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small fw-semibold">
                            <i class="bi bi-cash-stack text-success me-1"></i> Precio ($ CLP)
                        </label>
                        <input type="number" name="price" class="form-control gs-input" required min="0" step="100" value="{{ $product->price }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small fw-semibold">
                            <i class="bi bi-boxes text-success me-1"></i> Stock Actual
                        </label>
                        <input type="number" name="stock" class="form-control gs-input" required min="0" value="{{ $product->stock }}">
                    </div>

                    <div class="col-md-4 d-flex align-items-end">
                        <div class="form-check gs-checkbox mb-2">
                            <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured" {{ $product->is_featured ? 'checked' : '' }}>
                            <label class="form-check-label small fw-semibold user-select-none" for="is_featured">
                                <i class="bi bi-star-fill text-warning me-1"></i> Destacado
                            </label>
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label small fw-semibold">
                            <i class="bi bi-image text-success me-1"></i> Imagen del Producto
                        </label>
                        <input type="text" name="image" class="form-control gs-input" value="{{ $product->image }}">
                        <div class="form-text text-secondary x-small mt-1">
                            Link directo de imagen (http/https) o una ruta local.
                        </div>
                    </div>

                    <div class="col-12 mt-4 pt-3 border-top border-opacity-10 d-flex gap-3">
                        <button type="submit" class="btn btn-gradient flex-grow-1 shadow">
                            <i class="bi bi-check-circle me-1"></i> Actualizar Producto
                        </button>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-theme px-4">
                            Cancelar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </section>
</main>
@endsection
