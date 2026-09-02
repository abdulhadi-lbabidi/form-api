<?php

namespace App\Observers;

use App\Models\Company;
use Illuminate\Support\Str;

class CompanyObserver
{


  /**
   * Handle the Company "creating" event.
   */
  public function creating(Company $company): void
  {
    if (empty($company->password)) {
      $company->password = '12345678';
    }
  }


  /**
   * Handle the Company "created" event.
   */
  public function created(Company $company): void
  {
    $company->referralCode()->create([
      'usage_limit' => 100,
      'times_used'  => 0,
      'is_active'   => true,
      'expires_at'  => null,
    ]);

    $company->branches()->create([
      'branch_name'      => 'أساسي',
      'location_address' => null,
    ]);
  }

  /**
   * Handle the Company "updating" event.
   */
  public function updating(Company $company): void
  {

    if ($company->isDirty('is_verified') && $company->is_verified && !$company->code) {
      do {
        $generatedCode = 'COMP-' . Str::upper(Str::random(10));
      } while (Company::where('code', $generatedCode)->exists());

      $company->code = $generatedCode;
    }
  }

  /**
   * Handle the Company "updated" event.
   */
  public function updated(Company $company): void
  {
    //
  }

  /**
   * Handle the Company "deleted" event.
   */
  public function deleted(Company $company): void
  {
    //
  }

  /**
   * Handle the Company "restored" event.
   */
  public function restored(Company $company): void
  {
    //
  }

  /**
   * Handle the Company "force deleted" event.
   */
  public function forceDeleted(Company $company): void
  {
    //
  }
}
