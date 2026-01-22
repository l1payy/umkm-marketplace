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
    // Specific routes MUST come before resource catch-all
    Route::get('/search', [ProductController::class, 'search'])->name('search');
    Route::get('/products/mine', [ProductController::class, 'mine'])->name('products.mine');
    Route::resource('products', ProductController::class)->only(['index','create','store','show','edit','update','destroy']);

    Route::get('/needs/latest', [NeedController::class, 'latest'])->name('needs.latest');
    Route::get('/needs/mine', [NeedController::class, 'mine'])->name('needs.mine');
    Route::resource('needs', NeedController::class)->only(['create','store','show','edit','update','destroy']);

    // Payments
    Route::get('/orders/{order}/pay', [\App\Http\Controllers\PaymentController::class, 'show'])->name('orders.pay');
    Route::post('/orders/{order}/pay', [\App\Http\Controllers\PaymentController::class, 'start'])->name('payments.start');
    Route::get('/orders/{order}/confirm/{payment}', [\App\Http\Controllers\PaymentController::class, 'confirm'])->name('payments.confirm');
    Route::post('/orders/{order}/complete/{payment}', [\App\Http\Controllers\PaymentController::class, 'complete'])->name('payments.complete');
    Route::get('/orders/{order}/receipt', [\App\Http\Controllers\PaymentController::class, 'receipt'])->name('orders.receipt');
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

// Guest landing (optional): keep welcome for non-auth
Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

Route::post('/webhook/payment', [\App\Http\Controllers\PaymentWebhookController::class, 'handle'])->name('webhook.payment');

require __DIR__.'/auth.php';
