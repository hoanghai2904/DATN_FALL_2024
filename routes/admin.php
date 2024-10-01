<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CategoryController;

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
    Route::resource('products', ProductController::class);
    Route::resource('brands', BrandsController::class);

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
});
