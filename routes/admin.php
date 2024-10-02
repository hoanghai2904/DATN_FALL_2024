<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Models\Category;
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

Route::prefix('admin')->as('admin.')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);











    Route::get('/list', [CategoryController::class, 'index'])->name('listCategory');
    Route::get('/list-add', [CategoryController::class, 'addCategory'])->name('addCategory');
    Route::post('/list-add', [CategoryController::class, 'addPostCategory'])->name('addPostCategory');











    // Route::get('/test', function () {
    //     return view('admin.list.create');
    // });
});
