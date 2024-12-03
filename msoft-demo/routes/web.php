<?php

use App\Http\Controllers\ListController;
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

Route::get('/customer-pov', [ListController::class, 'customerPov'])->name('customer.pov');
Route::get('/courier-pov', [ListController::class, 'courierPov'])->name('courier.pov');
