<?php

use App\Http\Controllers\Admin\AdminAccountController;
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
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\VoucherController;
use App\Models\Category;
use App\Http\Controllers\ContactController;
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
        
       //Dashboard
        route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        //Account to Admin
        //logout
        route::get('/logout', [AdminAccountController::class, 'logout'])->name('logout');

        //Create account by User
        route::get('/rigester', [AdminAccountController::class, 'rigester'])->name('rigester');
        route::post('/rigester', [AdminAccountController::class, 'Check_rigester'])->name('Check_rigester');
        Route::get('/verify-account/{token}', [AdminAccountController::class, 'verifyAccount'])->name('.verify');

        //Proffile
        route::get('/profile', [AdminAccountController::class, 'profile'])->name('profile');
        route::post('/profile', [AdminAccountController::class, 'Check_profile'])->name('Check_profile');
        Route::get('/profile/{provinceId}', [AdminAccountController::class, 'getDistricts'])->name('getDistricts');
        Route::get('/wards/{districtId}', [AdminAccountController::class, 'getWards'])->name('wards');
        Route::post('/profile/store', [AdminAccountController::class, 'store'])->name('addAddress');

        //Change password
        route::post('/change_pass', [AdminAccountController::class, 'Check_changePass'])->name('Check_changePass');

        //Forgot password
        route::get('/forgot_pass', [AdminAccountController::class, 'forgot_pass'])->name('forgot_pass');
        route::post('/forgot_pass', [AdminAccountController::class, 'Check_forgotPass']);

        route::get('/reset_pass', [AdminAccountController::class, 'reset_pass'])->name('reset_pass');
        route::post('/reset_pass', [AdminAccountController::class, 'Check_resetPass']);

        //Khách hàng (cusstomer)
        route::get('/cusstomer', [AdminUserController::class, 'listCusstomer'])->name('listCusstomer');
        Route::delete('/customer/{id}', [AdminUserController::class, 'deleteCustomer'])->name('deleteCustomer');
        Route::post('/customer/{id}', [AdminUserController::class, 'updateStatus'])->name('updateStatus');

        //user
        route::get('/user', [AdminUserController::class, 'listUser'])->name('listUser');
        Route::post('/user', [AdminUserController::class, 'addUser'])->name('addUser');
        Route::get('/user/{id}', [AdminUserController::class, 'showUser'])->name('showUser');
        Route::put('/user/{user}/edit', [AdminUserController::class, 'updateUser'])->name('updateUser');
        Route::delete('/users/{id}', [AdminUserController::class, 'destroyUser'])->name('destroyUser');

        //Role user
        route::get('/role', [AdminUserController::class, 'listRole'])->name('listRole');
        route::post('/role', [AdminUserController::class, 'store'])->name('addRole');
        route::delete('/role/{id}', [AdminUserController::class, 'deleteRole'])->name('deleteRole');
        Route::post('/role/{id}', [AdminUserController::class, 'updateStatusRole'])->name('updateStatusRole');
        Route::get('/roles/{id}/edit', [AdminUserController::class, 'edit'])->name('roles.edit');
        Route::put('/roles/{role}/edit', [AdminUserController::class, 'update'])->name('roles.update');

        // address
        Route::get('/cusstomer/{userId}', [AdminUserController::class, 'getAddresses'])->name('getAddresses');
       

        //Ai làm cái gì thì ghi cmt lên trên này  
        Route::resource('categories', CategoryController::class);
        Route::resource('orders', OrderController::class);
        Route::resource('transactions', TransactionController::class);
        Route::resource('order-items', OrderItemController::class);
        Route::resource('order-statuses', OrderStatusController::class);
        Route::resource('cancelled-orders', CancelledOrderController::class);
         Route::resource('contacts', ContactController::class);
         Route::get('contacts/{contact}/reply', [ContactController::class, 'reply'])->name('contacts.reply');
         Route::post('contacts/{contact}/reply', [ContactController::class, 'sendResponse'])->name('contacts.sendResponse');
         Route::get('/invoices/{id}/invoice', [OrderController::class, 'showInvoice'])->name('orders.invoice');

        Route::resource('brands', BrandsController::class);
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
            Route::get('update-banner/{id}', [BannerController::class, 'updateBanner'])->name('updateBanner');
            Route::put('update-banner/{id}', [BannerController::class, 'updatePutBanner'])->name('updatePutBanner');
            Route::post('update-status/{id}', [BannerController::class, 'updateStatusBanner'])->name('updateStatusBanner');
            Route::put('change-status', [BannerController::class, 'changeStatus'])->name('change-status');
        });
        Route::group(['prefix' => 'comments', 'as' => 'comments.'], function () {
            Route::get('list-comment', [CommentController::class, 'listComment'])->name('listComment');
            Route::delete('delete-comment/{id}', [CommentController::class, 'deleteComment'])->name('deleteComment');
            Route::put('change-status', [CommentController::class, 'changeStatus'])->name('change-status');
        });
        // Sản phẩm
        Route::put('change-status', [ProductController::class, 'changeStatus'])->name('product.change-status');
        Route::resource('products', ProductController::class);
        Route::get('/test-variant', function () {
            return view('admin.products.test');
        });
        Route::get('/product/{id}/variations', [ProductController::class, 'manageVariations'])->name('product.variations.manage');
        Route::post('/product/{id}/variations/generate', [ProductController::class, 'generateVariations'])->name('product.variations.generate');
        Route::put('/product/{id}/variations/update', [ProductController::class, 'updateVariations'])->name('product.variations.update');
    });
});
