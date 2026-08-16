<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\MarketingSourceController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\TimeController;
use App\Http\Controllers\Api\WorkerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| Authentication APIs (Public & Protected)
|--------------------------------------------------------------------------
*/

Route::prefix('auth')->group(function () {
  Route::post('/login', [AuthController::class, 'login']);
  Route::post('/update-password', [AuthController::class, 'updatePassword']);

  Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
  });
});


/*
|--------------------------------------------------------------------------
| Public API (NO AUTH)
|--------------------------------------------------------------------------
*/

Route::middleware(['setLocale'])->group(function () {
  Route::apiResource('companies', CompanyController::class);
  Route::apiResource('workers', WorkerController::class);
  Route::apiResource('times', TimeController::class);
  Route::apiResource('marketing-sources', MarketingSourceController::class);
  Route::apiResource('subscriptions', SubscriptionController::class);
});
