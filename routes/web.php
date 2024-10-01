<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Client\AccountController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\ProductController;

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

Route::get('/', function () {
    return view('welcome');
});
Route::prefix('admin')->as('admin.')->group(function() {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');
 
});

Route::group(['prefix'=> 'account'], function() {
    route::get('/login',[AccountController::class, 'login'])->name('account.login');
    Route::get('/verify-account/{token}', [AccountController::class, 'verifyAccount'])->name('account.verify');
    route::post('/login',[AccountController::class, 'Check_login']);

    route::get('/rigester',[AccountController::class, 'rigester'])->name('account.rigester');
    route::post('/rigester',[AccountController::class, 'Check_rigester'])->name('account.Check_rigester');

    route::get('/profile',[AccountController::class, 'profile'])->name('account.profile');
    route::post('/profile',[AccountController::class, 'Check_profile']);

    route::get('/change_pass',[AccountController::class, 'change_pass'])->name('account.change_pass');
    route::post('/change_pass',[AccountController::class, 'Check_changePass']);

    route::get('/forgot_pass',[AccountController::class, 'forgot_pass'])->name('account.forgot_pass');
    route::post('/forgot_pass',[AccountController::class, 'Check_forgotPass']);

    route::get('/reset_pass',[AccountController::class, 'reset_pass'])->name('account.reset_pass');
    route::post('/reset_pass',[AccountController::class, 'Check_resetPass']);
});