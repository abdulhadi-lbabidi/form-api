<?php

use App\Http\Controllers\Api\AccountUpgradeRequestController;
use App\Http\Controllers\Api\ApplyJobController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\CashbackCategoryController;
use App\Http\Controllers\Api\CashBackController;
use App\Http\Controllers\Api\CashBackDealController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\CompanyJobHostingController;
use App\Http\Controllers\Api\KadrJobHostingController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\MarketingSourceController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\TimeController;
use App\Http\Controllers\Api\WorkerController;
use Illuminate\Support\Facades\Route;


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


Route::middleware('auth:sanctum')->group(function () {

  Route::get('cashback-deals', [CashBackDealController::class, 'index']);
  Route::get('cashback-deals/{cashbackDeal}', [CashBackDealController::class, 'show']);
  Route::post('cashback-deals/{cashbackDeal}/interact', [CashBackDealController::class, 'interact']);

  Route::get('cashback-categories', [CashbackCategoryController::class, 'index']);
  Route::get('cashback-categories/{cashbackCategory}', [CashbackCategoryController::class, 'show']);


  Route::get('cashbacks', [CashBackController::class, 'index']);
  Route::get('cashbacks/{cashback}', [CashBackController::class, 'show']);

  Route::get('apply-jobs', [ApplyJobController::class, 'index']);
  Route::post('apply-jobs', [ApplyJobController::class, 'store']);
  Route::get('apply-jobs/{applyJob}', [ApplyJobController::class, 'show']);
});


/*
|--------------------------------------------------------------------------
| Public API (NO AUTH)
|--------------------------------------------------------------------------
*/

Route::middleware(['setLocale'])->group(function () {

  Route::apiResource('companies', CompanyController::class);
  Route::apiResource('company-job-hostings', CompanyJobHostingController::class);
  Route::apiResource('kadr-job-hostings', KadrJobHostingController::class);
  Route::apiResource('workers', WorkerController::class);
  Route::apiResource('times', TimeController::class);
  Route::apiResource('marketing-sources', MarketingSourceController::class);
  Route::apiResource('subscriptions', SubscriptionController::class);

  Route::apiResource('account-upgrade-requests', AccountUpgradeRequestController::class);

  Route::get('categories', [CategoryController::class, 'index']);

  Route::get('locations', [LocationController::class, 'index']);
});
