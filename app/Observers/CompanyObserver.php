<?php

namespace App\Observers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CompanyObserver
{


  /**
   * Handle the Company "creating" event.
   */
  public function creating(Company $company): void
  {
    $email = request()->input('user_email') ?? request()->input('email');
    $password = request()->input('password');
    $phone = request()->input('phone_number');
    $companyName = $company->company_name ?: 'شركة جديدة';

    if ($email) {
      $user = User::create([
        'name'         => $companyName,
        'email'        => $email,
        'phone_number' => $phone,
        'password'     => filled($password) ? $password : Hash::make('12345678'),
      ]);

      $company->user_id = $user->id;
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
    if ($company->user) {
      $dataToUpdate = [];

      $userEmail = request()->input('user_email') ?? request()->input('email');
      if (filled($userEmail)) {
        $dataToUpdate['email'] = $userEmail;
      } elseif ($company->isDirty('email')) {
        $dataToUpdate['email'] = $company->email;
      }

      $password = request()->input('password');
      if (filled($password)) {
        $dataToUpdate['password'] = $password;
      }

      $phone = request()->input('phone_number');
      if (filled($phone)) {
        $dataToUpdate['phone_number'] = $phone;
      } elseif ($company->isDirty('phone_number')) {
        $dataToUpdate['phone_number'] = $company->phone_number;
      }

      if (!empty($dataToUpdate)) {
        $company->user->update($dataToUpdate);
      }
    }

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
