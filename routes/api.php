<?php

use App\Http\Controllers;
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

// Public Routes
Route::post('/register', Controllers\Auth\RegisterController::class);
Route::post('/login', Controllers\Auth\LoginController::class);

// Private Routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', Controllers\Auth\LogoutController::class);

    Route::prefix('loan')->group(function () {
        Route::middleware(['customer'])->group(function () {
            Route::post('/request', Controllers\Loan\LoanRequestController::class);
        });
        Route::middleware(['admin'])->group(function () {
            Route::post('/{loan}/approve', Controllers\Loan\LoanApproveController::class);
            Route::post('/{loan}/decline', Controllers\Loan\LoanDeclineController::class);
        });
    });

    Route::prefix('repayment')->middleware(['customer'])->group(function () {
        Route::post('/{repayment}/repay', Controllers\Repayment\RepaymentPayController::class);
    });
});
