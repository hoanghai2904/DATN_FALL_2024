<?php

use App\Http\Controllers\Admin\CouponController;
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
    Route::get('users', 'UserController@index')->name('users')->middleware('manage');
    Route::post('user/new', 'UserController@new')->name('user_new')->middleware('manage');
    Route::post('user/delete', 'UserController@delete')->name('user_delete')->middleware('manage');
    Route::get('user/{id}/show', 'UserController@show')->name('user_show')->middleware('manage');
    Route::get('user/{id}/send', 'UserController@send')->name('user_send')->middleware('manage');

    Route::get('posts', 'PostController@index')->name('post.index');
    Route::get('post/new', 'PostController@new')->name('post.new');
    Route::post('post/save', 'PostController@save')->name('post.save');
    Route::post('post/delete', 'PostController@delete')->name('post.delete')->middleware('manage');
    Route::get('post/{id}/edit', 'PostController@edit')->name('post.edit');
    Route::post('post/{id}/update', 'PostController@update')->name('post.update');

    Route::get('advertises', 'AdvertiseController@index')->name('advertise.index');
    Route::get('advertise/new', 'AdvertiseController@new')->name('advertise.new');
    Route::post('advertise/save', 'AdvertiseController@save')->name('advertise.save');
    Route::post('advertise/delete', 'AdvertiseController@delete')->name('advertise.delete')->middleware('manage');
    Route::get('advertise/{id}/edit', 'AdvertiseController@edit')->name('advertise.edit');
    Route::post('advertise/{id}/update', 'AdvertiseController@update')->name('advertise.update');

    Route::get('products', 'ProductController@index')->name('product.index');
    Route::get('product/new', 'ProductController@new')->name('product.new');
    Route::post('product/save', 'ProductController@save')->name('product.save');
    Route::post('product/delete', 'ProductController@delete')->name('product.delete')->middleware('manage');
    Route::get('product/{id}/edit', 'ProductController@edit')->name('product.edit')->middleware('manage');
    Route::post('product/{id}/update', 'ProductController@update')->name('product.update')->middleware('manage');
    Route::post('promotion/delete', 'ProductController@delete_promotion')->name('product.delete_promotion');
    Route::post('product_detail/delete', 'ProductController@delete_product_detail')->name('product.delete_product_detail');
    Route::post('product/image/delete', 'ProductController@delete_image')->name('product.delete_image');

    Route::get('coupons', 'CouponController@index')->name('coupon.index');
    Route::get('coupon/new', 'CouponController@new')->name('coupon.new');
    Route::post('coupon/save', 'CouponController@save')->name('coupon.save');

    Route::post('coupon/delete', [CouponController::class, 'delete'])->name('coupon.delete')->middleware('manage');
    Route::get('coupon/{id}/edit', 'CouponController@edit')->name('coupon.edit');
    Route::post('coupon/{id}/update', 'CouponController@update')->name('coupon.update');

    Route::get('producers', 'ProducerController@index')->name('producer.index');
    Route::get('producer/new', 'ProducerController@new')->name('producer.new');
    Route::post('producer/save', 'ProducerController@save')->name('producer.save');
    Route::post('producer/delete', 'ProducerController@delete')->name('producer.delete')->middleware('manage');
    Route::get('producer/{id}/edit', 'ProducerController@edit')->name('producer.edit');
    Route::post('producer/{id}/update', 'ProducerController@update')->name('producer.update');

    Route::get('orders', 'OrderController@index')->name('order.index');
    Route::get('processing', 'OrderController@processing')->name('order.processing');
    Route::get('completed', 'OrderController@completed')->name('order.completed');
    Route::get('active/{id}/action/{action}', 'OrderController@actionTransaction')->name('orderTransaction');
    Route::get('order/{id}/show', 'OrderController@show')->name('order.show');

    Route::get('statistic', 'StatisticController@index')->name('statistic');
    Route::post('statistic/change', 'StatisticController@edit')->name('statistic.edit');

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
