<?php

use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\ProductsController;
use App\Http\Controllers\Dashboard\ProfileController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['auth', 'auth.type:admin,super-admin'],
    'as' => 'Dashboard.',
    'prefix' => 'Dashboard',
    //'namespace' => 'App\Http\Controllers\Dashboard',
], function () {

    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/', [DashboardController::class, 'index'])->name('Dashboard');


    // Route::get('/categories/{category}', [CategoriesController::class, 'show'])
    //     ->name('categories.show')
    //     ->where('category', '\d+');

    Route::get('/categories/trash', [CategoriesController::class, 'trash'])->name('categories.trash');
    Route::put('categories/{category}/restore', [CategoriesController::class, 'restore'])->name('categories.restore');
    Route::delete('categories/{category}/force-delete', [CategoriesController::class, 'forceDelete'])
        ->name('categories.force-delete');


    Route::get('/products/trash', [ProductsController::class, 'trash'])->name('products.trash');
    Route::put('products/{category}/restore', [ProductsController::class, 'restore'])->name('products.restore');
    Route::delete('products/{category}/force-delete', [ProductsController::class, 'forceDelete'])
        ->name('products.force-delete');


    Route::resource('/categories', CategoriesController::class);
    Route::resource('/products', ProductsController::class);
});

// Route::middleware('auth')->as('Dashboard.')->prefix('Dashboard')->group(function() {

// });


