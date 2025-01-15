<?php

use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\pages\OrderTrackingController;

use App\Http\Controllers\Pages\ProductVoteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('active/{token}', 'Auth\RegisterController@activation')->name('active_account');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('admin')
  ->group(function () {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/dashboard/filter-products', [App\Http\Controllers\Admin\DashboardController::class, 'filterProducts'])
        ->name('admin.dashboard.filter-products');
    // Route::get('dashboard', 'DashboardController@dashboardData')->name('data.dashboard');

    Route::get('users', 'UserController@index')->name('users');
    Route::post('user/new', 'UserController@new')->name('user_new');
    Route::post('user/delete', 'UserController@delete')->name('user_delete');
    Route::get('user/{id}/show', 'UserController@show')->name('user_show');
    Route::get('user/{id}/send', 'UserController@send')->name('user_send');

    Route::post('/product-vote/{commentId}/reply', [UserController::class, 'storeReply'])->name('vote.reply');


    Route::get('posts', 'PostController@index')->name('post.index');
    Route::get('post/new', 'PostController@new')->name('post.new');
    Route::post('post/save', 'PostController@save')->name('post.save');
    Route::post('post/delete', 'PostController@delete')->name('post.delete');
    Route::get('post/{id}/edit', 'PostController@edit')->name('post.edit');
    Route::post('post/{id}/update', 'PostController@update')->name('post.update');
    Route::post('/update-post-status/{id}', 'PostController@updateStatus')->name('post.updateStatus');

    Route::get('advertises', 'AdvertiseController@index')->name('advertise.index');
    Route::get('advertise/new', 'AdvertiseController@new')->name('advertise.new');
    Route::post('advertise/save', 'AdvertiseController@save')->name('advertise.save');
    Route::post('advertise/delete', 'AdvertiseController@delete')->name('advertise.delete');
    Route::get('advertise/{id}/edit', 'AdvertiseController@edit')->name('advertise.edit');
    Route::post('advertise/{id}/update', 'AdvertiseController@update')->name('advertise.update');


    // Product_new

    Route::get('Product_new', [ProductsController::class, 'index'])->name('products.index');
    Route::get('Product_new/new', [ProductsController::class, 'new'])->name('products.new');
    Route::post('Product_new/save', [ProductsController::class, 'save'])->name('products.save');
    Route::post('Product_new/delete', [ProductsController::class, 'delete'])->name('products.delete');
    Route::get('Product_new/{id}/edit', [ProductsController::class, 'edit'])->name('products.edit');
    Route::post('Product_new/{id}/update', [ProductsController::class, 'update'])->name('products.update');
    Route::post('promotions/delete', [ProductsController::class, 'delete_promotion'])->name('products.delete_promotion');
    Route::post('Product_new_detail/delete', [ProductsController::class, 'delete_product_detail'])->name('products.delete_product_detail');
    Route::post('Product_new/image/delete', [ProductsController::class, 'deleteImage'])->name('products.delete_image');

    // Thuộc tính
    Route::get('attributes', [AttributeController::class, 'index'])->name('attributes.index');
    Route::get('attributes/create', [AttributeController::class, 'create'])->name('attributes.create');
    Route::post('attributes', [AttributeController::class, 'store'])->name('attributes.store');
    Route::get('attributes/{id}/edit', [AttributeController::class, 'edit'])->name('attributes.edit');
    Route::put('attributes/{id}', [AttributeController::class, 'update'])->name('attributes.update');
    Route::delete('attributes/{id}', [AttributeController::class, 'destroy'])->name('attributes.destroy');
    Route::get('attributes/{id}/values', [AttributeController::class, 'getAttributeValues'])->name('attributes.values');




    Route::get('coupons', 'CouponController@index')->name('coupon.index');
    Route::get('coupon/new', 'CouponController@new')->name('coupon.new');
    Route::post('coupon/save', 'CouponController@save')->name('coupon.save');
    Route::post('coupon/delete', 'CouponController@delete')->name('coupon.delete');
    Route::get('coupon/{id}/edit', 'CouponController@edit')->name('coupon.edit');
    Route::post('coupon/{id}/update', 'CouponController@update')->name('coupon.update');

    Route::get('producers', 'ProducerController@index')->name('producer.index');
    Route::get('producer/new', 'ProducerController@new')->name('producer.new');
    Route::post('producer/save', 'ProducerController@save')->name('producer.save');
    Route::post('producer/delete', 'ProducerController@delete')->name('producer.delete');
    Route::get('producer/{id}/edit', 'ProducerController@edit')->name('producer.edit');
    Route::post('producer/{id}/update', 'ProducerController@update')->name('producer.update');

    Route::get('orders', 'OrderController@index')->name('order.index');
    Route::get('processing', 'OrderController@processing')->name('order.processing');
    Route::get('completed', 'OrderController@completed')->name('order.completed');
    Route::get('active/{id}/action/{action}', 'OrderController@actionTransaction')->name('orderTransaction');
    Route::get('order/{id}/show', 'OrderController@show')->name('order.show');

    // Route::get('statistic', 'StatisticController@index')->name('statistic');
    Route::get('statistic/change', 'StatisticController@edit')->name('statistic.edit');

    route::get('warehouse', 'WarehouseController@index')->name('warehouse');
    route::get('orderDetails', 'WarehouseController@orderDetails')->name('orderDetails');
  });

Route::namespace('Pages')->group(function () {
  Route::get('/', 'HomePage')->name('home_page');
  Route::get('coupons', 'CouponController@index')->name('coupon_page');
  Route::get('about', 'AboutPage')->name('about_page');
  Route::get('contact', 'ContactPage')->name('contact_page');
  Route::get('search', 'SearchController')->name('search');
  Route::get('posts', 'PostController@index')->name('posts_page');
  Route::get('post/{id}', 'PostController@show')->name('post_page');
  Route::get('orders', 'OrderController@index')->name('orders_page');
  Route::get('order/{id}', 'OrderController@show')->name('order_page');
  Route::post('cancel-order/{id}', 'OrderController@cancelOrder')->name(name: 'cancelOrder');
  Route::post('order/return/{id}', 'OrderController@returnOrder')->name('returnOrder');
  Route::post('payment-now/{id}', 'CartController@paymentNow')->name(name: 'payment_now');
  Route::post('recive-order/{id}', 'OrderController@reciveOrder')->name(name: 'receive_order');

  Route::get('tracking', [OrderTrackingController::class, 'index'])->name('tracking');
  Route::post('search', action: [OrderTrackingController::class, 'searchOrder'])->name('search');

  Route::get('/reviews/{id}', [ProductVoteController::class, 'index'])->name('review.index');
  Route::post('/review/store', [ProductVoteController::class, 'store'])->name('review.store');

  Route::get('user/profile', 'UserController@show')->name('show_user');
  Route::get('user/edit', 'UserController@edit')->name('edit_user');
  Route::post('user/save', 'UserController@save')->name('save_user');
  // change passwordd
  Route::get('user/editPassword', 'UserController@changePass')->name('edit_Password');
  Route::post('user/savePassword', 'UserController@savePass')->name('save_Password');
  //page products
  Route::get('products', 'ProductsController@index')->name('products_page');
  Route::get('producer/{id}', 'ProductsController@getProducer')->name('producer_page');
  Route::get('product/{id}', 'ProductsController@getProduct')->name('product_page');
  Route::post('vote', 'ProductsController@addVote')->name('add_vote');
  Route::post('cart/add', 'CartController@addCart')->name('add_cart');
  Route::post('cart/remove', 'CartController@removeCart')->name('remove_cart');
  Route::post('minicart/update', 'CartController@updateMiniCart')->name('update_minicart');
  Route::post('cart/update', 'CartController@updateCart')->name('update_cart');
  Route::post('update-fee', 'CartController@updateFee')->name('update_fee');
  Route::get('cart', 'CartController@showCart')->name('show_cart');
  Route::post('checkout', 'CartController@showCheckout')->name('show_checkout');
  Route::post('payment', 'CartController@payment')->name('payment');
  Route::get('payment/response', 'CartController@responsePayment')->name('payment_response');
  Route::get('/user-coupons', 'CouponController@getUserCoupons')->name('user_coupons');
  Route::post('/validate-coupon', 'CouponController@validateCoupon')->name('validate_coupon');
  Route::post('/save-coupon', 'CouponController@saveCoupon')->name('save.coupon');
  Route::post('send-contact', 'ContactController@sendContact')->name('send_contact');
  Route::post('/toggle-wishlist', 'ProductsController@toggleWishlist')->name('toggle_wishlist');
  Route::get('show-wishlist', 'ProductsController@showWishlist')->name('show_wishlist');
});

Route::fallback(function () {
  abort(404, 'Trang không tồn tại');
});

Route::get('/admin/dashboard/filter-products', [DashboardController::class, 'filterProducts'])
    ->name('admin.dashboard.filter-products');