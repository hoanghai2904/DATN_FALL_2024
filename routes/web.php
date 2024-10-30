<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Client\AccountController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ProductListController;
use App\Http\Controllers\ProductController;


// route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::group(['prefix' => 'account'], function () {
    route::get('/login', [AccountController::class, 'login'])->name('account.login');
    route::post('/login', [AccountController::class, 'Check_login'])->name('account.Check_login');

    route::get('/logout', [AccountController::class, 'logout'])->name('account.logout');

    route::get('/verify-account/{token}', [AccountController::class, 'verifyAccount'])->name('account.verify');
    route::get('/rigester', [AccountController::class, 'rigester'])->name('account.rigester');
    route::post('/rigester', [AccountController::class, 'Check_rigester'])->name('account.Check_rigester');
    Route::get('/verify-account/{token}', [AccountController::class, 'verifyAccount'])->name('account.verify');

    Route::group(['middleware' => 'customer'], function () {
        route::get('/profile', [AccountController::class, 'profile'])->name('account.profile');
        route::post('/profile', [AccountController::class, 'Check_profile']);

        route::get('/change_pass', [AccountController::class, 'change_pass'])->name('account.change_pass');
        route::post('/change_pass', [AccountController::class, 'Check_changePass'])->name('account.Check_changePass');
    });


    route::get('/forgot_pass', [AccountController::class, 'forgot_pass'])->name('account.forgot_pass');
    route::post('/forgot_pass', [AccountController::class, 'Check_forgotPass']);

    route::get('/reset_pass', [AccountController::class, 'reset_pass'])->name('account.reset_pass');
    route::post('/reset_pass', [AccountController::class, 'Check_resetPass']);
});


// Product

Route::get('/', [ProductListController::class, 'index'])->name('home.index');
