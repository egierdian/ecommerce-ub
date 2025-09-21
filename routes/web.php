<?php

use App\Http\Controllers;
use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Route;

#start frontend
Route::get('/', [Controllers\Frontend\IndexController::class, 'index'])->name('frontend.index');

Route::get('/product/{category}/{product?}', [Controllers\Frontend\IndexController::class, 'showProduct'])->name('frontend.product.category');

Route::group((['prefix' => 'cart']), function () {
    Route::post('/add/{productId}', [Controllers\Frontend\CartController::class, 'add'])->name('frontend.cart.add');
    Route::post('/delete/{productId}', [Controllers\Frontend\CartController::class, 'delete'])->name('frontend.cart.delete');
    Route::post('/update/{productId}', [Controllers\Frontend\CartController::class, 'update'])->name('frontend.cart.update');
});

Route::get('/checkout', [Controllers\Frontend\IndexController::class, 'checkout'])->name('frontend.checkout');
Route::post('/checkout', [Controllers\Frontend\IndexController::class, 'checkoutProcess'])->name('frontend.checkout.process');

Route::get('/invoice/{code}', [Controllers\Frontend\IndexController::class, 'invoice'])->name('frontend.invoice');

Route::get('/wishlist', [Controllers\Frontend\WishlistController::class, 'index'])->name('frontend.wishlist');
Route::post('/wishlist/{productId}', [Controllers\Frontend\WishlistController::class, 'toggle'])->name('frontend.wishlist.add');

Route::get('/tentang-kami', [Controllers\Frontend\IndexController::class, 'aboutUs'])->name('frontend.about-us');
Route::get('/kontak', [Controllers\Frontend\IndexController::class, 'contactUs'])->name('frontend.contact');
Route::get('/faq', [Controllers\Frontend\IndexController::class, 'faq'])->name('frontend.faq');

Route::post('/rental/search', [Controllers\Frontend\IndexController::class, 'searchRentals'])->name('frontend.product.rental.search');
Route::get('/sewa', [Controllers\Frontend\IndexController::class, 'productRentalPage'])->name('frontend.product.rental');

Route::get('/read-book/{slug}', [Controllers\Frontend\IndexController::class, 'readBook'])->name('frontend.read-book');


Route::get('/pdf/view/{product_id}', [PdfController::class, 'stream'])->name('pdf.view');#end frontend

#frontend auth
Route::middleware(['auth', 'role:customer'])->prefix('dashboard')->group(function () {
    Route::get('/', [Controllers\Frontend\DashboardController::class, 'index'])->name('frontend.dashboard');
    Route::get('/pesanan', [Controllers\Frontend\DashboardController::class, 'myOrder'])->name('frontend.dashboard.my-order');
    Route::get('/wishlist', [Controllers\Frontend\DashboardController::class, 'wishlist'])->name('frontend.dashboard.wishlist');
    Route::get('/ubah-password', [Controllers\Frontend\DashboardController::class, 'changePassword'])->name('frontend.dashboard.change-password');
    Route::post('/ubah-password', [Controllers\Frontend\DashboardController::class, 'updatePassword'])->name('frontend.dashboard.update-password');
    Route::get('/profil', [Controllers\Frontend\DashboardController::class, 'profile'])->name('frontend.dashboard.profile');
    Route::post('/profil', [Controllers\Frontend\DashboardController::class, 'updateProfile'])->name('frontend.dashboard.profile.update');
    Route::post('/payment/upload', [Controllers\Frontend\DashboardController::class, 'paymentUpload'])->name('frontend.dashboard.payment.upload');
    Route::get('/produk', [Controllers\Frontend\DashboardController::class, 'productPaid'])->name('frontend.dashboard.product-paid');
    Route::get('/penilaian', [Controllers\Frontend\DashboardController::class, 'review'])->name('frontend.dashboard.review');
    Route::post('/penilaian', [Controllers\Frontend\DashboardController::class, 'reviewStore'])->name('frontend.dashboard.review.store');
});

#admin
Route::middleware(['auth', 'role:administrator|seller'])->prefix('admin')->group(function () {
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

    Route::group((['prefix' => 'slider']), function () {
        Route::get('/', [Controllers\Admin\SliderController::class, 'index'])->name('admin.slider');
        Route::get('/create', [Controllers\Admin\SliderController::class, 'create'])->name('admin.slider.create');
        Route::get('/edit/{id}', [Controllers\Admin\SliderController::class, 'edit'])->name('admin.slider.edit');
        Route::post('/store', [Controllers\Admin\SliderController::class, 'store'])->name('admin.slider.store');
        Route::post('/update/{id}', [Controllers\Admin\SliderController::class, 'update'])->name('admin.slider.update');
        Route::get('/delete/{id}', [Controllers\Admin\SliderController::class, 'destroy'])->name('admin.slider.delete');
    });

    Route::group((['prefix' => 'transaction']), function () {
        Route::get('/', [Controllers\Admin\TransactionController::class, 'index'])->name('admin.transaction');
        Route::get('/approval/{id}', [Controllers\Admin\TransactionController::class, 'approval'])->name('admin.transaction.approval');
        Route::get('/detail/{id}', [Controllers\Admin\TransactionController::class, 'detail'])->name('admin.transaction.detail');
    });
});


Route::middleware(['auth', 'role:administrator'])->prefix('admin')->group(function () { 
    Route::group((['prefix' => 'category']), function () {
        Route::get('/', [Controllers\Admin\CategoryController::class, 'index'])->name('admin.category');
        Route::get('/create', [Controllers\Admin\CategoryController::class, 'create'])->name('admin.category.create');
        Route::get('/edit/{id}', [Controllers\Admin\CategoryController::class, 'edit'])->name('admin.category.edit');
        Route::post('/store', [Controllers\Admin\CategoryController::class, 'store'])->name('admin.category.store');
        Route::post('/update/{id}', [Controllers\Admin\CategoryController::class, 'update'])->name('admin.category.update');
        Route::get('/delete/{id}', [Controllers\Admin\CategoryController::class, 'destroy'])->name('admin.category.delete');
    });
    
    Route::group((['prefix' => 'setting']), function () {
        Route::get('/', [Controllers\Admin\SettingController::class, 'index'])->name('admin.setting');
        Route::post('/update', [Controllers\Admin\SettingController::class, 'update'])->name('admin.setting.update');
    });

    Route::group((['prefix' => 'faq']), function () {
        Route::get('/', [Controllers\Admin\FaqController::class, 'index'])->name('admin.faq');
        Route::get('/create', [Controllers\Admin\FaqController::class, 'create'])->name('admin.faq.create');
        Route::get('/edit/{id}', [Controllers\Admin\FaqController::class, 'edit'])->name('admin.faq.edit');
        Route::post('/store', [Controllers\Admin\FaqController::class, 'store'])->name('admin.faq.store');
        Route::post('/update/{id}', [Controllers\Admin\FaqController::class, 'update'])->name('admin.faq.update');
        Route::get('/delete/{id}', [Controllers\Admin\FaqController::class, 'destroy'])->name('admin.faq.delete');
    });
    
    Route::group((['prefix' => 'seller']), function () {
        Route::get('/', [Controllers\Admin\SellerController::class, 'index'])->name('admin.seller');
        Route::get('/create', [Controllers\Admin\SellerController::class, 'create'])->name('admin.seller.create');
        Route::get('/edit/{id}', [Controllers\Admin\SellerController::class, 'edit'])->name('admin.seller.edit');
        Route::post('/store', [Controllers\Admin\SellerController::class, 'store'])->name('admin.seller.store');
        Route::post('/update/{id}', [Controllers\Admin\SellerController::class, 'update'])->name('admin.seller.update');
        Route::get('/delete/{id}', [Controllers\Admin\SellerController::class, 'destroy'])->name('admin.seller.delete');
    });
});

Route::get('/masuk', [Controllers\AuthController::class, 'showLogin'])->name('login');
Route::post('/masuk', [Controllers\AuthController::class, 'login'])->name('login.post');
Route::get('/daftar', [Controllers\AuthController::class, 'showRegister'])->name('register');
Route::post('/daftar', [Controllers\AuthController::class, 'register'])->name('register.post');
Route::get('/logout', [Controllers\AuthController::class, 'logout'])->name('logout');
