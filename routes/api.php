<?php

use App\Http\Controllers\V1\AuthController;
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

Route::prefix('v1')->group(function() {
    Route::prefix('auth')->group(function () {
        Route::post('register', [AuthController::class, 'postRegister'])->name('v1.auth.register');
        Route::post('login', [AuthController::class, 'postLogin'])->name('v1.auth.login');
        Route::post('recovery', [AuthController::class, 'postRecovery'])->name('v1.auth.recovery');
        Route::get('/validate-token/{token}', [AuthController::class, 'getTokenValidation'])->name('v1.auth.validate-token');
        Route::post('/reset', [AuthController::class, 'postReset'])->name('v1.auth.reset-password');
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
