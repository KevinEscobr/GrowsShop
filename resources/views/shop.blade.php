@extends('layouts.app')

@section('title', 'Tienda & Catálogo | GrowShop')

@section('content')
<main class="pt-5" style="min-height: 85vh;">
    <section class="container py-6">
        
        <!-- Encabezado de la Tienda -->
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-4 mb-4">
            <div>
                <span class="badge bg-success bg-opacity-25 text-success border border-success border-opacity-25 px-3 py-1 rounded-pill mb-2">
                    <i class="bi bi-boxes me-1"></i> Catálogo Completo
                </span>
                <h1 class="section-title mb-1">Nuestra Tienda</h1>
                <p class="text-secondary mb-0 small">Explora nuestros productos de primera calidad y realiza tu pedido al instante.</p>
            </div>

            <!-- Barra de Búsqueda y Ordenamiento -->
            <div class="d-flex flex-wrap gap-2 align-items-center">
                <div class="position-relative" style="min-width: 240px;">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-secondary"></i>
                    <input id="searchInput" 
                           type="search" 
                           class="form-control gs-filter-input ps-5" 
                           placeholder="Buscar producto...">
                </div>

                <select id="sortSelect" class="form-select gs-filter-select" style="min-width: 160px;">
                    <option value="default">Ordenar por...</option>
                    <option value="priceAsc">Menor Precio</option>
                    <option value="priceDesc">Mayor Precio</option>
                    <option value="nameAsc">Nombre A - Z</option>
                </select>
            </div>
        </div>

        <!-- Chips de Categorías Dinámicos -->
        <div class="category-chips-wrapper" id="categoryChips">
            <button class="category-chip active" data-category="all">
                <i class="bi bi-grid-fill"></i> Todos
            </button>
            @foreach($products->pluck('category')->unique() as $cat)
                @if($cat)
                    <button class="category-chip" data-category="{{ $cat }}">
                        {{ $cat }}
                    </button>
                @endif
            @endforeach
        </div>

        <!-- Grid de Productos -->
        <div id="productsGrid" class="row g-4">
            <!-- Cargado dinámicamente desde /api/products con feedback -->
            <div class="col-12 text-center py-5">
                <div class="spinner-border text-success" role="status">
                    <span class="visually-hidden">Cargando productos...</span>
                </div>
                <p class="text-secondary small mt-3">Cargando catálogo en tiempo real...</p>
            </div>
        </div>

    </section>
</main>
@endsection
