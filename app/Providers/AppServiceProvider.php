<?php

namespace App\Providers;

use App\Models\Company;
use App\Models\Worker;
use App\Observers\CompanyObserver;
use App\Observers\WorkerObserver;
use Illuminate\Support\ServiceProvider;

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
    Company::observe(CompanyObserver::class);
    Worker::observe(WorkerObserver::class);
  }
}