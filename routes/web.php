<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NeedController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Root: jika belum login langsung ke halaman login, jika sudah login ke home
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('home')
        : redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/home', [NeedController::class, 'index'])->name('home');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('products', ProductController::class)->only(['index','create','store','show']);
    Route::resource('needs', NeedController::class)->only(['create','store','show']);
    Route::post('/needs/{need}/offers', [OfferController::class, 'store'])->name('offers.store');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/product/{product}', [CartController::class, 'addProduct'])->name('cart.add.product');
    Route::post('/cart/add/offer/{offer}', [CartController::class, 'addOffer'])->name('cart.add.offer');
    Route::delete('/cart/item/{item}', [CartController::class, 'removeItem'])->name('cart.item.remove');

    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/send', [ChatController::class, 'send'])->name('chat.send');
});

// Guest landing removed to simplify routes

require __DIR__.'/auth.php';
