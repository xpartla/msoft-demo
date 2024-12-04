<?php

use App\Http\Controllers\AssignController;
use App\Http\Controllers\ListController;
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

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/list', [ListController::class, 'index']);


Route::get('/list', [ListController::class, 'index']);
Route::post('/get-order-detail', [ListController::class, 'getOrderDetail']);
Route::post('/update-order-time', [ListController::class, 'updateOrderTime']);
Route::post('/show-error-message', [ListController::class, 'showErrorMessage']);


Route::get('/customer-pov', [ListController::class, 'customerPov'])->name('customer.pov');
Route::get('/courier-pov', [ListController::class, 'courierPov'])->name('courier.pov');

Route::get('/assign', [AssignController::class, 'index']);
Route::get('/assign-and-pickup', [AssignController::class, 'index'])->name('assign-and-pickup');
Route::post('/make-available', [AssignController::class, 'makeAvailable'])->name('make-available');
Route::get('/courier-availability', [AssignController::class, 'courierAvailability'])->name('courier-availability');
Route::post('/accept-order', [OrderController::class, 'acceptOrder'])->name('accept-order');

Route::post('/courier-preaccept', [OrderController::class, 'prepareAcceptOrder'])->name('courier-preaccept');
Route::post('/courier-accepted', [OrderController::class, 'cacceptOrder'])->name('courier-accepted');

Route::post('/assign', [AssignController::class, 'cancelOrder'])->name('assign');
Route::post('/orderIsPrepared', [AssignController::class, 'isPrepared'])->name('orderIsPrepared');
Route::post('/markAsPickedUp', [AssignController::class, 'markAsPickedUp'])->name('markAsPickedUp');

Route::get('/two-orders', [OrderController::class, 'twoOrders']);
Route::post('/acceptOrder', [OrderController::class, 'courierAcceptOrder'])->name('acceptOrder');
Route::post('/nearbyOrder', [OrderController::class, 'checkNearbyOrders'])->name('nearbyOrder');

Route::post('/acceptSecondOrder', [OrderController::class, 'courierAcceptSecondOrder'])->name('acceptSecondOrder');
Route::post('/declineSecondOrder', [OrderController::class, 'courierDeclineSecondOrder'])->name('declineSecondOrder');

Route::post('/changeState', [OrderController::class, 'changeState'])->name('changeState');

Route::post('/nearbyOrderIsPrepared', [OrderController::class, 'nearbyOrderIsPrepared'])->name('nearbyOrderIsPrepared');
