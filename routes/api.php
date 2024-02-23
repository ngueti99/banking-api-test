<?php

use App\Http\Controllers\Api\V1\HomeController;
use App\Http\Controllers\Api\V1\TransactionController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/', HomeController::class);

Route::post('/user/register', [UserController::class, 'store']);
Route::post('/user/login', [UserController::class, 'login']);
Route::get('/user/unauthenticated', [UserController::class, 'show'])->name('unauthenticated');

Route::middleware(['auth:sanctum','role'])->group(function () {
    Route::post('/user/logout', [UserController::class, 'logout']);
    Route::get('/customer/search', [UserController::class, 'getCustomerByName']);
    Route::get('/customer/index', [UserController::class, 'index']);
    Route::post('/account/create', [UserController::class, 'createAccount']);

    Route::post('/transaction/store', [TransactionController::class, 'store']);
    Route::get('/transaction/balance/{id}', [TransactionController::class, 'getBalance']);
    Route::get('/transaction/history/{id}', [TransactionController::class, 'index']);
    Route::get('/transaction/historybytype', [TransactionController::class, 'getTransactionOnSpecifiqueType']);

});
