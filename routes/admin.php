<?php

use App\Http\Controllers\Admin\AdminAccountController;
use App\Http\Controllers\admin\CategoryController_;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\admin\ProductVariantController;
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
use App\Http\Controllers\PostController;
use App\Http\Controllers\VoucherController;
use App\Models\Category;
use App\Http\Controllers\ContactController;



Route::prefix('admin')->as('admin.')->group(function () {
    // Route cho trang login
    Route::get('login', [AdminAccountController::class, 'login'])->name('login');
    Route::post('login', [AdminAccountController::class, 'Check_login'])->name('Check_login');

      //Forgot password
      route::get('/forgot_pass', [AdminAccountController::class, 'forgot_pass'])->name('forgotPass');
      route::post('/forgot_pass', [AdminAccountController::class, 'Check_forgotPass'])->name('CheckForgotPass');

      route::get('/reset_pass/{token}', [AdminAccountController::class, 'reset_pass'])->name('reset_pass');
      route::post('/reset_pass/{token}', [AdminAccountController::class, 'Check_resetPass'])->name('Check_resetPass');

    // Route cho dashboard và các resource chỉ sau khi đã đăng nhập
    Route::middleware('auth')->group(function () {

        //Dashboard
        route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/order-data', [DashboardController::class, 'dashboard'])->name('dashboard');

        //Account to Admin
        //logout
        route::get('/logout', [AdminAccountController::class, 'logout'])->name('logout');

        //Create account to User
        route::get('/rigester', [AdminAccountController::class, 'rigester'])->name('rigester');
        route::post('/rigester', [AdminAccountController::class, 'Check_rigester'])->name('Check_rigester');
        Route::get('/verify-account/{token}', [AdminAccountController::class, 'verifyAccount'])->name('.verify');

        //Proffile
        route::get('/profile', [AdminAccountController::class, 'profile'])->name('profile');
        route::post('/profile', [AdminAccountController::class, 'Check_profile'])->name('Check_profile');


        //Change password
        route::post('/change_pass', [AdminAccountController::class, 'Check_changePass'])->name('Check_changePass');

      

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
        Route::get('/Districts/{provinceId}', [AdminUserController::class, 'getDistricts'])->name('getDistricts');
        Route::get('/wards/{districtId}', [AdminUserController::class, 'getWards'])->name('wards');
        Route::post('/profile/store', [AdminUserController::class, 'storeadd'])->name('addAddress');

        //Ai làm cái gì thì ghi cmt lên trên này  
        Route::resource('orders', OrderController::class);
        Route::put('/orders/{id}', [OrderController::class, 'update'])->name('updateOrder');
        Route::delete('/order/{id}', [OrderController::class, 'destroyOrder'])->name('destroyOrder');
        Route::resource('transactions', TransactionController::class);
        Route::resource('order-items', OrderItemController::class);
        Route::resource('order-statuses', OrderStatusController::class);
        Route::resource('cancelled-orders', CancelledOrderController::class);
        //contact
        Route::resource('contacts', ContactController::class);
        Route::get('contacts/{contact}/reply', [ContactController::class, 'reply'])->name('contacts.reply');
        Route::post('contacts/{contact}/reply', [ContactController::class, 'sendResponse'])->name('contacts.sendResponse');
        Route::post('contacts/{contact}/sendResponse', [ContactController::class, 'sendResponse'])->name('contacts.sendResponse');
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
            Route::put('update-status', [VoucherController::class, 'updateStatus'])->name('updateStatus');
        });
        Route::group(['prefix' => 'posts', 'as' => 'posts.'], function () {
            Route::get('/', [PostController::class, 'index'])->name('index');
            Route::get('create', [PostController::class, 'create'])->name('create');
            Route::post('store', [PostController::class, 'store'])->name('store');
            Route::delete('destroy/{id}', [PostController::class, 'destroy'])->name('destroy');
            Route::get('{id}', [PostController::class, 'show'])->name('show');
            Route::get('edit/{id}', [PostController::class, 'edit'])->name('edit');
            Route::put('updater/{id}', [PostController::class, 'update'])->name('update');
            Route::put('update-status', [PostController::class, 'updateStatus'])->name('updateStatus');
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


        // Categories
        Route::put('/categories/change-status', [CategoryController_::class, 'changeStatus'])->name('category.change-status');
        Route::resource('categories_',CategoryController_::class);
        Route::group(['prefix' => 'categories', 'as' => 'categories.'], function () {
            Route::get('/', [CategoryController::class, 'show'])->name('listCategory');
            Route::get('/category-add', [CategoryController::class, 'addCategory'])->name('addCategory');
            Route::post('/list-add', [CategoryController::class, 'addPostCategory'])->name('addPostCategory');
            Route::delete('/delete-catgegory/{id}', [CategoryController::class, 'deleteCategory'])->name('deleteCategory');
            Route::post('/restore-catgegory/{id}', [CategoryController::class, 'restoreCategory'])->name('restoreCategory');
            Route::get('/update/{id}', [CategoryController::class, 'updateCategory'])->name('updateCategory');
            Route::put('/update/{id}', [CategoryController::class, 'updatePutCategory'])->name('updatePutCategory');
        });
        // Sản phẩm
        Route::put('change-status', [ProductController::class, 'changeStatus'])->name('product.change-status');
        Route::get('products/get-variant-value', [ProductController::class, 'getVariantValue'])->name('products.value');
        Route::resource('products', ProductController::class);
        
        
        Route::put('/variants/change-status', [ProductVariantController::class, 'changeStatus'])->name('product-variant.change-status');
        Route::resource('variants', ProductVariantController::class);
    });
});
