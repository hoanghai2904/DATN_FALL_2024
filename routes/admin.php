
<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
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
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\VoucherController;

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

Route::prefix('admin')->as('admin.')->group(function() {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('orders',OrderController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('order-items', OrderItemController::class);
    Route::resource('order-statuses', OrderStatusController::class);
    Route::resource('cancelled-orders', CancelledOrderController::class);

    Route::resource('brands', BrandsController::class);

    // Route::post('/vouchers/update-status', [VoucherController::class, 'updateStatus'])->name('admin.vouchers.updateStatus');
    
    // Route::resource('vouchers', VoucherController::class);
    Route::group(['prefix' => 'vouchers', 'as' => 'vouchers.'], function () {
        Route::get('/', [VoucherController::class, 'index'])->name('index');
        Route::get('create', [VoucherController::class, 'create'])->name('create');
        Route::post('store', [VoucherController::class, 'store'])->name('store');
        Route::delete('destroy/{id}', [VoucherController::class, 'destroy'])->name('destroy');
        Route::get('edit/{id}', [VoucherController::class, 'edit'])->name('edit');
        Route::put('updater/{id}', [VoucherController::class, 'update'])->name('update');
        Route::post('update-status', [VoucherController::class, 'updateStatus'])->name('updateStatus');
    });

    Route::group(['prefix' => 'banners', 'as' => 'banners.'], function () {
        Route::get('list-banner', [BannerController::class, 'listBanner'])->name('listBanner');
        Route::get('add-banner', [BannerController::class, 'addBanner'])->name('addBanner');
        Route::post('add-banner', [BannerController::class, 'addPostBanner'])->name('addPostBanner');
        Route::get('detail-banner/{id}', [BannerController::class, 'detailBanner'])->name('detailBanner');    
        Route::delete('delete-banner/{id}', [BannerController::class, 'deleteBanner'])->name('deleteBanner');
        Route::get('updater/{id}', [BannerController::class, 'updateBanner'])->name('updateBanner');
        Route::put('update-banner/{id}', [BannerController::class, 'updatePutBanner'])->name('updatePutBanner');
    });

    Route::resource('products',ProductController::class);
    Route::get('/test-variant',function () {
        return view('admin.products.test');
    });
    // Route::group(['prefix' => 'categories', 'as' => 'categories.'], function () {

    //     Route::get('/category', [CategoryController::class, 'index'])->name('listCategory');
    //     Route::get('/category-add', [CategoryController::class, 'addCategory'])->name('addCategory');
    //     Route::post('/list-add', [CategoryController::class, 'addPostCategory'])->name('addPostCategory');
    //     Route::delete('/delete-catgegory/{id}', [CategoryController::class, 'deleteCategory'])->name('deleteCategory');
    //     Route::post('/restore-catgegory/{id}', [CategoryController::class, 'restoreCategory'])->name('restoreCategory');
    //     Route::get('/update/{id}', [CategoryController::class, 'updateCategory'])->name('updateCategory');
    //     Route::put('/update/{id}', [CategoryController::class, 'updatePutCategory'])->name('updatePutCategory');
    // });

});