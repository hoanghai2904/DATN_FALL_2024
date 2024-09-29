<?php


use App\Http\Controllers\OrderController;


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
    Route::resource('orders',OrderController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('order-items', OrderItemController::class);
    Route::resource('order-statuses', OrderStatusController::class);
    Route::resource('cancelled-orders', CancelledOrderController::class);
    
    

});
