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
Route::post('/register', Controllers\RegisterController::class);
Route::post('/login',Controllers\LoginController::class);

// Private Routes
Route::middleware(['middleware' => 'auth:sanctum'])->group(function() {
    Route::post('/logout', Controllers\LogoutController::class);
});
