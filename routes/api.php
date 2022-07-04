<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/payment/credit-card', [PaymentController::class, 'processCreditCard'])
    ->name('payment.process.credit-card');

Route::post('/payment/ticket', [PaymentController::class, 'processTicket'])
    ->name('payment.process.ticket');
