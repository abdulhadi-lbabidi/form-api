<?php

namespace App\Providers;

use App\Models\Company;
use App\Models\Expense;
use App\Models\Kadr;
use App\Models\Revenue;
use App\Models\Worker;
use App\Observers\CompanyObserver;
use App\Observers\ExpenseObserver;
use App\Observers\KadrObserver;
use App\Observers\RevenueObserver;
use App\Observers\WorkerObserver;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;


class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {

    RateLimiter::for('filament.auth.login', function (Request $request) {
      return Limit::perMinute(15)->by($request->ip());
    });


    Company::observe(CompanyObserver::class);
    Worker::observe(WorkerObserver::class);
    Kadr::observe(KadrObserver::class);
    Expense::observe(ExpenseObserver::class);
    Revenue::observe(RevenueObserver::class);
  }
}
