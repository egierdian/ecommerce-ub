<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::get('/', [Controllers\Frontend\IndexController::class, 'index'])->name('frontend.index');

Route::get('/login', [Controllers\AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [Controllers\AuthController::class, 'login'])->name('login.post');
Route::get('/register', [Controllers\AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [Controllers\AuthController::class, 'register'])->name('register.post');
Route::get('/logout', [Controllers\AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', [Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    
    Route::group((['prefix' => 'product']), function () {
        Route::get('/', [Controllers\Admin\ProductController::class, 'index'])->name('admin.product');
        Route::get('/create', [Controllers\Admin\ProductController::class, 'create'])->name('admin.product.create');
        Route::get('/edit/{id}', [Controllers\Admin\ProductController::class, 'edit'])->name('admin.product.edit');
        Route::post('/store', [Controllers\Admin\ProductController::class, 'store'])->name('admin.product.store');
        Route::post('/update/{id}', [Controllers\Admin\ProductController::class, 'update'])->name('admin.product.update');
        Route::get('/delete/{id}', [Controllers\Admin\ProductController::class, 'destroy'])->name('admin.product.delete');
        Route::get('/delete-image/{id}/{imageId?}', [Controllers\Admin\ProductController::class, 'deleteImage'])->name('admin.product.delete-image');
    });

    Route::group((['prefix' => 'rental-price']), function () {
        Route::get('/', [Controllers\Admin\RentalPriceController::class, 'index'])->name('admin.rental-price');
        Route::get('/create', [Controllers\Admin\RentalPriceController::class, 'create'])->name('admin.rental-price.create');
        Route::get('/edit/{id}', [Controllers\Admin\RentalPriceController::class, 'edit'])->name('admin.rental-price.edit');
        Route::post('/store', [Controllers\Admin\RentalPriceController::class, 'store'])->name('admin.rental-price.store');
        Route::post('/update/{id}', [Controllers\Admin\RentalPriceController::class, 'update'])->name('admin.rental-price.update');
        Route::get('/delete/{id}', [Controllers\Admin\RentalPriceController::class, 'destroy'])->name('admin.rental-price.delete');
    });

    
    Route::group((['prefix' => 'category']), function () {
        Route::get('/', [Controllers\Admin\CategoryController::class, 'index'])->name('admin.category');
        Route::get('/create', [Controllers\Admin\CategoryController::class, 'create'])->name('admin.category.create');
        Route::get('/edit/{id}', [Controllers\Admin\CategoryController::class, 'edit'])->name('admin.category.edit');
        Route::post('/store', [Controllers\Admin\CategoryController::class, 'store'])->name('admin.category.store');
        Route::post('/update/{id}', [Controllers\Admin\CategoryController::class, 'update'])->name('admin.category.update');
        Route::get('/delete/{id}', [Controllers\Admin\CategoryController::class, 'destroy'])->name('admin.category.delete');
    });
    
    Route::group((['prefix' => 'slider']), function () {
        Route::get('/', [Controllers\Admin\SliderController::class, 'index'])->name('admin.slider');
        Route::get('/create', [Controllers\Admin\SliderController::class, 'create'])->name('admin.slider.create');
        Route::get('/edit/{id}', [Controllers\Admin\SliderController::class, 'edit'])->name('admin.slider.edit');
        Route::post('/store', [Controllers\Admin\SliderController::class, 'store'])->name('admin.slider.store');
        Route::post('/update/{id}', [Controllers\Admin\SliderController::class, 'update'])->name('admin.slider.update');
        Route::get('/delete/{id}', [Controllers\Admin\SliderController::class, 'destroy'])->name('admin.slider.delete');
    });

});
