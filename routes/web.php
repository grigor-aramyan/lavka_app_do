<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return view('splash');
    return redirect()->route('register');
})->name('splash');



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/categories', [App\Http\Controllers\CategoriesController::class, 'index'])->name('categories');
Route::get('/categories/{cat_id}/products/{page?}', [App\Http\Controllers\CategoriesController::class, 'category_products_paged'])->name('categories_paged_items');

Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart');

Route::post('/order', [App\Http\Controllers\OrderController::class, 'store'])->name('store');

Route::get('/account', [App\Http\Controllers\AccountController::class, 'index'])->name('account');
Route::post('/account', [App\Http\Controllers\AccountController::class, 'update'])->name('account-update');

Route::post('/verify/start', [App\Http\Controllers\VerifyController::class, 'start_verification'])->name('send_code');
Route::post('/verify/code', [App\Http\Controllers\VerifyController::class, 'verify_code'])->name('verify_phone');

Route::post('/login/guest', [App\Http\Controllers\MixedController::class, 'login_as_guest'])->name('login_as_guest');

Route::get('/without_register', function () {
    return view('without_register');
})->name('without_register');

Route::prefix('admin')->group(function(){
    Route::get('/login', [AdminController::class, 'login'])->name('admin-login');
    Route::post('/login', [AdminController::class, 'authenticate'])->name('admin-authenticate');
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin-logout');

    Route::get('/', [AdminController::class, 'index'])->name('admin-dashboard');

    Route::get('/orders/{page?}', [AdminController::class, 'orders_list'])->name('admin-orders-list');
    Route::get('/users/{page?}', [AdminController::class, 'users_list'])->name('admin-users-list');
    Route::get('/products/{page?}', [AdminController::class, 'products_list'])->name('admin-products-list');

    Route::get('/orders/{id}/delete', [AdminController::class, 'order_delete'])->name('admin-order-delete');
    Route::get('/users/{id}/delete', [AdminController::class, 'user_delete'])->name('admin-user-delete');
    Route::get('/products/{id}/delete', [AdminController::class, 'product_delete'])->name('admin-product-delete');

    Route::post('/orders', [AdminController::class, 'orders_store'])->name('admin-orders-store');
    Route::post('/users', [AdminController::class, 'users_store'])->name('admin-users-store');
    Route::post('/products', [AdminController::class, 'products_store'])->name('admin-products-store');

    Route::post('/products/import', [AdminController::class, 'products_import'])->name('admin-products-import');
    Route::post('/products/image', [AdminController::class, 'products_image'])->name('admin-products-image');

});