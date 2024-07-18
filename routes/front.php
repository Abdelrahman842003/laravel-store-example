<?php

    use App\Http\Controllers\Front\HomeController;
    use App\Http\Controllers\Front\CartController;
    use App\Http\Controllers\Front\ProductController;
    use Illuminate\Support\Facades\Route;

    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('products/', [ProductController::class, 'index'])->name('product.index');
    Route::get('products/{product:slug}', [ProductController::class, 'show'])->name('product.show');

    Route::resource('cart',CartController::class);
