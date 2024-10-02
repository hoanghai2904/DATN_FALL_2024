<?php

use App\Http\Controllers\CancelledOrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\OrderStatusController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\ProductController;
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
    Route::resource('orders',OrderController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('order-items', OrderItemController::class);
    Route::resource('order-statuses', OrderStatusController::class);
    Route::resource('cancelled-orders', CancelledOrderController::class);

    Route::resource('brands', BrandsController::class);

    Route::resource('vouchers',VoucherController::class);
    Route::resource('categories', CategoryController::class);
    Route::get('/list',function () {
        return view('admin.list.index');
    });
    Route::get('/list-add',function () {
        return view('admin.list.create');
    });
    Route::get('/test',function () {
        return view('admin.list.create');
    });

    Route::group(['prefix' => 'banners', 'as' => 'banners.'], function () {
        Route::get('list-banner', [BannerController::class, 'listBanner'])->name('listBanner');
        Route::get('add-banner', [BannerController::class, 'addBanner'])->name('addBanner');
        Route::post('add-banner', [BannerController::class, 'addPostBanner'])->name('addPostBanner');
        Route::get('detail-banner/{id}', [BannerController::class, 'detailBanner'])->name('detailBanner');    
        Route::delete('delete-banner/{id}', [BannerController::class, 'deleteBanner'])->name('deleteBanner');
        Route::get('update-banner/{id}', [BannerController::class, 'updateBanner'])->name('updateBanner');
        Route::put('update-banner/{id}', [BannerController::class, 'updatePutBanner'])->name('updatePutBanner');
    });

    Route::get('/list', [CategoryController::class, 'index'])->name('listCategory');
    Route::get('/list-add', [CategoryController::class, 'addCategory'])->name('addCategory');
    Route::post('/list-add', [CategoryController::class, 'addPostCategory'])->name('addPostCategory');
    Route::delete('/delete-catgegory/{id}', [CategoryController::class, 'deleteCategory'])->name('deleteCategory');
    Route::post('/restore-catgegory/{id}', [CategoryController::class, 'restoreCategory'])->name('restoreCategory');

});
