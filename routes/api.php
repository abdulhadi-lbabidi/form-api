<?php

use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\TimeController;
use App\Http\Controllers\Api\WorkerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/user', function (Request $request) {
  return $request->user();
})->middleware('auth:sanctum');




Route::apiResource('companies', CompanyController::class);
Route::apiResource('workers', WorkerController::class);
Route::apiResource('times', TimeController::class);
Route::apiResource('subscriptions', SubscriptionController::class);
