<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\CancelledOrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\OrderStatusController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\UserController;


use App\Http\Controllers\BannerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\VoucherController;
use App\Models\Category;
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

Route::prefix('admin')->as('admin.')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('order-items', OrderItemController::class);
    Route::resource('order-statuses', OrderStatusController::class);
    Route::resource('cancelled-orders', CancelledOrderController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('brands', BrandsController::class);

    Route::resource('vouchers', VoucherController::class);

    Route::get('/list', function () {
        return view('admin.list.index');
    });
    Route::get('/list-add', function () {
        return view('admin.list.create');
    });
    Route::get('/test', function () {
        return view('admin.list.create');
    });

    Route::get('/list', [CategoryController::class, 'index'])->name('listCategory');
    Route::get('/list-add', [CategoryController::class, 'addCategory'])->name('addCategory');
    Route::post('/list-add', [CategoryController::class, 'addPostCategory'])->name('addPostCategory');
    Route::delete('/delete-catgegory/{id}', [CategoryController::class, 'deleteCategory'])->name('deleteCategory');
    Route::post('/restore-catgegory/{id}', [CategoryController::class, 'restoreCategory'])->name('restoreCategory');
    Route::get('/update/{id}', [CategoryController::class, 'updateCategory'])->name('updateCategory');
    Route::put('/update/{id}', [CategoryController::class, 'updatePutCategory'])->name('updatePutCategory');

    Route::group(['prefix' => 'banners', 'as' => 'banners.'], function () {
        Route::get('list-banner', [BannerController::class, 'listBanner'])->name('listBanner');
        Route::get('add-banner', [BannerController::class, 'addBanner'])->name('addBanner');
        Route::post('add-banner', [BannerController::class, 'addPostBanner'])->name('addPostBanner');
        Route::get('detail-banner/{id}', [BannerController::class, 'detailBanner'])->name('detailBanner');
        Route::delete('delete-banner/{id}', [BannerController::class, 'deleteBanner'])->name('deleteBanner');
        Route::get('update-banner/{id}', [BannerController::class, 'updateBanner'])->name('updateBanner');
        Route::put('update-banner/{id}', [BannerController::class, 'updatePutBanner'])->name('updatePutBanner');
    });

    Route::resource('products', ProductController::class);
    Route::get('/test-variant', function () {
        return view('admin.products.test');
    });
    Route::get('/product/{id}/variations', [ProductController::class, 'manageVariations'])->name('product.variations.manage');
    Route::post('/product/{id}/variations/generate', [ProductController::class, 'generateVariations'])->name('product.variations.generate');
    Route::put('/product/{id}/variations/update', [ProductController::class, 'updateVariations'])->name('product.variations.update');
});
