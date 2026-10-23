@extends('layouts.app')

@section('title', 'Control de Inventario | Dashboard')

@section('content')
<main class="pt-5" style="min-height: 85vh;">
    <section class="container py-6">
        
        <!-- Header -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="badge bg-success bg-opacity-25 text-success border border-success border-opacity-25 px-2 py-1 rounded-pill">
                        <i class="bi bi-shield-check me-1"></i> Admin Autenticado
                    </span>
                    <span class="text-secondary small">{{ Auth::user()->email }}</span>
                </div>
                <h1 class="section-title mb-1">Control de Inventario</h1>
                <p class="text-secondary small mb-0">Gestiona las existencias en bodega y el catálogo de tu GrowShop</p>
            </div>
            
            <div class="d-flex gap-2">
                <a href="{{ route('products.create') }}" class="btn btn-gradient">
                    <i class="bi bi-plus-lg me-1"></i> Nuevo Producto
                </a>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger">
                        <i class="bi bi-box-arrow-right me-1"></i> Salir
                    </button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show bg-success bg-opacity-10 border border-success border-opacity-25 text-success rounded-3 mb-4 d-flex align-items-center" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div class="flex-grow-1">{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show bg-danger bg-opacity-10 border border-danger border-opacity-25 text-danger rounded-3 mb-4 d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                <div class="flex-grow-1">{{ $errors->first() }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif

        <!-- Tarjetas de Resumen KPI de Inventario -->
        @php
            $totalStock = $products->sum('stock');
            $lowStock = $products->filter(fn($p) => $p->stock > 0 && $p->stock <= 5)->count();
            $outOfStock = $products->filter(fn($p) => $p->stock == 0)->count();
        @endphp
        <div class="row g-3 mb-4">
            <div class="col-6 col-lg-3">
                <div class="glass p-3 rounded-4">
                    <span class="text-secondary small d-block mb-1">Total Productos</span>
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="fs-4 fw-bold">{{ $products->count() }}</span>
                        <i class="bi bi-box-seam text-primary fs-3"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="glass p-3 rounded-4">
                    <span class="text-secondary small d-block mb-1">Unidades en Bodega</span>
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="fs-4 fw-bold">{{ number_format($totalStock, 0, ',', '.') }}</span>
                        <i class="bi bi-layers-fill text-success fs-3"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="glass p-3 rounded-4">
                    <span class="text-secondary small d-block mb-1">Stock Crítico (≤ 5)</span>
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="fs-4 fw-bold text-warning">{{ $lowStock }}</span>
                        <i class="bi bi-exclamation-triangle-fill text-warning fs-3"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="glass p-3 rounded-4">
                    <span class="text-secondary small d-block mb-1">Agotados (0 un.)</span>
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="fs-4 fw-bold text-danger">{{ $outOfStock }}</span>
                        <i class="bi bi-x-circle-fill text-danger fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Inventario Adaptable al Tema -->
        <div class="glass p-4 rounded-4 shadow-sm">
            <div class="table-responsive">
                <table class="table gs-table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Categoría</th>
                            <th>Precio</th>
                            <th style="min-width: 200px;">Ajustar Inventario (Stock)</th>
                            <th>Estado</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <!-- Producto -->
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ \Illuminate\Support\Str::startsWith($product->image, ['http', 'https']) ? $product->image : asset($product->image ?? 'assets/img/placeholder.webp') }}" 
                                         alt="{{ $product->name }}" 
                                         class="rounded-3 shadow-sm border border-opacity-10" 
                                         style="width: 46px; height: 46px; object-fit: cover;">
                                    <div>
                                        <div class="fw-bold">{{ $product->name }}</div>
                                        @if($product->is_featured)
                                            <span class="badge bg-warning bg-opacity-25 text-warning small" style="font-size: 0.65rem;">
                                                <i class="bi bi-star-fill me-1"></i> Destacado
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Categoría -->
                            <td>
                                <span class="badge bg-body-tertiary border border-opacity-10 text-secondary">
                                    {{ $product->category ?? 'Sin categoría' }}
                                </span>
                            </td>

                            <!-- Precio -->
                            <td class="fw-bold">
                                ${{ number_format($product->price, 0, ',', '.') }}
                            </td>

                            <!-- Ajustar Inventario Rápido -->
                            <td>
                                <form action="{{ route('products.stock.update', $product) }}" method="POST" class="d-flex align-items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <div class="input-group input-group-sm" style="max-width: 140px;">
                                        <button class="btn btn-outline-theme" type="button" onclick="this.nextElementSibling.stepDown();" aria-label="Restar">
                                            <i class="bi bi-dash"></i>
                                        </button>
                                        <input type="number" 
                                               name="stock" 
                                               class="form-control text-center fw-bold gs-input" 
                                               value="{{ $product->stock }}" 
                                               min="0" 
                                               required>
                                        <button class="btn btn-outline-theme" type="button" onclick="this.previousElementSibling.stepUp();" aria-label="Sumar">
                                            <i class="bi bi-plus"></i>
                                        </button>
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-outline-success" title="Guardar stock">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                </form>
                            </td>

                            <!-- Estado Badge -->
                            <td>
                                @if($product->stock == 0)
                                    <span class="badge bg-danger bg-opacity-25 text-danger border border-danger border-opacity-25 px-2 py-1">
                                        Agotado
                                    </span>
                                @elseif($product->stock <= 5)
                                    <span class="badge bg-warning bg-opacity-25 text-warning border border-warning border-opacity-25 px-2 py-1">
                                        Bajo ({{ $product->stock }} un.)
                                    </span>
                                @else
                                    <span class="badge bg-success bg-opacity-25 text-success border border-success border-opacity-25 px-2 py-1">
                                        Disponible ({{ $product->stock }} un.)
                                    </span>
                                @endif
                            </td>

                            <!-- Acciones -->
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-outline-theme" title="Editar producto">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('¿Eliminar producto {{ $product->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        
                        @if($products->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center py-5 text-secondary">
                                <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                                No hay productos en el inventario. 
                                <a href="{{ route('products.create') }}" class="text-gradient ms-1 fw-bold">Crea el primer producto aquí</a>.
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</main>
@endsection
