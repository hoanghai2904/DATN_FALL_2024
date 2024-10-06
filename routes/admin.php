
<?php

use App\Http\Controllers\Admin\AdminAccountController;
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
    // Route cho trang login
    Route::get('login', [AdminAccountController::class, 'login'])->name('login');
    Route::post('login', [AdminAccountController::class, 'Check_login'])->name('Check_login');

    // Route cho dashboard và các resource chỉ sau khi đã đăng nhập
    Route::middleware('auth')->group(function () {
        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('dashboard');
        //Account to Admin
        //logout
        route::get('/logout', [AdminAccountController::class, 'logout'])->name('account.logout');
        
        //Create account by User
        route::get('/verify-account/{token}', [AdminAccountController::class, 'verifyAccount'])->name('account.verify');
        route::get('/rigester', [AdminAccountController::class, 'rigester'])->name('account.rigester');
        route::post('/rigester', [AdminAccountController::class, 'Check_rigester'])->name('account.Check_rigester');
        Route::get('/verify-account/{token}', [AdminAccountController::class, 'verifyAccount'])->name('account.verify');

        //Proffile
        route::get('/profile', [AdminAccountController::class, 'profile'])->name('account.profile');
        route::post('/profile', [AdminAccountController::class, 'Check_profile']);

        //Change password
        route::get('/change_pass', [AdminAccountController::class, 'change_pass'])->name('account.change_pass');
        route::post('/change_pass', [AdminAccountController::class, 'Check_changePass'])->name('account.Check_changePass');

        //Forgot password
        route::get('/forgot_pass', [AdminAccountController::class, 'forgot_pass'])->name('account.forgot_pass');
        route::post('/forgot_pass', [AdminAccountController::class, 'Check_forgotPass']);
    
        route::get('/reset_pass', [AdminAccountController::class, 'reset_pass'])->name('account.reset_pass');
        route::post('/reset_pass', [AdminAccountController::class, 'Check_resetPass']);
        //Ai làm cái gì thì ghi cmt lên trên này  
        Route::resource('categories', CategoryController::class);
        Route::resource('orders', OrderController::class);
        Route::resource('transactions', TransactionController::class);
        Route::resource('order-items', OrderItemController::class);
        Route::resource('order-statuses', OrderStatusController::class);
        Route::resource('cancelled-orders', CancelledOrderController::class);
        Route::resource('brands', BrandsController::class);
        Route::resource('vouchers', VoucherController::class);
        //banner
        Route::group(['prefix' => 'banners', 'as' => 'banners.'], function () {
        Route::get('list-banner', [BannerController::class, 'listBanner'])->name('listBanner');
        Route::get('add-banner', [BannerController::class, 'addBanner'])->name('addBanner');
        Route::post('add-banner', [BannerController::class, 'addPostBanner'])->name('addPostBanner');
        Route::get('detail-banner/{id}', [BannerController::class, 'detailBanner'])->name('detailBanner');
        Route::delete('delete-banner/{id}', [BannerController::class, 'deleteBanner'])->name('deleteBanner');
        Route::get('update-banner/{id}', [BannerController::class, 'updateBanner'])->name('updateBanner');
        Route::put('update-banner/{id}', [BannerController::class, 'updatePutBanner'])->name('updatePutBanner');
        });
        //Product
        Route::resource('products', ProductController::class);
        Route::get('/test-variant', function () {
            return view('admin.products.test');
        });
    });
});
