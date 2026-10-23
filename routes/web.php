<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

// Rutas Públicas de la Tienda
Route::get('/', function () {
    $featuredProducts = Product::where('is_featured', true)->get();
    return view('index', compact('featuredProducts'));
});

Route::get('/shop', function () {
    $products = Product::all();
    return view('shop', compact('products'));
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/api/products', function () {
    return Product::all();
});

// Autenticación de Administrador (Accesible exclusivamente mediante /admin)
Route::middleware('guest')->group(function () {
    Route::get('/admin', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/admin', [AuthController::class, 'login']);
});

// Redirección de conveniencia: /login -> /admin
Route::get('/login', function () {
    return redirect()->route('login');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Panel de Administración e Inventario (Protegido por autenticación)
Route::middleware('auth')->prefix('dashboard')->group(function () {
    Route::get('/', function () {
        return redirect()->route('products.index');
    })->name('dashboard');

    Route::patch('products/{product}/stock', [ProductController::class, 'updateStock'])->name('products.stock.update');
    Route::resource('products', ProductController::class);
});
