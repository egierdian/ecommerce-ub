<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('home');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// admin 
Route::get('/dashboard', function () {
    return view('dashboard.index');
});


// Route::middleware('auth')->prefix('admin')->group(function () {
Route::prefix('admin')->group(function () {
    Route::group((['prefix' => 'product']), function () {
        Route::get('/', [Controllers\Admin\ProductController::class, 'index'])->name('admin.product');
        Route::get('/create', [Controllers\Admin\ProductController::class, 'create'])->name('admin.product.create');
        Route::get('/edit/{id}', [Controllers\Admin\ProductController::class, 'edit'])->name('admin.product.edit');
        Route::post('/store', [Controllers\Admin\ProductController::class, 'store'])->name('admin.product.store');
        Route::post('/update/{id}', [Controllers\Admin\ProductController::class, 'update'])->name('admin.product.update');
        Route::get('/delete/{id}', [Controllers\Admin\ProductController::class, 'destroy'])->name('admin.product.delete');
    });
});
