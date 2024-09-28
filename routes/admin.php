<?php

use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\UserController;


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

Route::prefix('admin')->as('admin.')->group(function() {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    Route::resource('user_addresses', UserAddressController::class);
    // Route::middleware(['auth'])->group(function () {
    //     Route::resource('user_addresses', UserAddressController::class);
    // });
    Route::resource('users', UserController::class);

});
