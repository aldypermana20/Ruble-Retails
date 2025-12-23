<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Http\Controllers\{
    AuthController,
    QuickViewController,
    OrderController,
    PageController,
    ProductController,
    WishlistController,
    ReviewController,
    ProfileController,
    ProductManagerController
};

/*
|--------------------------------------------------------------------------
| Public Routes (Halaman Umum)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome', ['products' => Product::all()]);
})->name('home');

// Halaman Produk & Fitur View
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
Route::get('/quick-view/{id}', [QuickViewController::class, 'show'])->name('quick-view');

// Static Pages
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::view('/delivery-information', 'delivery')->name('delivery');
Route::view('/privacy-policy', 'privacy')->name('privacy');
Route::view('/terms-conditions', 'terms')->name('terms');
Route::view('/offline', 'errors.offline')->name('offline');

/*
|--------------------------------------------------------------------------
| Guest Routes (Hanya untuk user yang BELUM login)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::view('/forgot-password', 'auth.forgot-password')->name('password.request');
    Route::post('/forgot-password', function () {
        dd('Proses Reset...');
    })->name('password.email');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Hanya untuk user yang SUDAH login)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    // Profile Management (CRUD)
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');
    
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Shopping Actions
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Admin Product Management (CRUD)
    Route::get('/admin/products', [ProductManagerController::class, 'index'])->name('admin.products.index');
    Route::post('/admin/products', [ProductManagerController::class, 'store'])->name('admin.products.store');
    Route::patch('/admin/products/{product}', [ProductManagerController::class, 'update'])->name('admin.products.update');
    Route::delete('/admin/products/{product}', [ProductManagerController::class, 'destroy'])->name('admin.products.destroy');
});

/*
|--------------------------------------------------------------------------
| Webhooks & External API
|--------------------------------------------------------------------------
*/

Route::post('/midtrans/notification', [OrderController::class, 'notification'])->name('midtrans.notification');