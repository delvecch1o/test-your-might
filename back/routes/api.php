<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\WalletController;

Route::post('auth/user', [ AuthController::class, 'User']);
Route::post('auth/retailer', [ AuthController::class, 'Retailer']);

Route::post('login/{provider}', [ AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    
    Route::post('logout', [AuthController::class, 'logout']);
    
    Route::post('wallet', [WalletController::class, 'create']);
    Route::get('wallet/show', [WalletController::class, 'show']);
  

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
