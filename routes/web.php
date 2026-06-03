<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\GoogleController;

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);

Route::get('/product', [HomeController::class, 'allProducts']) ->name('products');
Route::get('/product-detail/{id}', [HomeController::class, 'productDetail']) ->name('product.detail');
Route::get('/category/{id}/products', [ProductController::class, 'getCategoryProducts']);
Route::get('/', [HomeController::class, 'home']);
Route::get('/search', [ProductController::class, 'search']);

// admin can access
Route::middleware(['auth','admin'])->group(function(){
Route::get('/admin',[AdminController::class, 'index']);
Route::post('/category/store',[CategoryController::class,'store'])->name('category.store');
Route::post ('/product/store',[ProductController::class, 'store'])->name('product.store');
Route::get ('/product/{id}',[ProductController::class, 'show']) ->name('product.show');
Route::post ('/product/{id}/update',[ProductController::class, 'update']) ->name('product.update'); 
Route::delete('/product/{id}',[ProductController::class, 'destroy'])->name('product.delete');
Route::get('/categories/{id}', [CategoryController::class, 'show']);
Route::get('/categories/{id}/edit', [CategoryController::class, 'edit']);
Route::put('/categories/{id}', [CategoryController::class, 'update']);
Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
Route::get('/admin/orders', [AdminOrderController::class, 'index']);
Route::patch('/admin/orders/{id}/status', [AdminOrderController::class, 'updateStatus']);
});

//logged in user access
Route::middleware('auth')->group(function(){
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
Route::post('/cart/add', [CartController::class,'add'])->name('cart.add');
Route::get('/cart', [CartController::class,'index'])->name('cart.index');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::patch('/cart/{id}',[CartController::class,'updateQty'])->name('cart.qty');
Route::delete('/cart-clear',[CartController::class,'clear'])->name('cart.clear');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::get('/checkout/cart', function () {session()->forget('buy_now_cart'); return redirect()->route('checkout');
})->name('checkout.cart');
Route::post('/place-order', [CheckoutController::class, 'placeOrder']);
Route::post('/buy-now', [CheckoutController::class, 'buyNow'])->name('buy.now');
Route::get('/my-orders', [OrderController::class, 'index']);

});
Route::get('/welcome', function () {
    return view('welcome');
});
Route::get('/app', function () {
    return view('app');
});

 Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

require __DIR__.'/auth.php';
