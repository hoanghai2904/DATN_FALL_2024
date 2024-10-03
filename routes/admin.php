<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\ProductController;
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

Route::get('admin.brands.trash', [BrandsController::class,'trash']);
Route::post('admin.brands.delete', [BrandsController::class,'delete']);
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
});
