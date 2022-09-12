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
Route::post('/register', Controllers\Auth\RegisterController::class)->name('auth.register');
Route::post('/login', Controllers\Auth\LoginController::class)->name('auth.login');

// Private Routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', Controllers\Auth\LogoutController::class)->name('auth.logout');
    // admin -> 2|kG7mG7AK0cq0aJFoKUbD1WuX6eSkazPuWN41uw2u
    // customer (usama2) -> 3|BHfI5w7tNPGX0QlgzdKEWpgAzT42AA0EFLcRn6rb
    // customer (usama3) -> 4|R2ULOqRnoMxpINvnp6LwdZX00vS2iFzqLIpXD6gt
    Route::prefix('loan')->group(function () {
        Route::middleware(['customer'])->group(function () {
            Route::post('/request', Controllers\Loan\LoanRequestController::class)->name('customer.loan.request');
        });
        Route::middleware(['admin'])->group(function () {
            Route::get('/', Controllers\Loan\LoanListController::class)->name('admin.loan.list');
            Route::post('/{loan}/approve', Controllers\Loan\LoanApproveController::class)->name('admin.loan.approve');
            Route::post('/{loan}/decline', Controllers\Loan\LoanDeclineController::class)->name('admin.loan.decline');
        });
        Route::get('/{loan}', Controllers\Loan\LoanShowController::class)->name('loan.show');
    });

    Route::prefix('repayment')->middleware(['customer'])->group(function () {
        Route::post('/{repayment}/repay', Controllers\Repayment\RepaymentPayController::class)->name('customer.repayment.repay');
    });
});
